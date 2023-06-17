<?php

namespace BarnsleyHQ\SimplePush\Models;

use BarnsleyHQ\SimplePush\Models\Actions\FeedbackActions;
use BarnsleyHQ\SimplePush\Models\Actions\GetActions;

class SimplePushMessage
{
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
}
