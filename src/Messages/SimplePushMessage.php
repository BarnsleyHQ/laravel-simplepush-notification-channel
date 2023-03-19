<?php

namespace BarnsleyHQ\SimplePush\Messages;

class SimplePushMessage
{
    /**
     * The token of the message.
     *
     * @var string|null
     */
    public $token = null;

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
}
