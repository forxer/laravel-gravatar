Laravel Gravatar Documentation
==============================

Welcome to the Laravel Gravatar documentation. This package provides an easy and elegant way to integrate Gravatar into your Laravel applications.

## What is Laravel Gravatar?

Laravel Gravatar is a Laravel package built on top of the [forxer/gravatar](https://github.com/forxer/gravatar) library. It extends the base functionality with Laravel-specific features:

- **Helper functions** - `gravatar()` and `gravatar_profile()` for quick access
- **Facade support** - `Gravatar::image()` and `Gravatar::profile()`
- **Service Provider** - Automatic registration and configuration
- **Configuration presets** - Define reusable avatar configurations with automatic validation
- **Preset key validation** - Preset keys validated against `PresetKey` enum, values validated by parent library's property hooks
- **Eloquent casts** - Cast model attributes to Gravatar instances
- **Base64 conversion** - Convert avatars to data URLs using Laravel HTTP client
- **PHP 8.4 features** - Full support for property hooks, asymmetric visibility, enums, and modern PHP

## Quick Start

```php
use Gravatar\Enum\DefaultImage;

// Simple usage with helper
$avatar = gravatar('user@example.com')
    ->size(120)
    ->extensionWebp()
    ->defaultImageRobohash();

echo $avatar; // Outputs the Gravatar URL
```

```blade
{{-- In Blade templates --}}
<img src="{{ gravatar($user->email)->size(80) }}" alt="Avatar">
```

## Documentation Structure

- **[Installation](installation.md)** - Install and configure the package
- **[Usage](usage.md)** - Learn how to use helpers, facades, and dependency injection
- **[Parameters](parameters.md)** - Understand all available Gravatar parameters
- **[Enums](enums.md)** - Use type-safe enums and fluent shorthand methods
- **[Configuration](configuration.md)** - Configure the package
- **[Presets](presets.md)** - Complete guide to preset configurations
- **[Casts](casts.md)** - Use Eloquent casts for seamless integration
- **[Advanced Features](advanced.md)** - Explore advanced functionality

## Requirements

- **PHP 8.4** or newer
- **Laravel 12.0** or newer

For older versions:
- [Version 4.x](https://github.com/forxer/laravel-gravatar/tree/4.x) - PHP 8.2+, Laravel 10-12
- [Version 2.x](https://github.com/forxer/laravel-gravatar/tree/2.x) - PHP 8.0+, Laravel 8-9

## Related Resources

- [Gravatar Official Documentation](https://gravatar.com/site/implement/)
- [forxer/gravatar Library](https://github.com/forxer/gravatar) - The underlying framework-agnostic library
- [Changelog](../CHANGELOG.md) - Version history and changes
- [Upgrade Guide](../UPGRADE.md) - Migration guides between versions

## Support

- **Issues**: [GitHub Issues](https://github.com/forxer/laravel-gravatar/issues)
- **Discussions**: [GitHub Discussions](https://github.com/forxer/laravel-gravatar/discussions)

## License

This package is open-source software licensed under the [MIT license](../LICENSE).
