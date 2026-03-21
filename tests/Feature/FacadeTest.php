<?php

declare(strict_types=1);

use LaravelGravatar\Facades\Gravatar;
use LaravelGravatar\Image;
use LaravelGravatar\Profile;

it('creates image via facade', function () {
    expect(Gravatar::image('test@example.com'))
        ->toBeInstanceOf(Image::class);
});

it('creates avatar via facade', function () {
    expect(Gravatar::avatar('test@example.com'))
        ->toBeInstanceOf(Image::class);
});

it('creates profile via facade', function () {
    expect(Gravatar::profile('test@example.com'))
        ->toBeInstanceOf(Profile::class);
});
