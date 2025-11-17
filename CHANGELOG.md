CHANGELOG
=========

5.0.0 (unreleased)
------------------

### Breaking Changes

- **Minimum PHP version increased to 8.4**
- **Minimum Laravel version increased to 12.0** - dropped support for Laravel 10 and 11
- **Updated to `forxer/gravatar` 6.0** - inherits all breaking changes from the parent library:
  - Removed getter methods: `getEmail()`, `getSize()`, `getExtension()`, `getMaxRating()`, `getDefaultImage()`, `getInitials()`, `getName()`, `getForceDefault()` - use direct property access instead (e.g., `$image->size` instead of `$image->getSize()`)
  - Removed setter methods: `setEmail()`, `setSize()`, `setExtension()`, `setMaxRating()`, `setDefaultImage()`, `setInitials()`, `setName()`, `setForceDefault()` - use helper methods or direct property assignment instead (e.g., `$image->size(120)` or `$image->size = 120`)
  - Renamed property and method: `name` → `initialsName` and `withName()` → `withInitialsName()` for better clarity
  - Removed short alias methods: `s()`, `e()`, `r()`, `d()`, `f()` - use full helper method names or new fluent shorthand methods instead
- **Preset configuration keys**: Short aliases (`s`, `e`, `r`, `d`, `f`) are no longer supported in preset configurations - use full key names (`size`, `extension`, `max_rating`, `default_image`, `force_default`)

### Improvements

- **PHP 8.4 Features**:
  - Property Hooks: All properties use property hooks with automatic conversion and validation
  - Asymmetric Visibility: `config` and `presetName` properties use `public private(set)` for read-public, write-private access
  - Strict Types: All files now use `declare(strict_types=1)`
- **Type-safe Enums**: Can now use enum classes (`Rating`, `Extension`, `DefaultImage`, `ProfileFormat`) for better IDE support and type safety
- **Fluent Shorthand Methods**: Added support for convenient fluent methods (convenience methods):
  - Rating: `ratingG()`, `ratingPg()`, `ratingR()`, `ratingX()`
  - Extension: `extensionJpg()`, `extensionJpeg()`, `extensionGif()`, `extensionPng()`, `extensionWebp()`
  - Default images: `defaultImageInitials()`, `defaultImageColor()`, `defaultImageNotFound()`, `defaultImageMp()`, `defaultImageIdenticon()`, `defaultImageMonsterid()`, `defaultImageWavatar()`, `defaultImageRetro()`, `defaultImageRobohash()`, `defaultImageBlank()`
  - Profile formats: `formatJson()`, `formatXml()`, `formatPhp()`, `formatVcf()`, `formatQr()`
  - Initials: `withInitials()`, `withInitialsName()`
  - Force default: `enableForceDefault()`, `disableForceDefault()`, `forcingDefault()`
- **Direct Property Assignment**: Properties can now be assigned directly with automatic validation through PHP 8.4 property hooks (e.g., `$avatar->size = 120`)
- **Dual-mode helper methods**: All helper methods work in both setter mode (with argument) and getter mode (without argument) for maximum flexibility
- **Improved `gravatar()` helper**: Now always returns an `Image` instance (even when called without parameters), making it more consistent and intuitive
- **New `gravatar_profile()` helper**: Added a dedicated helper function for creating profile instances, following the pattern from the parent library
- **Code Quality Improvements**:
  - Converted `allowedSetterPresetKeys()` method to `ALLOWED_PRESET_KEYS` constant for better performance
  - Refactored `toBase64()` with early returns pattern for improved readability
  - Simplified `profile()` method from 7 lines to 3 lines
  - Modernized with Laravel 12 patterns: replaced `Container::getInstance()` with `app()` helper
  - Added comprehensive PHPDoc documentation with array shapes and conditional return types
  - Fixed incorrect return type in `GravatarProfile` cast (was `Image`, now `Profile`)
  - Enhanced PHPDoc consistency: all constructors, helpers, and facade methods fully documented
  - All return types explicitly declared across the entire codebase
- **Updated internal code**:
  - Fixed `Image::toBase64()` to use property access (`$this->email`) instead of removed `getEmail()` method
  - Fixed `Gravatar::profile()` to use `format()` method instead of removed `setFormat()` method
  - Removed short aliases from preset configuration allowed keys
  - Added support for `initials` and `initials_name` keys in preset configurations
- **Profile enhancements**:
  - Direct access to `Profile::getData()` method for fetching Gravatar profile data
  - Inherited from parent library automatically
- **Comprehensive documentation restructure**:
  - Split documentation into dedicated files in `docs/` directory
  - Added Laravel-focused documentation for all features
  - All properties documented in order: 1) Helper methods, 2) Convenience methods, 3) Direct properties
  - Complete migration guide in UPGRADE.md


4.3.0 (2025-11-16)
------------------

- Using `forxer/gravatar` 5.3
- Improved documentation


4.2.1 (2025-11-12)
------------------

- Stricter typings for return values + Facade docblock


4.2.0 (2025-09-16)
------------------

- Added ability to convert the Gravatar image to a base64-encoded data URL


4.1.0 (2025-03-18)
------------------

- Added support for Laravel 12.0


4.0.0 (2024-05-26)
------------------

- Added support for Laravel 11.0
- Removed support for PHP prior to 8.2
- Removed support for Laravel prior to 10.0
- Removed support for `forxer/gravatar` prior to 5.0


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
- Removed support for `forxer/gravatar` prior to 4.0
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
