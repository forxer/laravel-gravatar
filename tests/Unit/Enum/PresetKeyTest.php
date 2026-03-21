<?php

declare(strict_types=1);

use LaravelGravatar\Enum\PresetKey;

it('has all expected cases', function () {
    $cases = PresetKey::cases();

    expect($cases)->toHaveCount(7);
});

it('returns all values as strings', function () {
    expect(PresetKey::values())->toBe([
        'size',
        'default_image',
        'max_rating',
        'extension',
        'force_default',
        'initials',
        'initials_name',
    ]);
});

it('validates known keys as valid', function (string $key) {
    expect(PresetKey::isValid($key))->toBeTrue();
})->with([
    'size',
    'default_image',
    'max_rating',
    'extension',
    'force_default',
    'initials',
    'initials_name',
]);

it('rejects unknown keys', function (string $key) {
    expect(PresetKey::isValid($key))->toBeFalse();
})->with([
    'unknown',
    'avatar',
    'email',
    '',
]);
