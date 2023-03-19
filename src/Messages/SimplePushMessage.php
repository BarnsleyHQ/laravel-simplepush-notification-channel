<?php

namespace BarnsleyHQ\SimplePush\Messages;

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
     * @param  string  $title
     * @return $this
     */
    public function event(string $event)
    {
        $this->event = $event;

        return $this;
    }
}
