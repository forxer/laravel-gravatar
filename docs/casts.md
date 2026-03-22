Eloquent Casts
==============

Laravel Gravatar provides Eloquent casts to seamlessly integrate Gravatar functionality into your models.

## Why Use Casts?

Casts allow you to:
- **Automatically convert** database values to Gravatar instances
- **Work with Gravatars** as if they were native model properties
- **Reduce boilerplate** - No need to manually create instances
- **Clean controllers** - Access Gravatars directly from your models

## Available Casts

### GravatarImage

Casts a model attribute to a `LaravelGravatar\Image` instance.

### GravatarProfile

Casts a model attribute to a `LaravelGravatar\Profile` instance.

## Basic Usage

### Setting Up the Cast

In your model, add the cast to the `$casts` array:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelGravatar\Casts\GravatarImage;

class User extends Model
{
    protected $casts = [
        'email' => GravatarImage::class,
    ];
}
```

Now the `email` attribute will automatically be cast to a Gravatar Image instance.

### Using in Controllers

```php
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        // $user->email is now a LaravelGravatar\Image instance
        $avatar = $user->email->size(120)->extensionWebp();

        return view('users.show', [
            'user' => $user,
            'avatar' => $avatar,
        ]);
    }
}
```

### Using in Blade

```blade
{{-- Access directly in views --}}
<img src="{{ $user->email }}" alt="Avatar">

{{-- Chain methods --}}
<img src="{{ $user->email->size(80)->defaultImageRobohash() }}" alt="Avatar">

{{-- Apply preset --}}
<img src="{{ $user->email->preset('small') }}" alt="Avatar">
```

## Using with Presets

You can specify a preset to be automatically applied to the cast:

```php
use LaravelGravatar\Casts\GravatarImage;

class User extends Model
{
    protected $casts = [
        'email' => GravatarImage::class.':small',
        // or
        'avatar_email' => GravatarImage::class.':medium',
    ];
}
```

The preset name comes after a colon (`:`) following the class name.

## Working with Different Columns

You don't have to use the `email` column. Any column containing an email address can be cast:

```php
class Post extends Model
{
    protected $casts = [
        'author_email' => GravatarImage::class,
        'commenter_email' => GravatarImage::class.':small',
    ];
}
```

Usage:

```blade
<img src="{{ $post->author_email->size(100) }}" alt="Author">
<img src="{{ $post->commenter_email }}" alt="Commenter">
```

## Profile Casts

Cast to Gravatar profiles for accessing user profile data:

```php
use LaravelGravatar\Casts\GravatarProfile;

class User extends Model
{
    protected $casts = [
        'email' => GravatarProfile::class,
    ];
}
```

Usage:

```php
// Get profile URL
$profileUrl = $user->email->url();

// Fetch profile data
$data = $user->email->getData();
```

In Blade:

```blade
<a href="{{ $user->email }}">View Gravatar Profile</a>
```

## Multiple Casts on Same Model

You can have multiple casts for different purposes:

```php
use LaravelGravatar\Casts\{GravatarImage, GravatarProfile};

class User extends Model
{
    protected $casts = [
        'avatar' => GravatarImage::class.':small',
        'profile_link' => GravatarProfile::class,
    ];

    // Both use the same email
    protected function avatar(): Attribute
    {
        return Attribute::get(fn () => $this->email);
    }

    protected function profileLink(): Attribute
    {
        return Attribute::get(fn () => $this->email);
    }
}
```

## Modifying Cast Instances

Cast instances are independent - modifying one doesn't affect the original value:

```php
$user = User::find(1);

// Create a large avatar
$largeAvatar = $user->email->size(200);

// Original email attribute unchanged
echo $user->email->size(); // Still uses preset or default size

// Each access creates a new instance
$avatar1 = $user->email->size(100);
$avatar2 = $user->email->size(200);
// $avatar1 and $avatar2 are independent
```

## Practical Examples

### User Profile Page

```php
class User extends Model
{
    protected $casts = [
        'email' => GravatarImage::class.':medium',
    ];
}
```

```blade
{{-- resources/views/users/show.blade.php --}}
<div class="user-profile">
    <img src="{{ $user->email }}" alt="{{ $user->name }}" class="avatar">
    <h1>{{ $user->name }}</h1>
    <a href="{{ gravatar_profile($user->email->email) }}">View Gravatar Profile</a>
</div>
```

### Comments List

```php
class Comment extends Model
{
    protected $casts = [
        'commenter_email' => GravatarImage::class.':small',
    ];
}
```

```blade
{{-- resources/views/comments/list.blade.php --}}
@foreach($comments as $comment)
    <div class="comment">
        <img src="{{ $comment->commenter_email->extensionWebp() }}" alt="Commenter">
        <p>{{ $comment->body }}</p>
    </div>
@endforeach
```

### Admin Dashboard

```php
class Admin extends Model
{
    protected $casts = [
        'email' => GravatarImage::class.':admin',
    ];
}
```

Where `'admin'` is a preset defined in `config/gravatar.php` (see [Presets](presets.md)):

```php
'presets' => [
    'admin' => [
        'size' => 120,
        'default_image' => 'robohash',
        'extension' => 'png',
    ],
],
```

## Accessing the Email String

When using a cast, you can still access the original email string:

```php
// If you need the email string
$emailString = $user->email->email;

// Or use getRawOriginal()
$emailString = $user->getRawOriginal('email');
```

## Best Practices

1. **Use presets with casts** - Define common sizes/styles once
2. **Keep column names semantic** - `author_email`, `commenter_email`, etc.
3. **Use consistent presets** - `small`, `medium`, `large` across your app
4. **Cache rendered HTML** - Gravatar URLs don't change, cache the rendered output

## Next Steps

- [Explore advanced features](advanced.md) - Base64 conversion, copying instances, and more
