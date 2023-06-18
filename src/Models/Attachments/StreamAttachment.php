<?php

namespace BarnsleyHQ\SimplePush\Models\Attachments;

use BarnsleyHQ\SimplePush\Exceptions\InvalidStreamAttachmentUrlException;
use BarnsleyHQ\SimplePush\Models\Concerns\HasUrlGetterSetters;

/**
 * @property string $streamUrl
 */
class StreamAttachment
{
    use HasUrlGetterSetters;

    /**
     * The url for the video.
     *
     * @var string
     */
    private string $_stream;

    /**
     * Create new instance.
     *
     * @param  string  $name
     * @param  string  $url
     * @return $this
     */
    public static function make(string $streamUrl): self
    {
        return (new self())->setStreamUrl($streamUrl);
    }

    /**
     * Set the url of the video.
     *
     * @param  string  $streamUrl
     * @return $this
     */
    public function setStreamUrl(string $streamUrl): self
    {
        if (! preg_match('/^rtsp?:\/\//', $streamUrl)) {
            throw new InvalidStreamAttachmentUrlException();
        }

        $this->_stream = $streamUrl;

        return $this;
    }

    /**
     * Convert action to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [$this->_stream];
    }
}
