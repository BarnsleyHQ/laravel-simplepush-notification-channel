<?php

use BarnsleyHQ\SimplePush\Exceptions\ForbiddenVideoAttachmentThumbnailExtensionException;
use BarnsleyHQ\SimplePush\Exceptions\InvalidVideoAttachmentThumbnailUrlException;
use BarnsleyHQ\SimplePush\Exceptions\InvalidVideoAttachmentUrlException;
use BarnsleyHQ\SimplePush\Models\Attachments\VideoAttachment;

it('should create an instance', function () {
    $attachments = new VideoAttachment();

    expect($attachments)->toBeInstanceOf(VideoAttachment::class);
});

it('should create attachment with data', function () {
    $attachment = VideoAttachment::make('https://test-url.com/image.png', 'https://test.com/video.mp4');

    expect($attachment->thumbnail)->toBe('https://test-url.com/image.png');
    expect($attachment->video)->toBe('https://test.com/video.mp4');
});

it('should throw exception if forbidden thumbnail url extension', function () {
    VideoAttachment::make('https://test-url.com/image.bmp', 'https://test.com/video.mp4');
})->throws(ForbiddenVideoAttachmentThumbnailExtensionException::class);

it('should throw exception if invalid thumbnail url', function () {
    VideoAttachment::make('ftp://test-url.com/image.png', 'https://test.com/video.mp4');
})->throws(InvalidVideoAttachmentThumbnailUrlException::class);

it('should throw exception if invalid video url', function () {
    VideoAttachment::make('https://test-url.com/image.png', 'https://test.com/video.avi');
})->throws(InvalidVideoAttachmentUrlException::class);

it('should throw exception if invalid property is accessed', function () {
    $attachment = new VideoAttachment();

    expect($attachment->test)->toBe('Test attachment');
})->throws(\Exception::class);

it('should throw exception if property does not exist when setting', function () {
    $attachment = new VideoAttachment();

    $attachment->test = true;
})->throws(\Exception::class);

it('should throw exception if forbidden thumbnail url extension when set via property', function () {
    $attachment = new VideoAttachment();

    $attachment->thumbnailUrl = 'https://test-url.com/image.bmp';
})->throws(ForbiddenVideoAttachmentThumbnailExtensionException::class);

it('should throw exception if invalid thumbnail url when set via property', function () {
    $attachment = new VideoAttachment();

    $attachment->thumbnailUrl = 'ftp://test-url.com/image.png';
})->throws(InvalidVideoAttachmentThumbnailUrlException::class);

it('should throw exception if invalid video url when set via property', function () {
    $attachment = new VideoAttachment();

    $attachment->videoUrl = 'https://test.com/video.avi';
})->throws(InvalidVideoAttachmentUrlException::class);

it('should flatten attachment to array', function () {
    $attachment = VideoAttachment::make('https://test-url.com/image.png', 'https://test.com/video.mp4');

    expect($attachment->toArray())->toBe([
        'thumbnail' => 'https://test-url.com/image.png',
        'video'     => 'https://test.com/video.mp4',
    ]);
});
