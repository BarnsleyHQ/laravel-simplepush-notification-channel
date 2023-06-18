<?php

use BarnsleyHQ\SimplePush\Models\Attachments\GenericAttachments;

it('should create an instance', function () {
    $attachments = new GenericAttachments();

    expect($attachments)->toBeInstanceOf(GenericAttachments::class);
});

it('should load in attachments from string', function () {
    $attachments = GenericAttachments::make('https://test.com/image.png');

    expect($attachments->attachments)->toBe(['https://test.com/image.png']);
});

it('should load in attachments from array', function () {
    $attachments = GenericAttachments::make(['https://test.com/image.png']);

    expect($attachments->attachments)->toBe(['https://test.com/image.png']);
});

it('should not load in attachments of invalid type', function () {
    $attachments = GenericAttachments::make([123]);

    expect($attachments->attachments)->toBe([]);
});

it('should not load in attachments with invalid extension', function ($extension) {
    $attachments = GenericAttachments::make(['https://test.com/image.'.$extension]);

    expect($attachments->attachments)->toBe([]);
})->with([
    'doc',
    'zip',
    'rar',
    'dat',
    'bin',
]);

it('should not load in attachments with invalid url', function ($uri) {
    $attachments = GenericAttachments::make([$uri.'://test.com/image.png']);

    expect($attachments->attachments)->toBe([]);
})->with([
    'ftp',
    'rtsp',
]);

it('should add in attachments for existing instance', function () {
    $attachments = GenericAttachments::make('https://test.com/image.png');
    $attachments->add('https://test.com/image.jpg');
    $attachments->add([
        'https://test.com/image.gif',
        'https://test.com/image.mp4',
    ]);

    expect($attachments->attachments)->toBe([
        'https://test.com/image.png',
        'https://test.com/image.jpg',
        'https://test.com/image.gif',
        'https://test.com/image.mp4',
    ]);
});

it('should convert to an array', function () {
    $attachments = GenericAttachments::make([
        'https://test.com/image.png',
        'https://test.com/image.jpg',
        'https://test.com/image.gif',
        'https://test.com/image.mp4',
    ]);

    expect($attachments->toArray())->toBe([
        'https://test.com/image.png',
        'https://test.com/image.jpg',
        'https://test.com/image.gif',
        'https://test.com/image.mp4',
    ]);
});
