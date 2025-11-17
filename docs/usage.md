Usage
=====

Laravel Gravatar provides three main ways to work with Gravatars in your application:

1. **Helper functions** - Quick and convenient for most use cases
2. **Facade** - For static access anywhere in your app
3. **Dependency injection** - For better testability in classes

## Helper Functions

The package provides two helper functions that are the recommended way to use Gravatars in Laravel.

### The `gravatar()` Helper

The `gravatar()` helper returns a `LaravelGravatar\Image` instance for building avatar URLs:

```php
// Simple usage
$avatar = gravatar('user@example.com');
echo $avatar; // Outputs the Gravatar URL

// With parameters
$avatar = gravatar('user@example.com')
    ->size(120)
    ->defaultImage('robohash')
    ->extension('webp');

echo $avatar->url(); // Get URL as string
```

You can also call it without an email and set it later:

```php
$avatar = gravatar();
$avatar->email = 'user@example.com';
$avatar->size(120);
```

With a preset (see [Configuration](configuration.md)):

```php
$avatar = gravatar('user@example.com', 'small');
```

### The `gravatar_profile()` Helper

The `gravatar_profile()` helper returns a `LaravelGravatar\Profile` instance for Gravatar profile URLs:

```php
// HTML profile URL
$profile = gravatar_profile('user@example.com');
echo $profile;

// JSON profile
$profileJson = gravatar_profile('user@example.com', 'json');

// Other formats
$profileXml = gravatar_profile('user@example.com', 'xml');
$profileVcf = gravatar_profile('user@example.com', 'vcf');
$profileQr = gravatar_profile('user@example.com', 'qr');
```

## Facade

The `Gravatar` facade provides static access to all functionality:

```php
use LaravelGravatar\Facades\Gravatar;

// Create an avatar image
$avatar = Gravatar::image('user@example.com')
    ->size(120);

// Alias: avatar() is the same as image()
$avatar = Gravatar::avatar('user@example.com');

// Create a profile
$profile = Gravatar::profile('user@example.com', 'json');

// Access the service instance
$service = Gravatar::create();
```

## Dependency Injection

For better testability, you can inject the Gravatar service into your controllers or other classes:

```php
use App\Models\User;
use LaravelGravatar\Gravatar;

class UserController extends Controller
{
    public function show(User $user, Gravatar $gravatar)
    {
        $avatar = $gravatar->image($user->email)
            ->size(120)
            ->defaultImage('identicon');

        $profile = $gravatar->profile($user->email, 'json');

        return view('users.show', [
            'user' => $user,
            'avatar' => $avatar,
            'profile' => $profile,
        ]);
    }
}
```

## Using in Blade Templates

All Gravatar instances implement `__toString()`, so you can use them directly in Blade:

```blade
{{-- Simple avatar --}}
<img src="{{ gravatar($user->email) }}" alt="Avatar">

{{-- With chaining --}}
<img src="{{ gravatar($user->email)->size(80)->extensionWebp() }}" alt="Avatar">

{{-- Profile link --}}
<a href="{{ gravatar_profile($user->email) }}">View Profile</a>

{{-- Profile JSON --}}
<a href="{{ gravatar_profile($user->email, 'json') }}">Profile Data</a>

{{-- Using facade --}}
<img src="{{ Gravatar::image($user->email)->size(100) }}" alt="Avatar">
```

## Setting the Email Address

There are several ways to provide the email address:

**1. Using helper method:**

```php
// As helper argument
$avatar = gravatar('user@example.com');

// Or via method call
$avatar = gravatar()->email('user@example.com');

// Getter mode
$current = $avatar->email(); // Returns current email
```

**2. Using direct property:**

```php
$avatar = gravatar();
$avatar->email = 'user@example.com';

// Reading the property
echo $avatar->email; // 'user@example.com'
```

Choose the approach that best fits your code style.

## Building the URL

There are two ways to get the Gravatar URL:

```php
$avatar = gravatar('user@example.com')->size(120);

// 1. Using the url() method
$url = $avatar->url();

// 2. Using string conversion (__toString)
$url = (string) $avatar;
echo $avatar; // Also uses __toString
```

## Copying Instances

You can create a copy of an existing Gravatar instance with all its settings:

```php
// Create a base configuration
$base = gravatar()->size(120)->defaultImage('robohash');

// Create copies with different emails
$avatar1 = $base->copy('user1@example.com');
$avatar2 = $base->copy('user2@example.com');

// Create a copy and modify settings
$largeAvatar = $base->copy('user@example.com')->size(200);
```

This is useful when you need to generate multiple avatars with consistent settings.

## Next Steps

- [Configure presets](configuration.md) - Define reusable configurations
- [Learn about parameters](parameters.md) - Customize size, rating, default image, etc.
- [Use enums](enums.md) - Type-safe values and fluent methods
- [Add Eloquent casts](casts.md) - Seamlessly integrate with your models
