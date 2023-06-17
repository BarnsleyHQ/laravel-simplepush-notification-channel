<?php

namespace BarnsleyHQ\SimplePush\Models\Actions;

use BarnsleyHQ\SimplePush\SimplePushClient;
use GuzzleHttp\Client as HttpClient;

class FeedbackActions
{
    /**
     * The options to display for the action.
     *
     * @var array
     */
    public $options = [];

    /**
     * A callback to use to get the Feedback ID.
     *
     * @var null|callable
     */
    public $sendCallback = null;

    /**
     * Create new instance with option(s).
     *
     * @param  string|array<string>  $action
     * @return $this
     */
    public static function make(string|array $action, null|callable $sendCallback = null): self
    {
        return (new self())->add($action)
            ->sendCallback($sendCallback);
    }

    /**
     * Create new instance with option(s).
     *
     * @param  string  $feedbackId
     * @param  null|HttpClient  $httpClient
     * @return array|null
     */
    public static function getFeedbackResponseForId(string $feedbackId, ?HttpClient $httpClient = null): array|null
    {
        $data = SimplePushClient::withClient($httpClient)
            ->get('/1/feedback/'.$feedbackId);

        if (! $data || $data['success'] === false) {
            return null;
        }

        return $data;
    }

    /**
     * Add action option(s).
     *
     * @param  string|array<string>  $action
     * @return $this
     */
    public function add(string|array $action): self
    {
        if (is_string($action)) {
            $action = [$action];
        }

        foreach ($action as $item) {
            if (! is_string($item)) {
                continue;
            }

            $this->options[] = $item;
        }

        return $this;
    }

    /**
     * Set callback to be used to get the Feedback ID.
     *
     * @param  null|callable  $sendCallback
     * @return $this
     */
    public function sendCallback(null|callable $sendCallback): self
    {
        $this->sendCallback = $sendCallback;

        return $this;
    }

    /**
     * Convert actions to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->options;
    }
}
