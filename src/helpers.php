<?php

use Gravatar\Image;
use LaravelGravatar\Gravatar;

if (! function_exists('gravatar')) {
    /**
     * Return a gravatar instance.
     *
     * @param string|null $email
     * @param string|null $presetName
     * @return Gravatar|Image
     */
    function gravatar(?string $email = null, ?string $presetName = null): Gravatar|Image
    {
        if ($email === null) {
            return app()->make('gravatar');
        }

        return app()->make('gravatar')->image($email, $presetName);
    }
}
