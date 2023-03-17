Laravel Gravatar
================

This package provides an easy Gravatar integration in a Laravel project.

This package is built on top of [forxer/Gravatar](https://github.com/forxer/gravatar).

Installation
------------

Install through composer:

```sh
composer require forxer/laravel-gravatar
```

In Laravel 5.5 the service provider will automatically get registered.
In older versions of the framework just add the service provider
to the array of providers in `config/app.php`:

```php
// config/app.php

'provider' => [
    //...
    forxer\LaravelGravatar\ServiceProvider::class,
    //...
];
```

In Laravel 5.5 the facade will automatically get registered.
In older versions of the framework just add the facade
to the array of aliases in `config/app.php`:

```php
// config/app.php

'aliases' => [
    //...
    'Gravatar' => forxer\LaravelGravatar\Facade::class,
    //...
];
```

Usage for Gravatar Images
-------------------------

### Directly in your views

With the helper:

```blade
<img src="{{ gravatar('email@example.com') }}">
// or
<img src="{{ gravatar()->image('email@example.com') }}">
// or
<img src="{{ gravatar()->avatar('email@example.com') }}">
```

Or with the facade:

```blade
<img src="{{ Gravatar::image('email@example.com') }}">
// or
<img src="{{ Gravatar::avatar('email@example.com') }}">
```

Or with the service injection:

```blade
@inject('gravatar', 'forxer\LaravelGravatar\Gravatar')

<img src="{{ $gravatar->image('email@example.com') }}">
// or
<img src="{{ $gravatar->avatar('email@example.com') }}">
```

### Optional parameters

You can set optional parameters:

```blade
<img src="{{ gravatar('email@example.com')->s(120)->e('png') }}">
// or
<img src="{{ gravatar('email@example.com')->size(120)->extension('png') }}">
// or
<img src="{{ gravatar('email@example.com')->setSize(120)->setExtension('png') }}">
```

There is several available parameters:

- size `setSize()` `size()` or `s()`
- default image `setDefaultImage()` `size()` or `s()`
- force default `setForceDefault()` `defaultImage()` or `d()`
- max rating `setMaxRating()` `rating()` or `r()`
- extension `setExtension()` `extension()` or `e()`

For more details, please refer to the [forxer/Gravatar documentation](https://github.com/forxer/gravatar#optional-parameters).

### Using presets

It is possible to define groups of defaults, known as presets. This is helpful if you have standard settings that you use throughout your app. In the configuration file, you can define as many avatar preset as you wish and a default preset to be used.

First, publish the config file of the package using artisan:

```sh
php artisan vendor:publish --provider="forxer\LaravelGravatar\ServiceProvider"
```

Then, define a preset in the configuration file:

```php
    'my_preset' => [
        'size' => 120,
        'extension' => 'png',
     ],
```

Finally, use it in your views by specifying its name.

```blade
<img src="{{ gravatar('email@example.com', 'my_preset') }}">
```


