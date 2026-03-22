<?php

declare(strict_types=1);

use LaravelGravatar\Image;
use LaravelGravatar\Profile;

it('returns Image instance via gravatar()', function () {
    expect(gravatar('test@example.com'))
        ->toBeInstanceOf(Image::class);
});

it('returns Image with preset via gravatar()', function () {
    $image = gravatar('test@example.com', 'small');

    expect($image)
        ->toBeInstanceOf(Image::class)
        ->and($image->getPreset())->toBe('small');
});

it('returns Image without email via gravatar()', function () {
    expect(gravatar())->toBeInstanceOf(Image::class);
});

it('returns Profile instance via gravatar_profile()', function () {
    expect(gravatar_profile('test@example.com'))
        ->toBeInstanceOf(Profile::class);
});

it('returns Profile without format parameter via gravatar_profile()', function () {
    $profile = gravatar_profile('test@example.com');

    expect($profile)->toBeInstanceOf(Profile::class);
});
