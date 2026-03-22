<?php

declare(strict_types=1);

namespace LaravelGravatar\Enum;

/**
 * Allowed preset configuration keys.
 *
 * Defines which keys are valid in preset configurations from config/gravatar.php
 */
enum PresetKey: string
{
    case SIZE = 'size';
    case DEFAULT_IMAGE = 'default_image';
    case MAX_RATING = 'max_rating';
    case EXTENSION = 'extension';
    case FORCE_DEFAULT = 'force_default';
    case INITIALS = 'initials';
    case INITIALS_NAME = 'initials_name';

    /**
     * Get all valid preset key values as strings.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Check if a given key is valid.
     *
     * @param  string  $key  The key to validate
     */
    public static function isValid(string $key): bool
    {
        return self::tryFrom($key) !== null;
    }
}
