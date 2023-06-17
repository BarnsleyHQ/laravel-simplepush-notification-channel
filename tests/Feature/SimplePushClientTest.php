<?php

use BarnsleyHQ\SimplePush\SimplePushClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

it('should create a new instance with a client', function () {
    $instance = new SimplePushClient();

    expect($instance)->toBeInstanceOf(SimplePushClient::class);
    expect($instance->client)->toBeInstanceOf(Client::class);
});

it('should create a new instance with a different client', function () {
    $client = new Client();
    $instance = SimplePushClient::withClient($client);

    expect($instance)->toBeInstanceOf(SimplePushClient::class);
    expect($instance->client)->toBe($client);
});

it('should perform a post request', function () {
    $httpMockHandler = new MockHandler([
        'https://api.simplepush.io/test' => new Response(200, [], '{"test-post":true}'),
    ]);

    $handlerStack = HandlerStack::create($httpMockHandler);

    $client = new Client(['handler' => $handlerStack]);

    $instance = SimplePushClient::withClient($client);

    expect($instance->post('/test'))->toBe(['test-post' => true]);
});

it('should perform a get request', function () {
    $httpMockHandler = new MockHandler([
        'https://api.simplepush.io/test' => new Response(200, [], '{"test-get":true}'),
    ]);

    $handlerStack = HandlerStack::create($httpMockHandler);

    $client = new Client(['handler' => $handlerStack]);

    $instance = SimplePushClient::withClient($client);

    expect($instance->get('/test'))->toBe(['test-get' => true]);
    expect($httpMockHandler->getLastRequest()->getUri()->getPath())->toBe('/test');
});

it('should perform a get request with data', function () {
    $httpMockHandler = new MockHandler([
        'https://api.simplepush.io/test?test=1' => new Response(200, [], '{"test-get":true}'),
    ]);

    $handlerStack = HandlerStack::create($httpMockHandler);

    $client = new Client(['handler' => $handlerStack]);

    $instance = SimplePushClient::withClient($client);

    expect($instance->get('/test', ['test' => 1, 'query' => 'test-value']))->toBe(['test-get' => true]);
    expect($httpMockHandler->getLastRequest()->getUri()->getPath())->toBe('/test');
    expect($httpMockHandler->getLastRequest()->getUri()->getQuery())->toBe('test=1&query=test-value');
});
