<?php

namespace BarnsleyHQ\SimplePush\Models\Attachments;

use BarnsleyHQ\SimplePush\Exceptions\ForbiddenVideoAttachmentThumbnailExtensionException;
use BarnsleyHQ\SimplePush\Exceptions\InvalidVideoAttachmentThumbnailUrlException;
use BarnsleyHQ\SimplePush\Exceptions\InvalidVideoAttachmentUrlException;
use BarnsleyHQ\SimplePush\Models\Concerns\HasUrlGetterSetters;

/**
 * @property string $thumbnailUrl
 * @property string $videoUrl
 */
class VideoAttachment
{
    use HasUrlGetterSetters;

    const ALLOWED_THUMBNAIL_EXTENSIONS = [
        'jpg',
        'png',
        'gif',
    ];

    /**
     * The url for thumbnail.
     *
     * @var string
     */
    public string $_thumbnail;

    /**
     * The url for the video.
     *
     * @var string
     */
    private string $_video;

    /**
     * Create new instance.
     *
     * @param  string  $name
     * @param  string  $url
     * @return $this
     */
    public static function make(string $thumbnailUrl, string $videoUrl): self
    {
        return (new self())->setThumbnailUrl($thumbnailUrl)
            ->setVideoUrl($videoUrl);
    }

    /**
     * Set the url of the thumbnail.
     *
     * @param  string  $thumbnailUrl
     * @return $this
     */
    public function setThumbnailUrl(string $thumbnailUrl): self
    {
        if (! in_array(substr($thumbnailUrl, -3), self::ALLOWED_THUMBNAIL_EXTENSIONS)) {
            throw new ForbiddenVideoAttachmentThumbnailExtensionException();
        }

        if (! preg_match('/^https?:\/\//', $thumbnailUrl)) {
            throw new InvalidVideoAttachmentThumbnailUrlException();
        }

        $this->_thumbnail = $thumbnailUrl;

        return $this;
    }

    /**
     * Set the url of the video.
     *
     * @param  string  $videoUrl
     * @return $this
     */
    public function setVideoUrl(string $videoUrl): self
    {
        if (! preg_match('/^https?:\/\/.+\.mp4$/', $videoUrl)) {
            throw new InvalidVideoAttachmentUrlException();
        }

        $this->_video = $videoUrl;

        return $this;
    }

    /**
     * Convert action to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'thumbnail' => $this->_thumbnail,
            'video'     => $this->_video,
        ];
    }
}
