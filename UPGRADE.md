UPGRADE
=======

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
