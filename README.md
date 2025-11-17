[![Latest Stable Version](http://poser.pugx.org/forxer/laravel-gravatar/v)](https://packagist.org/packages/forxer/laravel-gravatar)
[![Total Downloads](http://poser.pugx.org/forxer/laravel-gravatar/downloads)](https://packagist.org/packages/forxer/laravel-gravatar)
[![License](http://poser.pugx.org/forxer/laravel-gravatar/license)](https://packagist.org/packages/forxer/laravel-gravatar)

Gravatar for Laravel
====================

This package provides an easy Gravatar integration in a Laravel project.

```php
use Gravatar\Enum\DefaultImage;
use Gravatar\Enum\Extension;

// Simple usage
$avatar = gravatar('email@example.com')
    ->size(120)
    ->defaultImage('robohash')
    ->extension('jpg');
echo $avatar;

// With type-safe enums
$avatar = gravatar('email@example.com')
    ->size(120)
    ->defaultImage(DefaultImage::ROBOHASH)
    ->extension(Extension::JPG);

// With fluent shorthand methods
$avatar = gravatar('email@example.com')
    ->size(120)
    ->extensionJpg()
    ->defaultImageRobohash();
```

## About this package

This Laravel package is built on top of the framework-agnostic **[forxer/gravatar](https://github.com/forxer/gravatar)** library. It extends the base functionality by adding:

- **Laravel-specific features**: Service providers, facades, helper functions (`gravatar()` and `gravatar_profile()`), and configuration
- **Extended classes**: `LaravelGravatar\Image` extends `Gravatar\Image`, and `LaravelGravatar\Profile` extends `Gravatar\Profile`
- **Additional Laravel integrations**: Eloquent casts, preset configurations, and base64 conversion with Laravel's HTTP client
- **Full support for PHP 8.4 features**: Property hooks, type-safe enums, and fluent shorthand methods from the parent library

All the core Gravatar functionality from the parent library is available in this package.

## Documentation

**Complete documentation is available in the [docs](docs/) directory:**

- **[Overview](docs/index.md)** - Introduction and quick start
- **[Installation](docs/installation.md)** - Install and configure
- **[Usage](docs/usage.md)** - Helpers, facades, and dependency injection
- **[Parameters](docs/parameters.md)** - All available Gravatar parameters
- **[Enums](docs/enums.md)** - Type-safe enums and fluent methods
- **[Configuration](docs/configuration.md)** - Configure the package
- **[Presets](docs/presets.md)** - Complete guide to preset configurations
- **[Casts](docs/casts.md)** - Eloquent model integration
- **[Advanced Features](docs/advanced.md)** - Base64 conversion, copying, and more

## Requirements

- **PHP 8.4+**
- **Laravel 12.0+**

For earlier versions:
- [Version 4.x](https://github.com/forxer/laravel-gravatar/tree/4.x) - PHP 8.2+ and Laravel 10.0+
- [Version 2.x](https://github.com/forxer/laravel-gravatar/tree/2.x) - PHP 8.0+ and Laravel 8.0+
- [Version 1.x](https://github.com/forxer/laravel-gravatar/tree/1.x) - Older versions

## Quick Installation

```bash
composer require forxer/laravel-gravatar
```

The service provider is automatically registered via package discovery.

## Quick Start

```php
// Simple usage with helper
<img src="{{ gravatar($user->email) }}" alt="Avatar">

// With configuration
$avatar = gravatar('user@example.com')
    ->size(120)
    ->extensionWebp()
    ->defaultImageRobohash();

// Using presets
$avatar = gravatar($user->email, 'small');

// With Eloquent casts
class User extends Model
{
    protected $casts = [
        'email' => GravatarImage::class.':medium',
    ];
}

// In Blade
<img src="{{ $user->email }}" alt="Avatar">
```

## Key Features

- **Helper functions** - `gravatar()` and `gravatar_profile()` for quick access
- **Facade support** - `Gravatar::image()` and `Gravatar::profile()`
- **Eloquent casts** - Seamless model integration
- **Preset configurations** - Define reusable avatar settings with automatic validation
- **Enum-based validation** - Preset values validated against type-safe enums at runtime
- **Base64 conversion** - Convert avatars to data URLs
- **PHP 8.4 property hooks** - Direct property access with validation
- **Type-safe enums** - `Rating`, `Extension`, `DefaultImage`, `ProfileFormat`
- **Fluent shorthand methods** - `extensionWebp()`, `ratingPg()`, `defaultImageRobohash()`

## Version History

See [CHANGELOG.md](CHANGELOG.md) for all changes.

## Upgrading

See [UPGRADE.md](UPGRADE.md) for upgrade instructions between major versions.

## License

This package is open-source software licensed under the [MIT license](LICENSE).
