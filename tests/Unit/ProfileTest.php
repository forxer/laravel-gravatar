<?php

declare(strict_types=1);

use Gravatar\Profile as GravatarProfile;
use LaravelGravatar\Profile;

it('extends the parent Gravatar Profile', function () {
    $profile = app('gravatar')->profile('test@example.com');

    expect($profile)
        ->toBeInstanceOf(Profile::class)
        ->toBeInstanceOf(GravatarProfile::class);
});

it('builds a profile URL', function () {
    $profile = app('gravatar')->profile('test@example.com');

    expect($profile->url())
        ->toStartWith('https://');
});

it('is stringable', function () {
    $profile = app('gravatar')->profile('test@example.com');

    expect((string) $profile)->toBe($profile->url());
});
