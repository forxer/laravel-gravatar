Installation
============

## Requirements

- PHP 8.4 or newer
- Laravel 12.0 or newer

For older PHP or Laravel versions, please refer to previous package versions:
- [Version 4.x](https://github.com/forxer/laravel-gravatar/tree/4.x) for PHP 8.2+ and Laravel 10-12
- [Version 2.x](https://github.com/forxer/laravel-gravatar/tree/2.x) for PHP 8.0+ and Laravel 8-9

## Installation via Composer

Install the package using Composer:

```bash
composer require forxer/laravel-gravatar
```

## Service Provider Registration

The package uses Laravel's auto-discovery feature, so the service provider and facade are automatically registered. You don't need to manually add them to your `config/app.php`.

## Configuration File (Optional)

The package works out of the box without any configuration. However, if you want to customize default settings or define presets, you can publish the configuration file:

```bash
php artisan vendor:publish --tag="gravatar-config"
```

This will create a `config/gravatar.php` file in your Laravel application. See the [Configuration](configuration.md) documentation for details on available options.

## Verify Installation

To verify the installation is working, you can use the helper in a route or controller:

```php
// routes/web.php
Route::get('/test-gravatar', function () {
    return gravatar('test@example.com')->size(200)->url();
});
```

Or test in Tinker:

```bash
php artisan tinker
```

```php
>>> gravatar('test@example.com')->size(120)->url()
=> "//www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0?s=120"
```

## Next Steps

- [Learn basic usage](usage.md) - Helpers, facades, and dependency injection
- [Configure presets](configuration.md) - Set up reusable avatar configurations
- [Explore parameters](parameters.md) - Customize your Gravatars
