# Laravel Gravatar

- Gravatar integration for Laravel wrapping `forxer/gravatar` v7. Provides helpers, facade, Eloquent casts, and preset configurations.
- Use `gravatar($email)` helper to get an `Image` instance, chain `->size()`, `->extensionWebp()`, `->defaultImageRobohash()`, etc.
- Use `gravatar_profile($email)` helper for Gravatar profiles (API v3, JSON only).
- Presets are defined in `config/gravatar.php` and applied via `gravatar($email, 'small')` or Eloquent casts `GravatarImage::class.':small'`.
- All image parameters support three modes: helper methods (`->size(120)`), fluent shortcuts (`->extensionWebp()`), and direct property assignment (`$image->size = 120`).
- `toBase64()` converts avatars to data URLs with correct Content-Type from the HTTP response.
- IMPORTANT: Activate `gravatar` skill for detailed usage patterns, preset configuration, Eloquent casts, and examples.
