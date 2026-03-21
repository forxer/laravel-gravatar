<?php

declare(strict_types=1);

use LaravelGravatar\Gravatar;
use LaravelGravatar\Image;
use LaravelGravatar\Profile;

it('creates an Image instance via image()', function () {
    $gravatar = app('gravatar');

    expect($gravatar->image('test@example.com'))
        ->toBeInstanceOf(Image::class);
});

it('creates an Image with preset name', function () {
    $gravatar = app('gravatar');
    $image = $gravatar->image('test@example.com', 'small');

    expect($image)
        ->toBeInstanceOf(Image::class)
        ->and($image->getPreset())->toBe('small');
});

it('creates an Image via avatar() alias', function () {
    $gravatar = app('gravatar');

    expect($gravatar->avatar('test@example.com'))
        ->toBeInstanceOf(Image::class);
});

it('creates a Profile instance via profile()', function () {
    $gravatar = app('gravatar');

    expect($gravatar->profile('test@example.com'))
        ->toBeInstanceOf(Profile::class);
});

it('creates a Profile with format', function () {
    $gravatar = app('gravatar');
    $profile = $gravatar->profile('test@example.com', 'json');

    expect($profile)
        ->toBeInstanceOf(Profile::class)
        ->and($profile->format)->toBe('json');
});

it('can be created via static create()', function () {
    expect(Gravatar::create())
        ->toBeInstanceOf(Gravatar::class);
});

it('returns the same singleton instance', function () {
    expect(Gravatar::create())->toBe(app('gravatar'));
});
