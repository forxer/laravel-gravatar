<?php

declare(strict_types=1);

use LaravelGravatar\Image;
use LaravelGravatar\Profile;

beforeEach(function () {
    $email = env('GRAVATAR_TEST_EMAIL');

    if (empty($email)) {
        $this->markTestSkipped('Set GRAVATAR_TEST_EMAIL to run integration tests.');
    }

    $this->testEmail = $email;
});

// --- Image ---

it('builds a valid image URL', function () {
    $image = app('gravatar')->image($this->testEmail);

    expect($image)
        ->toBeInstanceOf(Image::class)
        ->and($image->url())->toStartWith('https://gravatar.com/avatar/');
});

it('builds image URL with parameters', function () {
    $url = app('gravatar')->image($this->testEmail)
        ->size(120)
        ->extensionWebp()
        ->ratingPg()
        ->url();

    expect($url)
        ->toContain('s=120')
        ->toContain('.webp')
        ->toContain('r=pg');
});

it('converts image to base64 from live server', function () {
    $result = app('gravatar')->image($this->testEmail)
        ->size(80)
        ->toBase64();

    expect($result)
        ->not->toBeNull()
        ->toStartWith('data:image/png;base64,');
});

it('applies preset and builds valid URL', function () {
    $url = app('gravatar')->image($this->testEmail, 'small')->url();

    expect($url)
        ->toStartWith('https://gravatar.com/avatar/')
        ->toContain('s=40');
});

// --- Profile ---

it('builds a valid profile URL', function () {
    $profile = app('gravatar')->profile($this->testEmail);

    expect($profile)
        ->toBeInstanceOf(Profile::class)
        ->and($profile->url())->toStartWith('https://api.gravatar.com/v3/profiles/');
});

it('fetches profile data from live API', function () {
    $data = app('gravatar')->profile($this->testEmail)->getData();

    if ($data === null) {
        $this->markTestSkipped('Profile not accessible (network or no public profile).');
    }

    expect($data)
        ->toBeArray()
        ->toHaveKey('hash');
});
