<?php

declare(strict_types=1);

use LaravelGravatar\Gravatar;
use LaravelGravatar\ServiceProvider;

it('registers gravatar singleton', function () {
    expect(app('gravatar'))->toBeInstanceOf(Gravatar::class);
});

it('returns same instance as singleton', function () {
    expect(app('gravatar'))->toBe(app('gravatar'));
});

it('merges default config', function () {
    expect(config('gravatar'))
        ->toBeArray()
        ->toHaveKeys(['default_preset', 'presets']);
});

it('has null default_preset by default', function () {
    expect(config('gravatar.default_preset'))->toBeNull();
});

it('has presets in config', function () {
    expect(config('gravatar.presets'))
        ->toBeArray()
        ->toHaveKeys(['gravatar', 'small', 'medium', 'large']);
});

it('publishes config file', function () {
    $paths = Illuminate\Support\ServiceProvider::pathsToPublish(
        ServiceProvider::class,
        'gravatar-config'
    );

    expect($paths)->toHaveCount(1)
        ->and(array_key_first($paths))->toContain('config/gravatar.php');
});
