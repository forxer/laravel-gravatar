<?php

declare(strict_types=1);

use Gravatar\Image;
use LaravelGravatar\Gravatar;

if (! function_exists('gravatar')) {
    /**
     * Return a gravatar instance.
     */
    function gravatar(?string $email = null, ?string $presetName = null): Gravatar|Image
    {
        if ($email === null) {
            return app()->make('gravatar');
        }

        return app()->make('gravatar')->image($email, $presetName);
    }
}
