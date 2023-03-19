<?php

namespace BarnsleyHQ\SimplePush\Channels;

use BarnsleyHQ\SimplePush\Contracts\SimplePushNotification;
use BarnsleyHQ\SimplePush\Messages\SimplePushMessage;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class SimplePushChannel
{
    const API_BASE_URL = 'https://api.simplepush.io/send';
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
     * @param SimplePushNotification $notification
     * @return ResponseInterface|null
     */
    public function send($notifiable, SimplePushNotification $notification)
    {
        $message = $notification->toSimplePush($notifiable);
        if (empty($message->token)) {
            return null;
        }

        return $this->http
            ->get($this->buildUrl($message));
    }

    /**
     * Build url for the SimplePush notification.
     *
     * @param  SimplePushMessage  $message
     * @return string
     */
    protected function buildUrl(SimplePushMessage $message): string
    {
        return sprintf(
            '%s/%s/%s/%s',
            self::API_BASE_URL,
            $message->token,
            $message->title,
            $message->content
        );
    }
}
