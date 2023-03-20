UPGRADE
=======

From 1.x to 2.x
---------------

This package now requires at least **PHP 8** and **Laravel 8**, your project must correspond to this prerequisites.

Namespaces have been renamed from `forxer\LaravelGravatar\` to `LaravelGravatar\` :

- Find: `use forxer\LaravelGravatar\`
- Replace: `use LaravelGravatar\`

Since this version, if you use an undefined preset an exception is thrown. You must define presets before you can use them.
Please consult the chapter of the README concerning presets to adjust your settings.
