<?php

declare(strict_types=1);

use Gravatar\Image as GravatarImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use LaravelGravatar\Gravatar;

// --- Construction ---

it('extends the parent Gravatar Image', function () {
    $image = app('gravatar')->image('test@example.com');

    expect($image)->toBeInstanceOf(GravatarImage::class);
});

it('stores config as public readonly property', function () {
    $image = app('gravatar')->image('test@example.com');

    expect($image->config)->toBeArray()
        ->and($image->config)->toHaveKey('presets');
});

it('builds a URL without preset', function () {
    $image = app('gravatar')->image('test@example.com');

    expect($image->url())
        ->toStartWith('https://www.gravatar.com/avatar/')
        ->and($image->url())->toContain(md5('test@example.com'));
});

it('is stringable', function () {
    $image = app('gravatar')->image('test@example.com');

    expect((string) $image)->toBe($image->url());
});

// --- Preset system ---

it('applies the small preset correctly', function () {
    $url = app('gravatar')->image('test@example.com', 'small')->url();

    expect($url)
        ->toContain('s=40')
        ->toContain('d=mp')
        ->toContain('.jpg');
});

it('applies the medium preset correctly', function () {
    $url = app('gravatar')->image('test@example.com', 'medium')->url();

    expect($url)->toContain('s=120');
});

it('applies the large preset correctly', function () {
    $url = app('gravatar')->image('test@example.com', 'large')->url();

    expect($url)->toContain('s=360');
});

it('applies the gravatar default preset', function () {
    $url = app('gravatar')->image('test@example.com', 'gravatar')->url();

    expect($url)
        ->toContain('s=80')
        ->toContain('r=g');
});

it('allows setting preset via setPreset()', function () {
    $image = app('gravatar')->image('test@example.com');
    $image->setPreset('small');

    expect($image->getPreset())->toBe('small')
        ->and($image->url())->toContain('s=40');
});

it('allows setting preset via preset() fluent method', function () {
    $image = app('gravatar')->image('test@example.com');
    $result = $image->preset('small');

    expect($result)->toBe($image);
});

it('returns preset name via preset() without args', function () {
    $image = app('gravatar')->image('test@example.com', 'small');

    expect($image->preset())->toBe('small');
});

it('returns null preset by default', function () {
    $image = app('gravatar')->image('test@example.com');

    expect($image->getPreset())->toBeNull();
});

it('applies default_preset from config when set', function () {
    config()->set('gravatar.default_preset', 'small');

    $gravatar = new Gravatar(config('gravatar'));
    $url = $gravatar->image('test@example.com')->url();

    expect($url)->toContain('s=40');
});

it('throws on unknown preset name', function () {
    app('gravatar')->image('test@example.com', 'nonexistent')->url();
})->throws(InvalidArgumentException::class);

it('throws on invalid preset key in config', function () {
    config()->set('gravatar.presets.custom', ['invalid_key' => 'value']);

    app('gravatar')->image('test@example.com', 'custom')->url();
})->throws(InvalidArgumentException::class);

it('throws when preset values are empty', function () {
    config()->set('gravatar.presets.empty', []);

    $gravatar = new Gravatar(config('gravatar'));
    $gravatar->image('test@example.com', 'empty')->url();
})->throws(InvalidArgumentException::class);

// --- Preset value validation ---

it('validates extension values', function (string $ext) {
    config()->set('gravatar.presets.test', ['extension' => $ext]);

    $gravatar = new Gravatar(config('gravatar'));
    $url = $gravatar->image('test@example.com', 'test')->url();

    expect($url)->toContain('.'.$ext);
})->with(['jpg', 'jpeg', 'png', 'gif', 'webp']);

it('rejects invalid extension in preset', function () {
    config()->set('gravatar.presets.test', ['extension' => 'bmp']);

    $gravatar = new Gravatar(config('gravatar'));
    $gravatar->image('test@example.com', 'test')->url();
})->throws(InvalidArgumentException::class);

it('validates rating values', function (string $rating) {
    config()->set('gravatar.presets.test', ['max_rating' => $rating]);

    $gravatar = new Gravatar(config('gravatar'));
    $url = $gravatar->image('test@example.com', 'test')->url();

    expect($url)->toContain('r='.$rating);
})->with(['g', 'pg', 'r', 'x']);

it('rejects invalid rating in preset', function () {
    config()->set('gravatar.presets.test', ['max_rating' => 'z']);

    $gravatar = new Gravatar(config('gravatar'));
    $gravatar->image('test@example.com', 'test')->url();
})->throws(InvalidArgumentException::class);

it('validates default_image values', function (string $default) {
    config()->set('gravatar.presets.test', ['default_image' => $default]);

    $gravatar = new Gravatar(config('gravatar'));
    $url = $gravatar->image('test@example.com', 'test')->url();

    expect($url)->toContain('d='.$default);
})->with(['mp', 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank']);

it('accepts URL as default_image', function () {
    config()->set('gravatar.presets.test', ['default_image' => 'https://example.com/avatar.png']);

    $gravatar = new Gravatar(config('gravatar'));
    $url = $gravatar->image('test@example.com', 'test')->url();

    expect($url)->toContain('d=');
});

it('rejects invalid default_image', function () {
    config()->set('gravatar.presets.test', ['default_image' => 'invalid']);

    $gravatar = new Gravatar(config('gravatar'));
    $gravatar->image('test@example.com', 'test')->url();
})->throws(InvalidArgumentException::class);

it('requires boolean for force_default', function () {
    config()->set('gravatar.presets.test', ['force_default' => 'yes']);

    $gravatar = new Gravatar(config('gravatar'));
    $gravatar->image('test@example.com', 'test')->url();
})->throws(InvalidArgumentException::class, 'must be a boolean');

it('accepts boolean true for force_default', function () {
    config()->set('gravatar.presets.test', ['force_default' => true]);

    $gravatar = new Gravatar(config('gravatar'));
    $url = $gravatar->image('test@example.com', 'test')->url();

    expect($url)->toContain('f=y');
});

it('accepts null values in preset for optional keys', function () {
    config()->set('gravatar.presets.test', ['extension' => null, 'size' => 50]);

    $gravatar = new Gravatar(config('gravatar'));
    $url = $gravatar->image('test@example.com', 'test')->url();

    expect($url)->toContain('s=50');
});

// --- Base64 conversion ---

it('returns base64 string on successful HTTP response', function () {
    Http::fake([
        'www.gravatar.com/*' => Http::response('fake-image-data', 200),
    ]);

    $result = app('gravatar')->image('test@example.com')->toBase64();

    expect($result)
        ->toStartWith('data:image/png;base64,')
        ->and($result)->toBe('data:image/png;base64,'.base64_encode('fake-image-data'));
});

it('returns null on failed HTTP response', function () {
    Http::fake([
        'www.gravatar.com/*' => Http::response('', 404),
    ]);

    Log::shouldReceive('warning')->once();

    $result = app('gravatar')->image('test@example.com')->toBase64();

    expect($result)->toBeNull();
});

it('returns null on HTTP exception', function () {
    Http::fake([
        'www.gravatar.com/*' => fn () => throw new Exception('Connection failed'),
    ]);

    Log::shouldReceive('warning')->once();

    $result = app('gravatar')->image('test@example.com')->toBase64();

    expect($result)->toBeNull();
});
