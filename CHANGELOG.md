CHANGELOG
=========

3.0.0 (2023-03-22)
------------------

- Moved/renamed facade class from `LaravelGravatar\Facade` to `LaravelGravatar\Facades\Gravatar`
- Added `LaravelGravatar\Casts\GravatarImage` and `LaravelGravatar\Casts\GravatarProfile` casters
- Added methods for programmatic manipulation of image presets
- Integration of our own `LaravelGravatar\Image` and `LaravelGravatar\Profile` classes which respectively extend `Gravatar\Image` and `Gravatar\Profile` from "parent" package


2.0.1 (2023-03-20)
------------------

- Improved preset support
- Added some defaults customs presets
- Rewritten README file


2.0.0 (2023-03-18)
------------------

- Removed support for PHP prior to 8.0
- Removed support for Laravel prior to 8.0
- Use at least `forxer/gravatar` 4.0
- Renamed `forxer\LaravelGravatar\` namespace to `LaravelGravatar\`


1.9.0 (2023-02-21)
------------------

- Add support for Laravel 10.0


1.8.0 (2022-02-11)
------------------

- Add support for Laravel 9.0


1.7.0 (2020-09-20)
------------------

- Add support for Laravel 8.0


1.6.0 (2020-03-04)
------------------

- Add support for Laravel 7.0


1.5.1 (2019-12-30)
------------------

- Use Illuminate\Support\Str class instead of depreacated camel_case() helper


1.5.0 (2019-09-07)
------------------

- Add support for Laravel 6.0


1.4.0 (2019-03-07)
------------------

- Add support for Laravel 5.8


1.3.0 (2018-09-11)
------------------

- add support for Laravel 5.7


1.2.0 (2018-02-17)
------------------

- number version error: support a new release of Laravel is a new feature


1.1.1 (2018-02-11)
------------------

- add support for Laravel 5.6


1.1.0 (2017-10-01)
------------------

- Add support for Laravel 5.5


1.0.1 (2017-09-02)
------------------

- Fix call to default image via presets


1.0.0 (2017-08-31)
------------------

- First public release
