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

## Configuration Options

### Default Preset

You can specify a default preset to be applied to all Gravatars unless overridden:

```php
'default_preset' => 'medium',
```

Set to `null` to disable the default preset.

### Presets

The `presets` array contains named configurations that can be reused throughout your application.

See the **[Presets documentation](presets.md)** for complete details on:
- Defining presets
- Available preset keys
- Preset validation
- Using presets
- Examples

## Example Configuration

Here's a minimal example configuration file:

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
    ],
];
```

## Next Steps

- [Define presets](presets.md) - Complete guide to preset configurations
- [Add Eloquent casts](casts.md) - Seamlessly integrate with your models
- [Explore advanced features](advanced.md) - Base64 conversion, copying instances
