<?php

use BarnsleyHQ\SimplePush\Exceptions\InvalidStreamAttachmentUrlException;
use BarnsleyHQ\SimplePush\Models\Attachments\StreamAttachment;

it('should create an instance', function () {
    $attachments = new StreamAttachment();

    expect($attachments)->toBeInstanceOf(StreamAttachment::class);
});

it('should create attachment with data', function () {
    $attachment = StreamAttachment::make('rtsp://test.com/stream');

    expect($attachment->stream)->toBe('rtsp://test.com/stream');
});

it('should set stream url with method', function () {
    $attachments = new StreamAttachment();
    $attachments->setStreamUrl('rtsp://test.com/stream');

    expect($attachments->stream)->toBe('rtsp://test.com/stream');
});

it('should throw exception if invalid stream url', function () {
    StreamAttachment::make('https://test.com/stream.mp4');
})->throws(InvalidStreamAttachmentUrlException::class);

it('should throw exception if invalid property is accessed', function () {
    $attachment = new StreamAttachment();

    expect($attachment->test)->toBe('Test attachment');
})->throws(\Exception::class);

it('should throw exception if property does not exist when setting', function () {
    $attachment = new StreamAttachment();

    $attachment->test = true;
})->throws(\Exception::class);

it('should throw exception if invalid stream url when set via property', function () {
    $attachment = new StreamAttachment();

    $attachment->streamUrl = 'https://test.com/stream.mp4';
})->throws(InvalidStreamAttachmentUrlException::class);

it('should flatten attachment to array', function () {
    $attachment = StreamAttachment::make('rtsp://test.com/stream');

    expect($attachment->toArray())->toBe(['rtsp://test.com/stream']);
});
