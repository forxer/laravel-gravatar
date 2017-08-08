<?php

if (!function_exists('gravatar')) {
    /**
     * Return a gravatar instance.
     *
     * @return \forxer\LaravelGravatar\Gravatar
     */
    function gravatar($email = null, $presetName = null)
    {
        if (null === $email) {
            return app()->make('gravatar');
        }

        return app()->make('gravatar')->image($email, $presetName);
    }
}
