<?php

namespace BarnsleyHQ\SimplePush\Channels;

use BarnsleyHQ\SimplePush\Exceptions\MissingToSimplePushMethodException;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class SimplePushChannel
{
    /**
     * The HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Create a new Slack channel instance.
     *
     * @param  \GuzzleHttp\Client  $http
     * @return void
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Send SimplePush notification
     *
     * @param mixed $notifiable
     * @param mixed $notification
     * @return ResponseInterface|null
     * @throws MissingToSimplePushMethodException
     */
    public function send($notifiable, $notification)
    {
        if (! method_exists($notification, 'toSimplePush')) {
            throw new MissingToSimplePushMethodException();
        }

        return $notification->toSimplePush($notifiable)
            ->send($this->http);
    }
}
