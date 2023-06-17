<?php

namespace BarnsleyHQ\SimplePush\Tests;

use BarnsleyHQ\SimplePush\Providers\SimplePushServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase as Base;

abstract class TestCase extends Base
{
    public MockHandler $httpMockHandler;

    public Client $http;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpHttp();
    }

    protected function getPackageProviders($app)
    {
        return [
            SimplePushServiceProvider::class,
        ];
    }

    protected function setUpHttp(): void
    {
        Http::preventStrayRequests();

        $this->httpMockHandler = new MockHandler([
            new Response(200, [], '{"message": "Hello, World"}'),
        ]);

        $handlerStack = HandlerStack::create($this->httpMockHandler);

        $this->http = new Client(['handler' => $handlerStack]);
    }
}
