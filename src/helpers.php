<?php

declare(strict_types=1);

use Illuminate\Container\Container;
use LaravelGravatar\Image;
use LaravelGravatar\Profile;

if (! function_exists('gravatar')) {
    /**
     * Return a new Gravatar Image instance.
     */
    function gravatar(?string $email = null, ?string $presetName = null): Image
    {
        return Container::getInstance()->make('gravatar')->image($email, $presetName);
    }
}

if (! function_exists('gravatar_profile')) {
    /**
     * Return a new Gravatar Profile instance.
     */
    function gravatar_profile(?string $email = null, ?string $format = null): Profile
    {
        return Container::getInstance()->make('gravatar')->profile($email, $format);
    }
}
