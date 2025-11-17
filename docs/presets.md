Presets
=======

Presets are named configurations that allow you to define reusable Gravatar settings throughout your application. This feature is **Laravel-specific** and not available in the parent `forxer/gravatar` library.

## Overview

Presets provide:
- **Reusability**: Define settings once, use everywhere
- **Consistency**: Ensure all avatars in a context share the same settings
- **Type Safety**: Automatic validation using the `PresetKey` enum
- **Convenience**: Simple to use with helpers, facades, and Eloquent casts

## Configuration

### Publishing Configuration

First, publish the configuration file:

```bash
php artisan vendor:publish --tag="gravatar-config"
```

This creates `config/gravatar.php` in your application.

### Configuration Structure

```php
<?php

return [
    'default_preset' => null,

    'presets' => [
        // Your presets here
    ],
];
```

### Default Preset

You can specify a default preset to be applied to all Gravatars unless overridden:

```php
'default_preset' => 'medium',
```

Set to `null` to disable the default preset.

## Defining Presets

Presets are defined in the `presets` array of your configuration file:

```php
'presets' => [
    'small' => [
        'size' => 40,
        'default_image' => 'mp',
        'extension' => 'jpg',
    ],

    'medium' => [
        'size' => 120,
        'default_image' => 'mp',
        'extension' => 'jpg',
    ],

    'large' => [
        'size' => 360,
        'default_image' => 'robohash',
        'max_rating' => 'pg',
        'extension' => 'webp',
    ],

    'with_initials' => [
        'size' => 100,
        'default_image' => 'initials',
        'initials_name' => 'User Name', // Can be overridden
        'extension' => 'webp',
    ],
],
```

## Available Preset Keys

Laravel Gravatar provides a `PresetKey` enum that defines all valid keys for preset configurations.

### PresetKey Enum

```php
use LaravelGravatar\Enum\PresetKey;

PresetKey::SIZE             // 'size'
PresetKey::DEFAULT_IMAGE    // 'default_image'
PresetKey::MAX_RATING       // 'max_rating'
PresetKey::EXTENSION        // 'extension'
PresetKey::FORCE_DEFAULT    // 'force_default'
PresetKey::INITIALS         // 'initials'
PresetKey::INITIALS_NAME    // 'initials_name'
```

### Key Descriptions

| Key | Type | Description | Valid Values |
|-----|------|-------------|--------------|
| `size` | int | Avatar size in pixels | 1-2048 |
| `default_image` | string | Default image type or URL | See [Default Images](#default-image-values) |
| `max_rating` | string | Maximum allowed rating | `g`, `pg`, `r`, `x` |
| `extension` | string | File extension | `jpg`, `jpeg`, `png`, `gif`, `webp` |
| `force_default` | bool | Force default image | `true`, `false` |
| `initials` | string | Explicit initials | e.g., `'JD'` |
| `initials_name` | string | Full name for initials | e.g., `'John Doe'` |

### Default Image Values

Valid values for the `default_image` key:

- `'initials'` - Generated initials
- `'color'` - Colored background
- `'404'` - Return 404 if not found
- `'mp'` - Mystery Person (default Gravatar logo)
- `'identicon'` - Geometric pattern
- `'monsterid'` - Monster avatar
- `'wavatar'` - Generated face
- `'retro'` - 8-bit arcade style
- `'robohash'` - Robot avatar
- `'blank'` - Transparent PNG
- Any valid URL - Custom default image

## Using Presets

### 1. With Helper Function

```php
// Apply preset in second argument
$avatar = gravatar('user@example.com', 'small');

// Apply preset with method
$avatar = gravatar('user@example.com')->preset('medium');

// Get current preset name
$presetName = $avatar->preset(); // Returns 'medium' or null
```

### 2. With Facade

```php
use LaravelGravatar\Facades\Gravatar;

$avatar = Gravatar::image('user@example.com', 'large');
```

### 3. With Eloquent Casts

Specify a preset when casting model attributes:

```php
use LaravelGravatar\Casts\GravatarImage;

class User extends Model
{
    protected $casts = [
        'avatar' => GravatarImage::class.':small',
    ];
}
```

Usage in Blade:

```blade
<img src="{{ $user->avatar }}" alt="{{ $user->name }}">
```

### 4. In Blade Templates

```blade
<img src="{{ gravatar($user->email, 'small') }}" alt="Avatar">

{{-- Override preset values --}}
<img src="{{ gravatar($user->email, 'small')->size(60) }}" alt="Avatar">
```

## Preset Inheritance and Overriding

Presets are applied **before** any other settings, allowing you to override preset values:

```php
$avatar = gravatar('user@example.com', 'small')
    ->size(60)           // Overrides preset size (40 → 60)
    ->extensionWebp();   // Overrides preset extension (jpg → webp)

echo $avatar->size;      // 60
echo $avatar->extension; // 'webp'
```

**Order of application:**
1. Default preset (if configured)
2. Explicitly specified preset
3. Individual method calls or property assignments

## Preset Validation

Laravel Gravatar **automatically validates** all preset values using enums for type safety.

### Validated Keys

The following keys are validated at runtime:

- **`extension`** - Validated against `Gravatar\Enum\Extension`
- **`max_rating`** - Validated against `Gravatar\Enum\Rating`
- **`default_image`** - Validated against `Gravatar\Enum\DefaultImage` or URL

### Key Validation

All preset **keys** are validated against the `PresetKey` enum:

```php
// ✅ Valid preset configuration
'presets' => [
    'valid' => [
        'size' => 120,                 // ✅ Valid key
        'extension' => 'webp',         // ✅ Valid key and value
        'max_rating' => 'pg',          // ✅ Valid key and value
        'default_image' => 'robohash', // ✅ Valid key and value
    ],
],

// ❌ Invalid preset configuration
'presets' => [
    'invalid' => [
        'invalid_key' => 'value',      // ❌ Not in PresetKey enum
    ],
],
```

### Value Validation

Enum-backed values are validated automatically:

```php
// ✅ Valid values
'presets' => [
    'validated' => [
        'extension' => 'webp',        // ✅ Valid
        'max_rating' => 'pg',         // ✅ Valid
        'default_image' => 'robohash', // ✅ Valid
    ],

    'custom_url' => [
        'default_image' => 'https://example.com/avatar.png', // ✅ Valid (URL)
    ],
],

// ❌ Invalid values
'presets' => [
    'invalid_extension' => [
        'extension' => 'bmp',  // ❌ Invalid
    ],

    'invalid_rating' => [
        'max_rating' => 'nc17',  // ❌ Invalid
    ],
],
```

### Error Messages

When validation fails, you'll receive detailed error messages:

**Invalid key:**
```
InvalidArgumentException: Gravatar image could not find method to use "invalid_key" key
Allowed preset keys are: "size", "default_image", "max_rating", "extension", "force_default", "initials", "initials_name".
```

**Invalid extension:**
```
InvalidArgumentException: Invalid extension "bmp". Valid values: jpg, jpeg, png, gif, webp
```

**Invalid rating:**
```
InvalidArgumentException: Invalid rating "nc17". Valid values: g, pg, r, x
```

**Invalid default image:**
```
InvalidArgumentException: Invalid default image "invalid". Valid values: initials, color, 404, mp, identicon, monsterid, wavatar, retro, robohash, blank or a valid URL
```

## PresetKey Enum Helper Methods

The `PresetKey` enum provides utility methods:

```php
use LaravelGravatar\Enum\PresetKey;

// Get all valid preset keys as array
$validKeys = PresetKey::values();
// Returns: ['size', 'default_image', 'max_rating', 'extension', 'force_default', 'initials', 'initials_name']

// Check if a key is valid
if (PresetKey::isValid('size')) {
    // Key is valid
}

if (!PresetKey::isValid('invalid_key')) {
    // Key is invalid
}
```

### Benefits

1. **Type Safety**: Runtime validation prevents configuration errors
2. **Auto-completion**: IDE support for available keys
3. **Documentation**: Self-documenting code
4. **Error Prevention**: Catches typos and invalid keys/values early
5. **Consistency**: Single source of truth for valid preset configurations

## Example Configuration

Here's a complete example configuration file:

```php
<?php

return [
    'default_preset' => 'default',

    'presets' => [
        'default' => [
            'size' => 80,
            'default_image' => 'mp',
            'max_rating' => 'g',
            'extension' => 'webp',
        ],

        'thumbnail' => [
            'size' => 40,
            'extension' => 'jpg',
        ],

        'profile' => [
            'size' => 200,
            'default_image' => 'identicon',
            'max_rating' => 'pg',
            'extension' => 'webp',
        ],

        'admin' => [
            'size' => 120,
            'default_image' => 'robohash',
            'extension' => 'png',
        ],

        'with_initials' => [
            'size' => 100,
            'default_image' => 'initials',
            'initials_name' => 'User Name',
            'extension' => 'webp',
        ],

        'high_quality' => [
            'size' => 512,
            'extension' => 'webp',
            'max_rating' => 'pg',
            'default_image' => 'robohash',
        ],
    ],
];
```

## Practical Examples

### User List with Thumbnails

```php
// Controller
public function index()
{
    $users = User::all();
    return view('users.index', compact('users'));
}
```

```blade
{{-- View --}}
@foreach ($users as $user)
    <div class="user-item">
        <img src="{{ gravatar($user->email, 'thumbnail') }}" alt="{{ $user->name }}">
        <span>{{ $user->name }}</span>
    </div>
@endforeach
```

### Different Sizes in Profile

```blade
{{-- Profile header --}}
<img src="{{ gravatar($user->email, 'large') }}" alt="Profile Picture">

{{-- Sidebar --}}
<img src="{{ gravatar($user->email, 'medium') }}" alt="Avatar">

{{-- Comments --}}
<img src="{{ gravatar($user->email, 'small') }}" alt="Avatar">
```

### API Resources

```php
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => [
                'small' => gravatar($this->email, 'thumbnail')->url(),
                'medium' => gravatar($this->email, 'medium')->url(),
                'large' => gravatar($this->email, 'large')->url(),
            ],
        ];
    }
}
```

## Comparison with Parent Library

The preset system is **Laravel-specific** and extends the functionality of the parent `forxer/gravatar` library:

### Laravel Gravatar (this package)
- ✅ Preset configurations
- ✅ Configuration file integration
- ✅ `PresetKey` enum for validation
- ✅ Automatic runtime validation
- ✅ Default preset support
- ✅ Integration with helpers and Eloquent casts

### forxer/gravatar (parent library)
- ❌ No preset system
- ✅ Core enums (`Extension`, `Rating`, `DefaultImage`)
- ✅ Method chaining
- ✅ Property hooks

The Laravel package uses the parent library's enums for **validating preset values**, while adding the `PresetKey` enum for **validating preset keys**.

## Next Steps

- [Configuration](configuration.md) - Other configuration options
- [Enums](enums.md) - Use type-safe enums and fluent methods
- [Parameters](parameters.md) - All available Gravatar parameters
- [Casts](casts.md) - Eloquent model integration
