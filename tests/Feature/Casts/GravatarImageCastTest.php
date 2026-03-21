<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use LaravelGravatar\Casts\GravatarImage;
use LaravelGravatar\Image;

it('casts email to Image instance', function () {
    $cast = new GravatarImage();
    $model = new class extends Model {};
    $image = $cast->get($model, 'email', 'test@example.com', ['email' => 'test@example.com']);

    expect($image)->toBeInstanceOf(Image::class);
});

it('sets email on the Image', function () {
    $cast = new GravatarImage();
    $model = new class extends Model {};
    $image = $cast->get($model, 'email', 'test@example.com', ['email' => 'test@example.com']);

    expect($image->email)->toBe('test@example.com');
});

it('applies preset when specified', function () {
    $cast = new GravatarImage('small');
    $model = new class extends Model {};
    $image = $cast->get($model, 'email', 'test@example.com', ['email' => 'test@example.com']);

    expect($image->getPreset())->toBe('small');
});

it('does not apply preset when not specified', function () {
    $cast = new GravatarImage();
    $model = new class extends Model {};
    $image = $cast->get($model, 'email', 'test@example.com', ['email' => 'test@example.com']);

    expect($image->getPreset())->toBeNull();
});

it('returns value unchanged on set', function () {
    $cast = new GravatarImage();
    $model = new class extends Model {};

    expect($cast->set($model, 'email', 'test@example.com', []))->toBe('test@example.com');
});
