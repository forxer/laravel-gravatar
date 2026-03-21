<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use LaravelGravatar\Casts\GravatarProfile;
use LaravelGravatar\Profile;

it('casts email to Profile instance', function () {
    $cast = new GravatarProfile();
    $model = new class extends Model {};
    $profile = $cast->get($model, 'email', 'test@example.com', ['email' => 'test@example.com']);

    expect($profile)->toBeInstanceOf(Profile::class);
});

it('returns value unchanged on set', function () {
    $cast = new GravatarProfile();
    $model = new class extends Model {};

    expect($cast->set($model, 'email', 'test@example.com', []))->toBe('test@example.com');
});
