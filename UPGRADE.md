UPGRADE
=======

From 4.x to 5.x
---------------

This package now requires at least **PHP 8.4** and **Laravel 12**, your project must correspond to these prerequisites.

### Breaking changes

- **PHP version**: Minimum PHP version raised from 8.2 to 8.4
- **Laravel version**: Support dropped for Laravel 10 and 11, now requires Laravel 12+
- **Gravatar library**: Updated to `forxer/gravatar` 6.0

### Migration steps

1. Update your project to PHP 8.4 or newer
2. Update your Laravel application to version 12.0 or newer
3. Update the package: `composer require forxer/laravel-gravatar:^5.0`

No code changes should be necessary for most applications, as this is primarily a dependency update. However, you should test your application thoroughly to ensure compatibility with PHP 8.4 and Laravel 12.


From 3.x to 4.x
---------------

This package now requires at least **PHP 8.2** and **Laravel 10**, your project must correspond to this prerequisites.


From 2.x to 3.x
---------------

Facade class moved/renamed from `LaravelGravatar\Facade` to `LaravelGravatar\Facades\Gravatar`, you need to replace calls to this one if you used it.

For example:

- Find: `use LaravelGravatar\Facade as Gravatar;`
- Replace: `use LaravelGravatar\Facades\Gravatar;`

Integration of our own `LaravelGravatar\Image` and `LaravelGravatar\Profile` classes which respectively extend `Gravatar\Image` and `Gravatar\Profile` from "parent" package. You should replace calls to these if you used them.

For example:

- Find: `use Gravatar\Image;`
- Replace: `use LaravelGravatar\Image;`

- Find: `use Gravatar\Profile;`
- Replace: `use LaravelGravatar\Profile;`


From 1.x to 2.x
---------------

This package now requires at least **PHP 8** and **Laravel 8**, your project must correspond to this prerequisites.

Namespaces have been renamed from `forxer\LaravelGravatar\` to `LaravelGravatar\` :

- Find: `use forxer\LaravelGravatar\`
- Replace: `use LaravelGravatar\`

Since this version, if you use an undefined preset an exception is thrown. You must define presets before you can use them.
Please consult the chapter of the README concerning presets to adjust your settings.
