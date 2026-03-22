Advanced Features
=================

This guide covers advanced features and techniques for using Laravel Gravatar.

## Copying Instances

You can create a copy of an existing Gravatar instance with all its settings using the `copy()` method.

### Basic Copying

```php
// Create a base configuration
$base = gravatar()->size(120)->defaultImageRobohash()->extensionWebp();

// Create copies with different emails
$avatar1 = $base->copy('user1@example.com');
$avatar2 = $base->copy('user2@example.com');
$avatar3 = $base->copy('user3@example.com');
```

### Copying and Modifying

```php
$base = gravatar('user@example.com')
    ->size(80)
    ->extensionWebp()
    ->ratingPg();

// Copy and change size
$large = $base->copy()->size(200);

// Copy with new email and different settings
$other = $base->copy('other@example.com')->defaultImageIdenticon();
```

### Use Case: Generating Multiple Avatars

```php
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // Define base configuration once
        $avatarConfig = gravatar()
            ->size(64)
            ->extensionWebp()
            ->defaultImageIdenticon()
            ->ratingPg();

        // Generate avatar for each user
        foreach ($users as $user) {
            $user->avatar_url = $avatarConfig->copy($user->email)->url();
        }

        return view('users.index', compact('users'));
    }
}
```

## Base64 Conversion

Convert Gravatar images to base64-encoded data URLs for embedding directly in HTML or storing in databases.

### Basic Usage

```php
$avatar = gravatar('user@example.com')->size(80);
$base64 = $avatar->toBase64();

// Returns: data:image/{content-type};base64,iVBORw0KGgoAAAANS...
```

### With Custom Timeout

```php
// Default timeout is 5 seconds
$base64 = $avatar->toBase64();

// Custom timeout (in seconds)
$base64 = $avatar->toBase64(timeout: 10);
```

### Handling Failures

The method returns `null` if the image cannot be fetched:

```php
$base64 = $avatar->toBase64();

if ($base64 === null) {
    // Failed to fetch image
    // Use fallback or log error
}
```

### Use in Blade

```blade
@php
$base64Avatar = gravatar($user->email)->size(80)->toBase64();
@endphp

@if($base64Avatar)
    <img src="{{ $base64Avatar }}" alt="Avatar">
@else
    <img src="/images/default-avatar.png" alt="Default Avatar">
@endif
```

### Practical Use Cases

#### Email Templates

```php
// Generate avatar for email
$avatar = gravatar($user->email)->size(100);
$base64 = $avatar->toBase64();

Mail::send('emails.welcome', [
    'avatar' => $base64,
    'user' => $user,
], function ($message) use ($user) {
    $message->to($user->email);
});
```

```blade
{{-- emails/welcome.blade.php --}}
<img src="{{ $avatar }}" alt="Your Avatar" style="border-radius: 50%;">
```

#### Offline/PWA Applications

```php
// Cache avatars as base64 for offline use
class CacheUserAvatars extends Command
{
    public function handle()
    {
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                $base64 = gravatar($user->email)->size(80)->toBase64();
                Cache::put("avatar.{$user->id}", $base64, now()->addDays(7));
            }
        });
    }
}
```

### Important Notes

- The `Content-Type` header from the HTTP response is used for the data URL (e.g., `image/jpeg` for `.jpg`, `image/webp` for `.webp`), with a fallback to `image/png`
- Failed fetches are logged automatically for debugging
- Consider caching base64 data as it can be large
- Network timeouts may occur for slow connections

## Working with Profiles

Gravatar profiles use the REST API v3 which returns JSON only.

### Profile URL

```php
$profile = gravatar_profile('user@example.com');
echo $profile; // https://api.gravatar.com/v3/profiles/{sha256_hash}
```

### Fetching Profile Data

The `getData()` method uses Laravel's HTTP client to fetch profile data:

```php
$profile = gravatar_profile('user@example.com');
$data = $profile->getData();

if ($data) {
    $displayName = $data['display_name'] ?? null;
    $avatarUrl = $data['avatar_url'] ?? null;
    $location = $data['location'] ?? null;
}
```

With custom timeout:

```php
$data = $profile->getData(timeout: 10);
```

The method returns `null` on failure and logs a warning automatically.

## Property Hooks (PHP 8.4)

Laravel Gravatar leverages PHP 8.4 property hooks for automatic validation and conversion.

### Direct Property Access

```php
$avatar = gravatar('user@example.com');

// Writing triggers validation
$avatar->size = 120;      // Valid
$avatar->size = 5000;     // Throws InvalidImageSizeException

$avatar->extension = 'webp';     // Valid
$avatar->extension = 'invalid';  // Throws InvalidImageExtensionException
```

### Enum Conversion

```php
use Gravatar\Enum\{Rating, Extension};

$avatar = gravatar('user@example.com');

// Automatic enum to string conversion
$avatar->maxRating = Rating::PG;
echo $avatar->maxRating;  // 'pg'

// Works both ways
$avatar->extension = Extension::WEBP;  // Enum
$avatar->extension = 'jpg';            // String
```

### Reading Properties

```php
$avatar = gravatar('user@example.com')
    ->size(120)
    ->extensionWebp()
    ->ratingPg();

// Read current values
echo $avatar->size;        // 120
echo $avatar->extension;   // 'webp'
echo $avatar->maxRating;   // 'pg'
echo $avatar->email;       // 'user@example.com'
```

### Asymmetric Visibility (PHP 8.4)

Laravel Gravatar uses PHP 8.4's asymmetric visibility feature for the `presetName` property:

```php
$avatar = gravatar('user@example.com', 'medium');

// ✅ Reading is public
echo $avatar->presetName;  // 'medium'

// ❌ Writing is private (will cause error)
// $avatar->presetName = 'other';  // Error: Cannot modify private(set) property
```

**`presetName`** uses `public private(set)` — anyone can read the current preset name, but only the class can modify it internally via `setPreset()`.

**Use case:**

```php
$avatar = gravatar($email, 'large');

// Check which preset is applied
if ($avatar->presetName === 'large') {
    // Preset is applied
}
```

## Customizing with Initials

### Using Initials as Default

**1. Using helper methods:**

```php
$avatar = gravatar('user@example.com')
    ->defaultImage('initials')
    ->initials('AB');

$avatar = gravatar('user@example.com')
    ->defaultImage('initials')
    ->initialsName('John Doe');
```

**2. Using convenience methods:**

```php
// Automatically set default to 'initials' and provide initials
$avatar = gravatar('user@example.com')->withInitials('JD');

// Or from name
$avatar = gravatar('user@example.com')->withInitialsName('John Doe');
```

**3. Using helper methods (direct):**

```php
$avatar = gravatar('user@example.com');
$avatar->defaultImage = 'initials';
$avatar->initials('AB');
// or
$avatar->initialsName('John Doe');
```

### In Models

```php
class User extends Model
{
    public function getAvatarAttribute()
    {
        return gravatar($this->email)
            ->withInitialsName($this->name)
            ->size(120);
    }
}
```

```blade
<img src="{{ $user->avatar }}" alt="{{ $user->name }}">
```

## Advanced Blade Techniques

### Component

```php
// app/View/Components/GravatarAvatar.php
namespace App\View\Components;

use Illuminate\View\Component;

class GravatarAvatar extends Component
{
    public function __construct(
        public string $email,
        public int $size = 80,
        public string $preset = 'default'
    ) {}

    public function render()
    {
        return view('components.gravatar-avatar');
    }
}
```

```blade
{{-- resources/views/components/gravatar-avatar.blade.php --}}
<img
    src="{{ gravatar($email, $preset)->size($size) }}"
    alt="Avatar"
    class="rounded-full"
    width="{{ $size }}"
    height="{{ $size }}"
>
```

Usage:

```blade
<x-gravatar-avatar :email="$user->email" :size="100" />
```

### Custom Directive

```php
// app/Providers/AppServiceProvider.php
use Illuminate\Support\Facades\Blade;

public function boot()
{
    Blade::directive('gravatar', function ($expression) {
        return "<?php echo gravatar($expression); ?>";
    });
}
```

Usage:

```blade
<img src="@gravatar($user->email, 'small')" alt="Avatar">
```

## Testing

### Mocking in Tests

```php
use LaravelGravatar\Facades\Gravatar;
use LaravelGravatar\Image;

public function test_user_has_gravatar()
{
    $mock = Mockery::mock(Image::class);
    $mock->shouldReceive('url')->andReturn('https://gravatar.com/avatar/test');

    Gravatar::shouldReceive('image')
        ->with('test@example.com')
        ->andReturn($mock);

    $response = $this->get('/users/1');
    $response->assertSee('https://gravatar.com/avatar/test');
}
```

## Performance Tips

1. **Cache Gravatar URLs** - They don't change frequently
2. **Use presets** - Reduce repetitive configuration
3. **Lazy load images** - Use `loading="lazy"` attribute
4. **Optimize sizes** - Don't request larger than displayed
5. **Use WebP** - Smaller file sizes with `.extensionWebp()`

```blade
<img
    src="{{ gravatar($user->email, 'small')->extensionWebp() }}"
    loading="lazy"
    alt="Avatar"
>
```

## Further Resources

- [Gravatar Official Documentation](https://gravatar.com/site/implement/) - Official Gravatar API documentation
- [forxer/gravatar Library](https://github.com/forxer/gravatar) - The parent framework-agnostic library
- [GitHub Repository](https://github.com/forxer/laravel-gravatar) - Source code and issue tracker
