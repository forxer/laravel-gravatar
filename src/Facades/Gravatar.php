<?php

declare(strict_types=1);

namespace LaravelGravatar\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelGravatar\Image;
use LaravelGravatar\Profile;

/**
 * Gravatar Facade for Laravel.
 *
 * Provides static access to Gravatar image and profile generation methods.
 *
 * @method static Image image(string|null $email = null, string|null $presetName = null) Create a new Gravatar image instance
 * @method static Image avatar(string|null $email = null, string|null $presetName = null) Alias for image() method
 * @method static Profile profile(string|null $email = null) Create a new Gravatar profile instance
 *
 * @see \LaravelGravatar\Gravatar
 */
class Gravatar extends Facade
{
    /**
     * The facade accessor string.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'gravatar';
    }
}
