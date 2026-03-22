---
name: gravatar
description: "Activate when working with Gravatar avatars, profiles, presets, Eloquent casts, base64 conversion, or configuring config/gravatar.php. Covers helpers, facade, DI, PHP 8.4 property hooks, type-safe enums, and fluent shorthand methods."
license: MIT
metadata:
  author: forxer
---
# Laravel Gravatar

## Documentation

- See `docs/` directory for detailed patterns and documentation.
- See `README.md` for installation and quick start.

Key files: `docs/usage.md` (helpers, facade, DI), `docs/parameters.md` (all parameters), `docs/presets.md` (preset config), `docs/casts.md` (Eloquent casts), `docs/advanced.md` (base64, profiles, property hooks).

## Quick Start

@boostsnippet("Helper and facade usage", "php")
// Helper (most common)
$avatar = gravatar('user@example.com')->size(120)->extensionWebp();
echo $avatar; // outputs Gravatar URL

// With preset
$avatar = gravatar('user@example.com', 'small');

// Facade
$avatar = Gravatar::image('user@example.com', 'small');

// Profile
$data = gravatar_profile('user@example.com')->getData();
@endboostsnippet

## Three Ways to Set Parameters

@boostsnippet("Parameter setting modes", "php")
// 1. Helper methods (fluent, recommended)
$avatar->size(120)->extension('webp')->maxRating('pg');

// 2. Fluent shortcuts
$avatar->extensionWebp()->ratingPg()->defaultImageRobohash();

// 3. Direct property assignment (PHP 8.4 property hooks)
$avatar->size = 120;
$avatar->extension = Extension::WEBP;
@endboostsnippet

## Preset Configuration

@boostsnippet("config/gravatar.php", "php")
return [
    'default_preset' => null,
    'presets' => [
        'small'  => ['size' => 40, 'default_image' => 'mp', 'extension' => 'jpg'],
        'medium' => ['size' => 120, 'default_image' => 'mp', 'extension' => 'jpg'],
        'large'  => ['size' => 360, 'default_image' => 'mp', 'extension' => 'jpg'],
    ],
];
@endboostsnippet

Valid preset keys (`PresetKey` enum): `size`, `default_image`, `max_rating`, `extension`, `force_default`, `initials`, `initials_name`. Value validation is handled by the parent library's property hooks.

## Eloquent Casts

@boostsnippet("Model cast setup", "php")
use LaravelGravatar\Casts\GravatarImage;

class User extends Model
{
    protected $casts = [
        'email' => GravatarImage::class.':small',
    ];
}
@endboostsnippet

@boostsnippet("Cast usage in Blade", "blade")
<img src="{{ $user->email }}" alt="Avatar">
<img src="{{ $user->email->size(80)->extensionWebp() }}" alt="Avatar">
@endboostsnippet

## Base64 Conversion

@boostsnippet("Convert to data URL", "php")
$base64 = gravatar('user@example.com')->size(80)->toBase64();
// Returns: data:image/{content-type};base64,...
// Returns null on failure (logged automatically)
$base64 = $avatar->toBase64(timeout: 10); // custom timeout
@endboostsnippet

## Verification

1. Presets defined in `config/gravatar.php` with valid `PresetKey` keys
2. Enum values (`extension`, `max_rating`, `default_image`) match parent library enums
3. `force_default` preset value is boolean (not string)
4. Eloquent casts use `GravatarImage::class` or `GravatarProfile::class`

## Common Pitfalls

- Using `format()` or `ProfileFormat` — removed in v6, API v3 returns JSON only
- Assigning `email`, `initials`, `initialsName`, `forceDefault` directly — these are `private(set)`, use methods instead
- Passing `null` to `forceDefault()` — use `false` instead
- Using short preset keys (`s`, `e`, `r`, `d`, `f`) — removed in v5, use full names
