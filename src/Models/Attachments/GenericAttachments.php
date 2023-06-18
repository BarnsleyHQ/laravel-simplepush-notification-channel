<?php

namespace BarnsleyHQ\SimplePush\Models\Attachments;

class GenericAttachments
{
    const ALLOWED_EXTENSIONS = [
        'jpg',
        'png',
        'gif',
        'mp4',
    ];

    /**
     * The attachments to include in the message.
     *
     * @var array
     */
    public $attachments = [];

    /**
     * Create new instance with attachments(s).
     *
     * @param  string|array<string>  $attachment
     * @return $this
     */
    public static function make(string|array $attachment): self
    {
        return (new self())->add($attachment);
    }

    /**
     * Add attachment option(s).
     *
     * @param  string|array<string>  $attachment
     * @return $this
     */
    public function add(string|array $attachment): self
    {
        if (is_string($attachment)) {
            $attachment = [$attachment];
        }

        foreach ($attachment as $item) {
            if (! is_string($item)) {
                continue;
            }

            if (! in_array(substr($item, -3), self::ALLOWED_EXTENSIONS)) {
                continue;
            }

            if (! preg_match('/^https?:\/\//', $item)) {
                continue;
            }

            $this->attachments[] = $item;
        }

        return $this;
    }

    /**
     * Convert attachments to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attachments;
    }
}
