Configuration
=============

Laravel Gravatar can be configured through the `config/gravatar.php` file. This is entirely optional - the package works out of the box with sensible defaults.

## Publishing the Configuration

To customize settings, publish the configuration file:

```bash
php artisan vendor:publish --tag="gravatar-config"
```

This creates `config/gravatar.php` in your application.

## Configuration File Structure

```php
<?php

return [
    'default_preset' => null,
    
    'presets' => [
        // Your presets here
    ],
];
```

## Default Preset

You can specify a default preset to be applied to all Gravatars unless overridden:

```php
'default_preset' => 'medium',
```

Set to `null` to disable the default preset.

## Defining Presets

Presets are named groups of default settings that can be reused throughout your application:

```php
'presets' => [
    'small' => [
        'size' => 40,
        'default_image' => 'mp',
        'extension' => 'jpg',
    ],
    
    'medium' => [
        'size' => 120,
        'default_image' => 'mp',
        'extension' => 'jpg',
    ],
    
    'large' => [
        'size' => 360,
        'default_image' => 'robohash',
        'max_rating' => 'pg',
        'extension' => 'webp',
    ],
],
```

### Available Preset Keys

- `size` - Avatar size in pixels (1-2048)
- `default_image` - Default image type or URL
- `max_rating` - Maximum allowed rating ('g', 'pg', 'r', 'x')
- `extension` - File extension ('jpg', 'jpeg', 'png', 'gif', 'webp')
- `force_default` - Force default image (boolean)
- `initials` - Explicit initials (e.g., 'JD') when using 'initials' default image
- `initials_name` - Full name (e.g., 'John Doe') - initials will be extracted

## Using Presets

**1. Using helper method:**

```php
// Use preset in helper argument
$avatar = gravatar('user@example.com', 'small');

// Or apply preset after creation
$avatar = gravatar('user@example.com')->preset('medium');

// Getter mode
$currentPreset = $avatar->preset(); // Returns current preset name if set
```

**2. Using direct property:**

```php
$avatar = gravatar('user@example.com');
$avatar->preset = 'small';
```

### In Blade

```blade
<img src="{{ gravatar($user->email, 'small') }}" alt="Avatar">
```

### With Eloquent Casts

You can specify a preset when casting model attributes:

```php
use LaravelGravatar\Casts\GravatarImage;

class User extends Model
{
    protected $casts = [
        'avatar' => GravatarImage::class.':small',
    ];
}
```

## Preset Inheritance

Presets are applied before any other settings, so you can override preset values:

```php
$avatar = gravatar('user@example.com', 'small')
    ->size(60)  // Overrides preset size
    ->extensionWebp();  // Overrides preset extension
```

## Example Configuration

Here's a complete example configuration file:

```php
<?php

return [
    'default_preset' => 'default',

    'presets' => [
        'default' => [
            'size' => 80,
            'default_image' => 'mp',
            'max_rating' => 'g',
            'extension' => 'webp',
        ],

        'thumbnail' => [
            'size' => 40,
            'extension' => 'jpg',
        ],

        'profile' => [
            'size' => 200,
            'default_image' => 'identicon',
            'max_rating' => 'pg',
            'extension' => 'webp',
        ],

        'admin' => [
            'size' => 120,
            'default_image' => 'robohash',
            'extension' => 'png',
        ],

        'with_initials' => [
            'size' => 100,
            'default_image' => 'initials',
            'initials_name' => 'User Name', // Can be overridden
            'extension' => 'webp',
        ],
    ],
];
```

## Next Steps

- [Learn about parameters](parameters.md) - All available Gravatar parameters
- [Use enums](enums.md) - Type-safe values and fluent methods
