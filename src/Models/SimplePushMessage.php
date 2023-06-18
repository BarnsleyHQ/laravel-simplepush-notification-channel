<?php

namespace BarnsleyHQ\SimplePush\Models;

use BarnsleyHQ\SimplePush\Exceptions\MissingDataException;
use BarnsleyHQ\SimplePush\Models\Actions\FeedbackActions;
use BarnsleyHQ\SimplePush\Models\Actions\GetActions;
use BarnsleyHQ\SimplePush\Models\Attachments\GenericAttachments;
use BarnsleyHQ\SimplePush\Models\Attachments\StreamAttachment;
use BarnsleyHQ\SimplePush\Models\Attachments\VideoAttachment;
use BarnsleyHQ\SimplePush\SimplePushClient;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class SimplePushMessage
{
    const REQUIRED_DATA = [
        'content',
        'token' => '/^[a-zA-Z0-9]{6}$/',
    ];

    /**
     * The token of the message.
     *
     * @var string
     */
    public $token;

    /**
     * The text content of the message.
     *
     * @var string
     */
    public $content;

    /**
     * The title of the message.
     *
     * @var string
     */
    public $title;

    /**
     * The event which the message will trigger.
     *
     * @var string
     */
    public $event;

    /**
     * The actions associated with the message.
     *
     * @var null|FeedbackActions|GetActions
     */
    public $actions = null;

    /**
     * The attachments associated with the message.
     *
     * @var null|GenericAttachments|StreamAttachment|VideoAttachment
     */
    public $attachments = null;

    /**
     * Set the token for the message.
     *
     * @param  string  $token
     * @return $this
     */
    public function token(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set the content of the message.
     *
     * @param  string  $content
     * @return $this
     */
    public function content(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the title of the message.
     *
     * @param  string  $title
     * @return $this
     */
    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the event which the message will trigger.
     *
     * @param  string  $event
     * @return $this
     */
    public function event(string $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Set the actions for the message.
     *
     * @param  FeedbackActions|GetActions|null  $actions
     * @return $this
     */
    public function actions(FeedbackActions|GetActions|null $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Set the attachments for the message.
     *
     * @param  GenericAttachments|StreamAttachment|VideoAttachment|null  $attachments
     * @return $this
     */
    public function attachments(GenericAttachments|StreamAttachment|VideoAttachment|null $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * Check if message has a feedback actions callback.
     *
     * @return bool
     */
    public function hasFeedbackActionsCallback(): bool
    {
        if (! $this->actions) {
            return false;
        }

        if (! is_a($this->actions, FeedbackActions::class)) {
            return false;
        }

        return $this->actions->sendCallback !== null;
    }

    /**
     * Build url for the SimplePush notification.
     *
     * @return void
     * @throws MissingDataException
     */
    public function validate(): void
    {
        $missingData = [];
        foreach (self::REQUIRED_DATA as $fieldName => $expression) {
            if (is_numeric($fieldName)) {
                $fieldName = $expression;
                $value = $this->{$fieldName};
                if ($value === null || empty($value)) {
                    $missingData[] = $fieldName;
                }

                continue;
            }

            if (! preg_match($expression, $this->{$fieldName})) {
                $missingData[] = $fieldName;
            }
        }

        if (! empty($missingData)) {
            throw new MissingDataException($missingData);
        }
    }

    /**
     * Send SimplePush notification
     *
     * @param null|HttpClient $http
     * @return array|null
     */
    public function send(?HttpClient $httpClient = null): array|null
    {
        $this->validate();

        $response = SimplePushClient::withClient($httpClient)
            ->post('/send', $this->toArray());

        if ($this->hasFeedbackActionsCallback()) {
            call_user_func($this->actions->sendCallback, $response['feedbackId']);
        }

        return $response;
    }

    /**
     * Convert message to array.
     *
     * @return array
     */
    private function toArray(): array
    {
        return [
            'json' => [
                'key'         => $this->token,
                'title'       => $this->title,
                'msg'         => $this->content,
                'event'       => $this->event,
                'actions'     => $this->actions ? $this->actions->toArray() : null,
                'attachments' => $this->attachments ? $this->attachments->toArray() : null,
            ]
        ];
    }
}
