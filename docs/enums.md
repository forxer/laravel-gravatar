Type-Safe Enums and Fluent Methods
====================================

Laravel Gravatar (using `forxer/gravatar` v7) provides type-safe enums and fluent shorthand methods for a better developer experience.

## Why Use Enums?

Enums provide:
- **Type safety** - Catch typos at compile time
- **IDE autocompletion** - See all available options
- **Better refactoring** - Change values safely
- **Self-documenting code** - Clear, explicit values

## Available Enums

All enums are in the `Gravatar\Enum` namespace.

### Rating

```php
use Gravatar\Enum\Rating;

Rating::G   // Suitable for all audiences
Rating::PG  // May contain mild content
Rating::R   // May contain harsh content
Rating::X   // May contain adult content
```

### Extension

```php
use Gravatar\Enum\Extension;

Extension::JPG
Extension::JPEG
Extension::PNG
Extension::GIF
Extension::WEBP
```

### DefaultImage

```php
use Gravatar\Enum\DefaultImage;

DefaultImage::INITIALS       // Initials with generated colors
DefaultImage::COLOR          // Generated solid color
DefaultImage::NOT_FOUND      // 404 - no image
DefaultImage::MYSTERY_PERSON // Simple silhouette (mp)
DefaultImage::IDENTICON      // Geometric pattern
DefaultImage::MONSTERID      // Generated monster
DefaultImage::WAVATAR        // Generated face
DefaultImage::RETRO          // 8-bit pixelated face
DefaultImage::ROBOHASH       // Generated robot
DefaultImage::BLANK          // Transparent PNG
```

## Using Enums

Enums can be used with helper methods or direct property assignment. Strings are still accepted for backward compatibility.

**1. With helper methods:**

```php
use Gravatar\Enum\Rating;
use Gravatar\Enum\Extension;
use Gravatar\Enum\DefaultImage;

$avatar = gravatar('user@example.com')
    ->maxRating(Rating::PG)
    ->extension(Extension::WEBP)
    ->defaultImage(DefaultImage::ROBOHASH);
```

**2. With convenience methods (fluent shorthand):**

Fluent shorthand methods provide the most concise syntax (see section below).

**3. With direct property assignment:**

```php
use Gravatar\Enum\Rating;
use Gravatar\Enum\DefaultImage;

$avatar = gravatar('user@example.com');
$avatar->maxRating = Rating::PG;
$avatar->defaultImage = DefaultImage::IDENTICON;
```

### Mixed Usage

You can mix enums and strings - both work:

```php
use Gravatar\Enum\Rating;

$avatar = gravatar('user@example.com')
    ->maxRating(Rating::PG)      // Enum with helper method
    ->extension('webp')           // String with helper method
    ->defaultImage('robohash');   // String with helper method
```

## Fluent Shorthand Methods

For even cleaner code, use fluent shorthand methods. These are pre-defined methods that set specific enum values.

### Rating Shortcuts

```php
$avatar = gravatar('user@example.com')
    ->ratingG()   // Set rating to G
    ->ratingPg()  // Set rating to PG
    ->ratingR()   // Set rating to R
    ->ratingX();  // Set rating to X
```

### Extension Shortcuts

```php
$avatar = gravatar('user@example.com')
    ->extensionJpg()
    ->extensionJpeg()
    ->extensionPng()
    ->extensionGif()
    ->extensionWebp();
```

### Default Image Shortcuts

```php
$avatar = gravatar('user@example.com')
    ->defaultImageInitials()      // Initials
    ->defaultImageColor()          // Color
    ->defaultImageNotFound()       // 404
    ->defaultImageMp()             // Mystery person
    ->defaultImageIdenticon()      // Identicon
    ->defaultImageMonsterid()      // Monsterid
    ->defaultImageWavatar()        // Wavatar
    ->defaultImageRetro()          // Retro
    ->defaultImageRobohash()       // Robohash
    ->defaultImageBlank();         // Blank
```

## Combining Fluent Methods

Chain multiple fluent methods for clean, readable code:

```php
$avatar = gravatar('user@example.com')
    ->size(120)
    ->extensionWebp()
    ->ratingPg()
    ->defaultImageRobohash();
```

## Comparison of Approaches

All approaches achieve the same result. Choose based on your preference and use case:

**1. Using helper methods with strings:**

```php
$avatar = gravatar('user@example.com')
    ->size(120)
    ->extension('webp')
    ->maxRating('pg')
    ->defaultImage('robohash');
```

**2. Using helper methods with enums (type-safe):**

```php
use Gravatar\Enum\{Extension, Rating, DefaultImage};

$avatar = gravatar('user@example.com')
    ->size(120)
    ->extension(Extension::WEBP)
    ->maxRating(Rating::PG)
    ->defaultImage(DefaultImage::ROBOHASH);
```

**3. Using convenience methods (fluent shortcuts - most concise):**

```php
$avatar = gravatar('user@example.com')
    ->size(120)
    ->extensionWebp()
    ->ratingPg()
    ->defaultImageRobohash();
```

**4. Using direct properties:**

```php
use Gravatar\Enum\{Extension, Rating, DefaultImage};

$avatar = gravatar('user@example.com');
$avatar->size = 120;
$avatar->extension = Extension::WEBP;
$avatar->maxRating = Rating::PG;
$avatar->defaultImage = DefaultImage::ROBOHASH;
```

## In Blade Templates

```blade
{{-- Using fluent methods --}}
<img src="{{ gravatar($user->email)->size(80)->extensionWebp()->ratingPg() }}" alt="Avatar">

{{-- Using enums --}}
@php
use Gravatar\Enum\DefaultImage;
@endphp
<img src="{{ gravatar($user->email)->defaultImage(DefaultImage::ROBOHASH) }}" alt="Avatar">

{{-- Mix and match --}}
<img src="{{ gravatar($user->email)->extensionJpg()->defaultImage('identicon') }}" alt="Avatar">
```

## Best Practices

1. **Prefer convenience methods (fluent shortcuts) for inline usage** - Most concise and readable in Blade and simple cases
2. **Use helper methods with enums for configuration** - When storing values or working with config files for type safety
3. **Use direct properties sparingly** - Mainly for dynamic property assignment or when readability benefits
4. **Mix approaches freely** - Choose what's clearest for each situation
5. **Import enums at the top** - Use `use` statements for cleaner code

```php
// Good: Import once at the top
use Gravatar\Enum\{Rating, Extension, DefaultImage};

class UserController
{
    public function avatar($email)
    {
        // Option 1: Convenience methods (recommended for inline)
        return gravatar($email)
            ->extensionWebp()
            ->ratingPg();

        // Option 2: Helper methods with enums (good for config-driven)
        return gravatar($email)
            ->extension(Extension::WEBP)
            ->maxRating(Rating::PG);
    }
}
```

## Next Steps

- [Configure settings](configuration.md) - Set up global configuration
- [Define presets](presets.md) - Combine settings into reusable presets
- [Add Eloquent casts](casts.md) - Seamlessly integrate with your models
