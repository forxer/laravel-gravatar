<?php

declare(strict_types=1);

use Gravatar\Image;
use Illuminate\Container\Container;
use LaravelGravatar\Gravatar;

if (! function_exists('gravatar')) {
    function gravatar(?string $email = null, ?string $presetName = null): Gravatar|Image
    {
        if ($email === null) {
            return Container::getInstance()->make('gravatar');
        }

        return Container::getInstance()->make('gravatar')->image($email, $presetName);
    }
}
