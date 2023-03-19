<?php

namespace BarnsleyHQ\SimplePush\Channels;

use BarnsleyHQ\SimplePush\Exceptions\MissingDataException;
use BarnsleyHQ\SimplePush\Exceptions\MissingToSimplePushMethodException;
use BarnsleyHQ\SimplePush\Messages\SimplePushMessage;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class SimplePushChannel
{
    const API_BASE_URL = 'https://api.simplepush.io/send';

    const REQUIRED_DATA = [
        'content',
        'token' => '/^[a-zA-Z0-9]{6}$/',
    ];

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

        $message = $notification->toSimplePush($notifiable);

        $this->validateMessage($message);

        return $this->http
            ->post(self::API_BASE_URL, $this->buildData($message));
    }

    /**
     * Build url for the SimplePush notification.
     *
     * @param  SimplePushMessage  $message
     * @return void
     * @throws MissingDataException
     */
    protected function validateMessage(SimplePushMessage $message): void
    {
        $missingData = [];
        foreach (self::REQUIRED_DATA as $fieldName => $expression) {
            if (is_numeric($fieldName)) {
                $fieldName = $expression;
                $value = $message->{$fieldName};
                if ($value === null || empty($value)) {
                    $missingData[] = $fieldName;
                }

                continue;
            }

            if (! preg_match($expression, $message->{$fieldName})) {
                $missingData[] = $fieldName;
            }
        }

        if (! empty($missingData)) {
            throw new MissingDataException($missingData);
        }
    }

    /**
     * Build url for the SimplePush notification.
     *
     * @param  SimplePushMessage  $message
     * @return array
     */
    protected function buildData(SimplePushMessage $message): array
    {
        return [
            'json' => [
                'key'   => $message->token,
                'title' => $message->title,
                'msg'   => $message->content,
                'event' => $message->event,
            ]
        ];
    }
}
