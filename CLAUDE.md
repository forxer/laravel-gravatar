# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

`forxer/laravel-gravatar` is a Laravel package providing Gravatar integration. It wraps the framework-agnostic `forxer/gravatar` (v7.0) library, adding Laravel-specific features: service provider, facade, helpers, Eloquent casts, and preset configurations.

**Requirements:** PHP 8.4+, Laravel 12+

## Development Commands

```bash
# Tests
vendor/bin/pest

# Lint (code style)
vendor/bin/pint

# Lint dry-run (check only)
vendor/bin/pint --test

# Rector (automated refactoring)
vendor/bin/rector process

# Rector dry-run
vendor/bin/rector process --dry-run
```

Tests use **Pest** with **Orchestra Testbench** for Laravel integration. 90 tests covering presets, validation, casts, facade, helpers, and service provider.

## Architecture

### Inheritance from parent library

`LaravelGravatar\Image` extends `Gravatar\Image` and `LaravelGravatar\Profile` extends `Gravatar\Profile` from the `forxer/gravatar` parent package. The parent library provides core Gravatar URL building, PHP 8.4 property hooks, type-safe enums (`Rating`, `Extension`, `DefaultImage`), and fluent shorthand methods.

### Key classes

- **`Gravatar`** — Main service (`readonly class`), registered as `'gravatar'` singleton. Factory for `Image` and `Profile` instances.
- **`Image`** — Extends parent with preset support (resolved from `config/gravatar.php`), base64 conversion via Laravel HTTP client, and enum-based preset validation.
- **`Profile`** — Extends parent with `getData()` method using Laravel HTTP client to fetch profile data from API v3.
- **`ServiceProvider`** — Registers singleton, merges config, publishes config file under tag `gravatar-config`.
- **`Facades\Gravatar`** — Standard Laravel facade for the `'gravatar'` service.
- **`Casts\GravatarImage` / `Casts\GravatarProfile`** — Eloquent casts that convert email attributes to Gravatar instances.
- **`Enum\PresetKey`** — Validates allowed keys in preset configurations (`size`, `default_image`, `max_rating`, `extension`, `force_default`, `initials`, `initials_name`).
- **`helpers.php`** — Global `gravatar()` and `gravatar_profile()` helper functions (auto-loaded via composer).

### Preset system

Presets are defined in `config/gravatar.php` under the `presets` key. When applied, `Image::applyPreset()` validates keys against `PresetKey` enum (via `tryFrom()`) and values against parent library enums (`Extension`, `Rating`, `DefaultImage`), then calls the corresponding methods via `Str::camel()` conversion.

## Code Style

- **Pint** with `laravel` preset, plus custom rules in `pint.json` (notably `blank_line_before_statement` for many statement types and `native_function_invocation` with `@compiler_optimized`).
- **Rector** configured for PHP 8.4, Laravel best practices, dead code removal, and code quality sets. Paths scoped to `src/` only.
- All classes use `declare(strict_types=1)`.
- Native functions are prefixed with backslash (`\sprintf()`, `\is_string()`, etc.) per the pint `native_function_invocation` rule.
