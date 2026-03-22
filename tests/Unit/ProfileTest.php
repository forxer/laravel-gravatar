<?php

declare(strict_types=1);

use Gravatar\Profile as GravatarProfile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

// --- getData() ---

it('returns profile data on successful response', function () {
    Http::fake([
        'api.gravatar.com/*' => Http::response([
            'hash' => 'abc123',
            'display_name' => 'John Doe',
            'avatar_url' => 'https://gravatar.com/avatar/abc123',
            'location' => 'Paris',
        ], 200),
    ]);

    $data = app('gravatar')->profile('test@example.com')->getData();

    expect($data)
        ->toBeArray()
        ->and($data['display_name'])->toBe('John Doe')
        ->and($data['location'])->toBe('Paris');
});

it('returns null on failed response', function () {
    Http::fake([
        'api.gravatar.com/*' => Http::response('', 404),
    ]);

    Log::shouldReceive('warning')->once();

    $data = app('gravatar')->profile('test@example.com')->getData();

    expect($data)->toBeNull();
});

it('returns null on HTTP exception', function () {
    Http::fake([
        'api.gravatar.com/*' => fn () => throw new Exception('Connection failed'),
    ]);

    Log::shouldReceive('warning')->once();

    $data = app('gravatar')->profile('test@example.com')->getData();

    expect($data)->toBeNull();
});
