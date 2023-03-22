[![Latest Stable Version](http://poser.pugx.org/forxer/laravel-gravatar/v)](https://packagist.org/packages/forxer/laravel-gravatar)
[![Total Downloads](http://poser.pugx.org/forxer/laravel-gravatar/downloads)](https://packagist.org/packages/forxer/laravel-gravatar)
[![License](http://poser.pugx.org/forxer/laravel-gravatar/license)](https://packagist.org/packages/forxer/laravel-gravatar)

Gravatar for Laravel
====================

This package provides an easy Gravatar integration in a Laravel project.

This package is built on top of [forxer/Gravatar](https://github.com/forxer/gravatar). If you want to dig deeper, you can find additional information on its README file.

```php
$avatar = gravatar('email@example.com')
    ->size(120)
    ->defaultImage('robohash')
    ->extension('jpg');
//...
echo $avatar;
```

Index
-----

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
    - [Retrieve instances](#retrieve-instances)
    - [Show directly in your views](#show-directly-in-your-views)
- [Mandatory parameter](#mandatory-parameter)
- [Optional parameters](#optional-parameters)
    - [Gravatar image size](#gravatar-image-size)
    - [Default Gravatar image](#default-gravatar-image)
    - [Gravatar image max rating](#gravatar-image-max-rating)
    - [Gravatar image file-type extension](#gravatar-image-file-type-extension)
    - [Force to always use the default image](#force-to-always-use-the-default-image)
    - [Combine them](#combine-them)
- [Image presets](#image-presets)
- [Casts](#casts)


Requirements
------------

- PHP 8.0 or newer
- Laravel 8.0 or newer

If you want to use it with a version earlier than PHP 8 and/or a version earlier than Laravel 8, please use [version 1](https://github.com/forxer/laravel-gravatar/tree/1.x).

Installation
------------

Install through composer:

```sh
composer require forxer/laravel-gravatar
```

Usage
-----

There are three ways to use this library:

- With the `gravatar()` helper fonction
- With the facade `Gravatar::create()`
- Or by injecting the `LaravelGravatar\Gravatar` service

All of these ways return an instance of the `LaravelGravatar\Gravatar` service. The Gravatar service has 3 main methods :

- `image()` which return an instance of `LaravelGravatar\Image` wich extends `Gravatar\Image` from [forxer/Gravatar](https://github.com/forxer/gravatar)
- `avatar()` which is an alias of the first
- `profile()` which return an instance of `LaravelGravatar\Profile` wich extends `Gravatar\Profile` from [forxer/Gravatar](https://github.com/forxer/gravatar)

This instances of `LaravelGravatar\Image` and `LaravelGravatar\Profile` allow you to define specific settings/parameters as needed. So you can use them to build Gravatar images/profiles URL.

Whatever method you use, you could use the `url()` method to retrieve it. Or display the URL directly because they implement the `__toString()` method.

### Retrieve instances

With the helper

```php
$gravatar = gravatar();
// LaravelGravatar\Gravatar instance

$avatar = gravatar('email@example.com');
// LaravelGravatar\Image instance

$avatar = gravatar()->image('email@example.com');
// LaravelGravatar\Image instance

$avatar = gravatar()->avatar('email@example.com');
// LaravelGravatar\Image instance

$profile = gravatar()->profile('email@example.com');
// LaravelGravatar\Profile instance
```

Or with the facade:

```php
use LaravelGravatar\Facades\Gravatar;

$gravatar = Gravatar::create();
// LaravelGravatar\Gravatar instance

$avatar = Gravatar::image('email@example.com');
// LaravelGravatar\Image instance

$avatar = Gravatar::avatar('email@example.com');
// LaravelGravatar\Image instance

$profile = Gravatar::profile('email@example.com');
// LaravelGravatar\Profile instance
```

Or with the service injection:

```php
use App\Models\User;
use LaravelGravatar\Gravatar as Gravatar;

class UserController
{
    public function show(User $user, Gravatar $gravatar)
    {
        $avatar = $gravatar->avatar($user->email);

        $profile = $gravatar->profile($user->email);
    }
}
```

### Show directly in your views

```blade
<img src="{{ gravatar('email@example.com') }}">

<img src="{{ Gravatar::avatar('email@example.com') }}">

<img src="{{ $avatar }}">
```

[Back to top ^](#gravatar-for-Laravel)

Mandatory parameter
-------------------

Obviously the email address is a mandatory parameter that can be entered in different ways.

```php
// pass it as argument of the helper
$gravatarImage = gravatar($email);

// or use the `setEmail()` method
$gravatarImage = gravatar();
$gravatarImage->setEmail($email);

// or the `email()` helper method
$gravatarImage = gravatar();
$gravatarImage->email($email);
```

These previous examples are also valid for the profile.

[Back to top ^](#gravatar-for-Laravel)

Optional parameters
-------------------

In all the examples below we will use the helper but it obviously works with the facade or the dependency injection of the service.

### Gravatar image size

By default, images are presented at 80px by 80px if no size parameter is supplied.
You may request a specific image size, which will be dynamically delivered from Gravatar.
You may request images anywhere from 1px up to 2048px, however note that many users have lower resolution images,
so requesting larger sizes may result in pixelation/low-quality images.

An avatar size should be an integer representing the size in pixels.

```php
// use the `setSize()` method
$gravatarImage = gravatar($email);
$gravatarImage->setSize(120);

// or the `size()` helper method
$gravatarImage = gravatar($email);
$gravatarImage->size(120);

// or its alias `s()` (as in the generated query string)
$gravatarImage = gravatar($email);
$gravatarImage->s(120);
```

[Back to top ^](#gravatar-for-Laravel)

### Default Gravatar image

What happens when an email address has no matching Gravatar image or when the gravatar specified exceeds your maximum allowed content rating?

By default, this:

![Default Gravatar image](http://www.gravatar.com/avatar/00000000000000000000000000000000)

If you'd prefer to use your own default image, then you can easily do so by supplying the URL to an image.
In addition to allowing you to use your own image, Gravatar has a number of built in options which you can also use as defaults.
Most of these work by taking the requested email hash and using it to generate a themed image that is unique to that email address.
To use these options, just pass one of the following keywords:

- '404': do not load any image if none is associated with the email hash, instead return an HTTP 404 (File Not Found) response
- 'mp': (mystery-person) a simple, cartoon-style silhouetted outline of a person (does not vary by email hash)
- 'identicon': a geometric pattern based on an email hash
- 'monsterid': a generated 'monster' with different colors, faces, etc
- 'wavatar': generated faces with differing features and backgrounds
- 'retro': awesome generated, 8-bit arcade-style pixelated faces
- 'robohash': a generated robot with different colors, faces, etc
- 'blank': a transparent PNG image

![Mystery-man default Gravatar image](http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y)
![Identicon default Gravatar image](http://www.gravatar.com/avatar/00000000000000000000000000000000?d=identicon&f=y)
![Wavatar default Gravatar image](http://www.gravatar.com/avatar/00000000000000000000000000000000?d=wavatar&f=y)
![Retro default Gravatar image](http://www.gravatar.com/avatar/00000000000000000000000000000000?d=retro&f=y)
![Robohash default Gravatar image](http://www.gravatar.com/avatar/00000000000000000000000000000000?d=robohash&f=y)
![Blank default Gravatar image](http://www.gravatar.com/avatar/00000000000000000000000000000000?d=blank&f=y)

```php
// use the `setDefaultImage()` method
$gravatarImage = gravatar($email);
$gravatarImage->setDefaultImage('mp');

// or the `defaultImage()` helper method
$gravatarImage = gravatar($email);
$gravatarImage->defaultImage('mp');

// or its alias `d()` (as in the generated query string)
$gravatarImage = gravatar($email);
$gravatarImage->d('mp');
```

[Back to top ^](#gravatar-for-Laravel)

### Gravatar image max rating

Gravatar allows users to self-rate their images so that they can indicate if an image is appropriate for a certain audience.
By default, only 'g' rated images are displayed unless you indicate that you would like to see higher ratings.

You may specify one of the following ratings to request images up to and including that rating:

- 'g': suitable for display on all websites with any audience type.
- 'pg': may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
- 'r': may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
- 'x': may contain hardcore sexual imagery or extremely disturbing violence.

```php
// use the `setMaxRating()` method
$gravatarImage = gravatar($email);
$gravatarImage->setMaxRating('g');

// or the `maxRating()` helper method
$gravatarImage = gravatar($email);
$gravatarImage->maxRating('g');

// or its alias `r()` (as in the generated query string)
$gravatarImage = gravatar($email);
$gravatarImage->r('g');
```

[Back to top ^](#gravatar-for-Laravel)

### Gravatar image file-type extension

If you require a file-type extension (some places do) then you may also specify it.

You can specify one of the following extensions for the generated URL:

- 'jpg'
- 'jpeg'
- 'gif'
- 'png'
- 'webp'

```php
// use the `setExtension()` method
$gravatarImage = gravatar($email);
$gravatarImage->setExtension('jpg');

// or the `extension()` helper method
$gravatarImage = gravatar($email);
$gravatarImage->extension('jpg');

// or its alias `e()` (as in the generated query string)
$gravatarImage = gravatar($email);
$gravatarImage->e('jpg');
```

[Back to top ^](#gravatar-for-Laravel)

### Force to always use the default image

If for some reason you wanted to force the default image to always be load, you can do it:

```php
// use the `setForceDefault()` method
$gravatarImage = gravatar($email);
$gravatarImage->setForceDefault(true);

// or the `forceDefault()` helper method
$gravatarImage = gravatar($email);
$gravatarImage->forceDefault(true);

// or its alias `f()` (as in the generated query string)
$gravatarImage = gravatar($email);
$gravatarImage->f(true);

// or use the `enableForceDefault()` method
$gravatarImage = gravatar($email);
$gravatarImage->setForceDefault(true);
```

To check to see if you are forcing default image, call the method `forcingDefault()` of `LaravelGravatar\Image`,
which will return a boolean value regarding whether or not forcing default is enabled.

```php
$gravatarImage = gravatar();
$gravatarImage->enableForceDefault();
//...
$gravatarImage->forcingDefault(); // true
//...
$gravatarImage->disableForceDefault();
//...
$gravatarImage->forcingDefault(); // false
```

[Back to top ^](#gravatar-for-Laravel)

### Combine them

You can combine them seamlessly:

```php
$avatar = gravatar('email@example.com')
    ->size(120)
    ->rating('pg')
    ->defaultImage('robohash')
    ->extension('jpg');
```

[Back to top ^](#gravatar-for-Laravel)

Image presets
-------------

It is possible to define groups of defaults parameters, known as presets. This is helpful if you have standard settings that you use throughout your application. In the configuration file, you can define as many gravatar presets as you wish and a default preset to be used.

First, publish the config file of the package using artisan:

```sh
php artisan vendor:publish --tag="gravatar-config"
```

And define some presets in the configuration file in the 'presets' array. There are a few predefined presets for the example in the configuration file, but you are of course free to delete them and define ones that suit your needs. For example:

```php
    'my_default' => [
        'size' => 80,
        'default_image' => 'mp',
        'max_rating' => 'g',
        'extension' => 'webp',
    ],
    'small' => [
        'size' => 40,
        'extension' => 'jpg',
     ],
    'medium' => [
        'size' => 120,
        'extension' => 'jpg',
     ],
    'large' => [
        'size' => 360,
        'default_image' => 'robohash',
        'max_rating' => 'pg',
     ],
```

In the configuration file, for the values key name, as these are array keys and we follow naming conventions, you can use either:

- `'size'` or `'s'`
- `'default_image'` or `'d'`
- `'max_rating'` or `'r'`
- `'extension'` or `'e'`
- `'force_default'` or `'f'`

If you wish you can default to one of these presets at the top of the configuration file.

```php
    'default_preset' => 'my_default',
```

Then, use it in your application with the second argument:

```php
$gravatarImage = gravatar($email, 'small');

$gravatarImage = gravatar()->image($email, 'medium');

$gravatarImage = Gravatar::image($email, 'large');
```

Or you can set it later after instantiation:

```php
// use the `setPreset()` method
$gravatarImage = gravatar($email);
$gravatarImage->setPreset('small');

// or the `preset()` helper method
$gravatarImage = gravatar($email);
$gravatarImage->preset('small');
```

[Back to top ^](#gravatar-for-Laravel)

Casts
-----

Let's imagine that your user model has a column "gravatar" which represents the email to use. You can cast this attribute to directly obtain an instance of `LaravelGravatar\Image`:

```php
use LaravelGravatar\Casts\GravatarImage;

class Post extends Model
{
    protected $casts = [
        'gravatar' => GravatarImage::class,
    ];
}
```

Thus it is easy to access the instance and manipulate it:

```php
use App\Models\User;

class UserController
{
    public function show(User $user)
    {
        $user->gravatar->preset('small');

        return view('users.show', [
            'user' => $user,
        ]);
    }
}
```

You can even define a preset name to be used when casting by appending it's name to the cast:

```php
use LaravelGravatar\Casts\GravatarImage;

class Post extends Model
{
    protected $casts = [
        'gravatar' => GravatarImage::class.':small',
    ];
}
```

You can also cast to an instance of `LaravelGravatar\Profile`:

```php
use LaravelGravatar\Casts\GravatarProfile;

class Post extends Model
{
    protected $casts = [
        'gravatar' => GravatarProfile::class,
    ];
}
```

[Back to top ^](#gravatar-for-Laravel)
