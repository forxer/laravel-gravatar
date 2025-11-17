Parameters
==========

Gravatar images support several optional parameters to customize their appearance. All parameters can be set using helper methods, direct property assignment, or fluent shorthand methods.

## Working with Parameters

All helper methods work in two modes:

- **Setter mode**: When called with an argument, sets the value and returns `$this` for chaining
- **Getter mode**: When called without arguments, returns the current value

```php
$avatar = gravatar('user@example.com');
$avatar->size(120);              // Setter: sets size to 120
$currentSize = $avatar->size();  // Getter: returns 120
```

You can also use direct property assignment (PHP 8.4 property hooks with validation):

```php
$avatar->size = 120;             // Direct assignment
echo $avatar->size;              // Direct reading
```

## Available Parameters

### Size

Controls the avatar image size in pixels.

**Range**: 1 to 2048 pixels
**Default**: 80

**1. Using helper method:**

```php
$avatar = gravatar('user@example.com')->size(120);

// Getter mode
$currentSize = $avatar->size(); // Returns 120
```

**2. Using direct property:**

```php
$avatar = gravatar('user@example.com');
$avatar->size = 200;

// Reading the property
echo $avatar->size; // 200
```

**Important**: Many users have lower resolution images, so requesting larger sizes may result in pixelation.

### Default Image

Specifies what image to display when the email has no matching Gravatar or exceeds the rating limit.

**Default**: Gravatar's default image (mystery person)

#### Built-in Options

- `'initials'` - Uses profile name as initials with generated colors
- `'color'` - A generated solid color
- `'404'` - Returns HTTP 404 if no gravatar exists
- `'mp'` - Mystery person (simple silhouette)
- `'identicon'` - Geometric pattern based on email hash
- `'monsterid'` - Generated monster with different colors
- `'wavatar'` - Generated face with differing features
- `'retro'` - 8-bit arcade-style pixelated faces
- `'robohash'` - Generated robot
- `'blank'` - Transparent PNG image

**1. Using helper method:**

```php
$avatar = gravatar('user@example.com')->defaultImage('robohash');

// With custom URL
$avatar = gravatar('user@example.com')
    ->defaultImage('https://example.com/default-avatar.png');

// Getter mode
$current = $avatar->defaultImage(); // Returns current default image
```

**2. Using convenience methods (fluent shorthand):**

```php
$avatar = gravatar('user@example.com')->defaultImageRobohash();
$avatar = gravatar('user@example.com')->defaultImageIdenticon();
$avatar = gravatar('user@example.com')->defaultImageMp();
$avatar = gravatar('user@example.com')->defaultImageRetro();
$avatar = gravatar('user@example.com')->defaultImageWavatar();
$avatar = gravatar('user@example.com')->defaultImageMonsterid();
$avatar = gravatar('user@example.com')->defaultImageBlank();
$avatar = gravatar('user@example.com')->defaultImageNotFound(); // 404
```

**3. Using direct property:**

```php
$avatar = gravatar('user@example.com');
$avatar->defaultImage = 'identicon';

// Reading the property
echo $avatar->defaultImage; // 'identicon'
```

#### Initials Default Image

When using `'initials'` as the default image, you can customize which initials are displayed:

**1. Using helper methods:**

```php
$avatar = gravatar('user@example.com')
    ->defaultImage('initials')
    ->initials('JD');

$avatar = gravatar('user@example.com')
    ->defaultImage('initials')
    ->initialsName('John Doe');
```

**2. Using convenience methods:**

```php
// Automatically sets default to 'initials'
$avatar = gravatar('user@example.com')->withInitials('JD');
$avatar = gravatar('user@example.com')->withInitialsName('John Doe');
```

**3. Using direct properties:**

```php
$avatar = gravatar('user@example.com');
$avatar->defaultImage = 'initials';
$avatar->initials = 'JD';
// or
$avatar->initialsName = 'John Doe';
```

### Maximum Rating

Gravatar allows users to self-rate their images. You can request images up to a certain rating.

**Options**:
- `'g'` - Suitable for all audiences (default)
- `'pg'` - May contain rude gestures, provocative dress, mild swearing, or mild violence
- `'r'` - May contain harsh profanity, intense violence, nudity, or hard drug use
- `'x'` - May contain hardcore sexual imagery or extremely disturbing violence

**1. Using helper method:**

```php
$avatar = gravatar('user@example.com')->maxRating('pg');

// Getter mode
$current = $avatar->maxRating(); // Returns current rating
```

**2. Using convenience methods (fluent shorthand):**

```php
$avatar = gravatar('user@example.com')->ratingG();
$avatar = gravatar('user@example.com')->ratingPg();
$avatar = gravatar('user@example.com')->ratingR();
$avatar = gravatar('user@example.com')->ratingX();
```

**3. Using direct property:**

```php
$avatar = gravatar('user@example.com');
$avatar->maxRating = 'r';

// Reading the property
echo $avatar->maxRating; // 'r'
```

### File Extension

Add a file extension to the URL. Some systems require this.

**Options**: `'jpg'`, `'jpeg'`, `'png'`, `'gif'`, `'webp'`

**1. Using helper method:**

```php
$avatar = gravatar('user@example.com')->extension('webp');

// Getter mode
$current = $avatar->extension(); // Returns current extension
```

**2. Using convenience methods (fluent shorthand):**

```php
$avatar = gravatar('user@example.com')->extensionJpg();
$avatar = gravatar('user@example.com')->extensionJpeg();
$avatar = gravatar('user@example.com')->extensionPng();
$avatar = gravatar('user@example.com')->extensionGif();
$avatar = gravatar('user@example.com')->extensionWebp();
```

**3. Using direct property:**

```php
$avatar = gravatar('user@example.com');
$avatar->extension = 'png';

// Reading the property
echo $avatar->extension; // 'png'
```

### Force Default

Force the default image to always be loaded, even if the email has a Gravatar.

**1. Using helper method:**

```php
$avatar = gravatar('user@example.com')->forceDefault(true);

// Getter mode
$isForced = $avatar->forceDefault(); // Returns true/false
```

**2. Using convenience methods:**

```php
$avatar = gravatar('user@example.com')->enableForceDefault();
$avatar = gravatar('user@example.com')->disableForceDefault();

// Check if forcing default
if ($avatar->forcingDefault()) {
    // Default is forced
}
```

**3. Using direct property:**

```php
$avatar = gravatar('user@example.com');
$avatar->forceDefault = true;

// Reading the property
echo $avatar->forceDefault ? 'forced' : 'not forced';
```

## Combining Parameters

You can chain multiple parameters together:

```php
$avatar = gravatar('user@example.com')
    ->size(120)
    ->defaultImage('robohash')
    ->maxRating('pg')
    ->extension('webp');
```

Or use a mix of different approaches:

```php
$avatar = gravatar('user@example.com');
$avatar->size = 120;                    // Direct property
$avatar->defaultImage('robohash');      // Helper method
$avatar->extensionWebp();               // Fluent shorthand
```

## In Blade Templates

```blade
<img src="{{ gravatar($user->email)->size(80)->extensionWebp() }}" alt="Avatar">

<img src="{{ gravatar($user->email)->size(120)->defaultImage('identicon')->maxRating('pg') }}" alt="Avatar">
```

## Profile Format

For Gravatar profiles, you can specify the output format:

**Options**: `'json'`, `'xml'`, `'php'`, `'vcf'`, `'qr'`

**1. Using helper method:**

```php
$profile = gravatar_profile('user@example.com')->format('json');

// Or pass format as second argument
$profile = gravatar_profile('user@example.com', 'json');

// Getter mode
$current = $profile->format(); // Returns current format
```

**2. Using convenience methods (fluent shorthand):**

```php
$profile = gravatar_profile('user@example.com')->formatJson();
$profile = gravatar_profile('user@example.com')->formatXml();
$profile = gravatar_profile('user@example.com')->formatPhp();
$profile = gravatar_profile('user@example.com')->formatVcf();
$profile = gravatar_profile('user@example.com')->formatQr();
```

**3. Using direct property:**

```php
$profile = gravatar_profile('user@example.com');
$profile->format = 'xml';

// Reading the property
echo $profile->format; // 'xml'
```

## Next Steps

- [Use type-safe enums](enums.md) - Type-safe values and fluent shorthand methods
- [Configure presets](presets.md) - Reuse parameter combinations
- [Advanced features](advanced.md) - Copying instances, base64 conversion
