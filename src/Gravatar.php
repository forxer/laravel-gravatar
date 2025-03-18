<?php

declare(strict_types=1);

namespace LaravelGravatar;

class Gravatar
{
    public function __construct(
        private readonly array $config,
    ) {}

    public static function create()
    {
        return app()->make('gravatar');
    }

    /**
     * Return the Gravatar image based on the provided email address.
     */
    public function image(?string $email = null, ?string $presetName = null): Image
    {
        return new Image($this->config, $email, $presetName);
    }

    /**
     * Alias for the "image" method.
     */
    public function avatar(?string $email = null, ?string $presetName = null): Image
    {
        return $this->image($email, $presetName);
    }

    /**
     * Return the Gravatar profile URL based on the provided email address.
     */
    public function profile(?string $email = null, ?string $format = null): Profile
    {
        return (new Profile($email))
            ->setFormat($format);
    }
}
