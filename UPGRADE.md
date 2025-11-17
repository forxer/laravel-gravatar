UPGRADE
=======

From 4.x to 5.x
---------------

This package now requires at least **PHP 8.4** and **Laravel 12**, your project must correspond to these prerequisites.

### Breaking changes

#### 1. PHP and Laravel version requirements

- **PHP version**: Minimum PHP version raised from 8.2 to 8.4
- **Laravel version**: Support dropped for Laravel 10 and 11, now requires Laravel 12+
- **Gravatar library**: Updated to `forxer/gravatar` 6.0

#### 2. Removed getter methods (from parent library)

All getter methods from the base `Gravatar\Image` and `Gravatar\Profile` classes have been removed. Use direct property access instead:

```php
// Before (v4.x)
$email = $image->getEmail();
$size = $image->getSize();
$extension = $image->getExtension();
$maxRating = $image->getMaxRating();
$defaultImage = $image->getDefaultImage();
$initials = $image->getInitials();
$initialsName = $image->getName();
$forceDefault = $image->getForceDefault();

// After (v5.x)
$email = $image->email;
$size = $image->size;
$extension = $image->extension;
$maxRating = $image->maxRating;
$defaultImage = $image->defaultImage;
$initials = $image->initials;
$initialsName = $image->initialsName;
$forceDefault = $image->forceDefault;
```

#### 3. Removed setter methods (from parent library)

All setter methods from the base library have been removed. Use helper methods or direct property assignment instead:

```php
// Before (v4.x)
$image->setEmail('email@example.com');
$image->setSize(120);
$image->setExtension('jpg');
$image->setMaxRating('pg');
$image->setDefaultImage('robohash');
$image->setForceDefault(true);
$image->setInitials('JD');
$image->setName('John Doe');

// After (v5.x) - use helper methods (recommended)
$image->email('email@example.com');
$image->size(120);
$image->extension('jpg');
$image->maxRating('pg');
$image->defaultImage('robohash');
$image->forceDefault(true);
$image->initials('JD');
$image->initialsName('John Doe');  // Note: renamed from setName()

// Or use direct property assignment
$image->email = 'email@example.com';
$image->size = 120;
$image->extension = 'jpg';
```

#### 4. Renamed property and method

The `name` property and `withName()` method have been renamed to `initialsName` and `withInitialsName()` for better clarity:

```php
// Before (v4.x)
$image->withName('John Doe');
$name = $image->name;

// After (v5.x)
$image->withInitialsName('John Doe');
$name = $image->initialsName;
```

#### 5. Removed short alias methods (from parent library)

The short alias methods (`s()`, `e()`, `r()`, `d()`, `f()`) have been removed:

```php
// Before (v4.x)
$image->s(120);       // size
$image->e('jpg');     // extension
$image->r('pg');      // rating
$image->d('mp');      // default image
$image->f(true);      // force default

// After (v5.x) - use full method names
$image->size(120);
$image->extension('jpg');
$image->maxRating('pg');
$image->defaultImage('mp');
$image->forceDefault(true);

// Or use new fluent shorthand methods (recommended)
$image->extensionJpg()
      ->ratingPg()
      ->defaultImageMp();
```

#### 6. Preset configuration keys

If you use custom presets in your `config/gravatar.php` file, ensure you're using full key names (not the short aliases):

```php
// Before (v4.x) - short aliases were supported
'my_preset' => [
    's' => 120,      // size
    'e' => 'jpg',    // extension
    'r' => 'pg',     // rating
    'd' => 'mp',     // default
    'f' => true,     // force default
],

// After (v5.x) - use full names only
'my_preset' => [
    'size' => 120,
    'extension' => 'jpg',
    'max_rating' => 'pg',
    'default_image' => 'mp',
    'force_default' => true,
],
```

### New features in v5.x

#### 1. New `gravatar_profile()` helper

A dedicated helper function for creating profile instances:

```php
// Before (v4.x) - no dedicated helper for profiles
use LaravelGravatar\Facades\Gravatar;
$profile = Gravatar::profile('email@example.com');

// After (v5.x) - dedicated helper available
$profile = gravatar_profile('email@example.com');
$profile = gravatar_profile('email@example.com', 'json');
```

#### 2. Improved `gravatar()` helper

The `gravatar()` helper now always returns an `Image` instance for consistency:

```php
// Both return Image instances
$avatar = gravatar('email@example.com');
$avatar = gravatar();  // Email can be set later
$avatar->email = 'email@example.com';
```

#### 3. Type-safe enums

You can now use enum classes for better type safety and IDE support:

```php
use Gravatar\Enum\Rating;
use Gravatar\Enum\Extension;
use Gravatar\Enum\DefaultImage;

$image->maxRating(Rating::PG)
      ->extension(Extension::WEBP)
      ->defaultImage(DefaultImage::ROBOHASH);
```

#### 4. Fluent shorthand methods

New fluent methods provide cleaner syntax:

```php
$image->ratingPg()
      ->extensionWebp()
      ->defaultImageRobohash();
```

See the [README](README.md) for complete documentation on enums and fluent methods.

#### 4. Preset validation with enums

**New in v5.0:** Preset configurations are now automatically validated using enums at runtime.

Invalid preset values will throw detailed exceptions:

```php
// config/gravatar.php
'presets' => [
    'invalid' => [
        'extension' => 'bmp',  // ❌ Will throw InvalidArgumentException
    ],
],

// Exception message:
// Invalid extension "bmp". Valid values: jpg, jpeg, png, gif, webp
```

**Action required:** Review your preset configurations to ensure all values are valid:
- `extension`: Must be `jpg`, `jpeg`, `png`, `gif`, or `webp`
- `max_rating`: Must be `g`, `pg`, `r`, or `x`
- `default_image`: Must be a valid enum value or a URL

This validation helps catch configuration errors early, preventing invalid Gravatar URLs from being generated.

### Migration steps

1. **Update your PHP version to 8.4 or higher**

2. **Update your Laravel application to version 12.0 or newer**

3. **Update the package:**
   ```bash
   composer require forxer/laravel-gravatar:^5.0
   ```

4. **Replace getter method calls with direct property access:**
   - Find: `->getEmail()` → Replace: `->email`
   - Find: `->getSize()` → Replace: `->size`
   - Find: `->getExtension()` → Replace: `->extension`
   - Find: `->getMaxRating()` → Replace: `->maxRating`
   - Find: `->getDefaultImage()` → Replace: `->defaultImage`
   - Find: `->getInitials()` → Replace: `->initials`
   - Find: `->getName()` → Replace: `->initialsName`
   - Find: `->getForceDefault()` → Replace: `->forceDefault`

5. **Replace setter method calls with helper methods:**
   - Find: `->setEmail(` → Replace: `->email(`
   - Find: `->setSize(` → Replace: `->size(`
   - Find: `->setExtension(` → Replace: `->extension(`
   - Find: `->setMaxRating(` → Replace: `->maxRating(`
   - Find: `->setDefaultImage(` → Replace: `->defaultImage(`
   - Find: `->setInitials(` → Replace: `->initials(`
   - Find: `->setName(` → Replace: `->initialsName(`
   - Find: `->setForceDefault(` → Replace: `->forceDefault(`

6. **Replace short alias methods:**
   - Find: `->s(` → Replace: `->size(`
   - Find: `->e(` → Replace: `->extension(`
   - Find: `->r(` → Replace: `->maxRating(`
   - Find: `->d(` → Replace: `->defaultImage(`
   - Find: `->f(` → Replace: `->forceDefault(`

7. **Update preset configurations** to use full key names (see section 6 above)

8. **Test your application thoroughly** to ensure compatibility with PHP 8.4 and Laravel 12


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
