<?php

declare(strict_types=1);

namespace LaravelGravatar;

/**
 * Main Gravatar service class for Laravel.
 *
 * This class provides factory methods to create Gravatar Image and Profile instances
 * with Laravel-specific configuration and preset support.
 */
class Gravatar
{
    /**
     * @param  array<string, mixed>  $config  The Gravatar configuration array
     */
    public function __construct(
        private readonly array $config,
    ) {}

    /**
     * Create a new Gravatar instance from the service container.
     *
     * @return static The Gravatar instance
     */
    public static function create(): static
    {
        return app('gravatar');
    }

    /**
     * Return a new Gravatar image instance for the specified email address.
     *
     * @param  string|null  $email  The email address to generate the Gravatar for
     * @param  string|null  $presetName  Optional preset name to apply default settings
     * @return Image The configured Gravatar image instance
     */
    public function image(?string $email = null, ?string $presetName = null): Image
    {
        return new Image($this->config, $email, $presetName);
    }

    /**
     * Alias for the image() method.
     *
     * @param  string|null  $email  The email address to generate the Gravatar for
     * @param  string|null  $presetName  Optional preset name to apply default settings
     * @return Image The configured Gravatar image instance
     */
    public function avatar(?string $email = null, ?string $presetName = null): Image
    {
        return $this->image($email, $presetName);
    }

    /**
     * Return a new Gravatar profile instance for the specified email address.
     *
     * @param  string|null  $email  The email address to generate the profile for
     * @return Profile The configured Gravatar profile instance
     */
    public function profile(?string $email = null): Profile
    {
        return new Profile($email);
    }
}
