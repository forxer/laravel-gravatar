<?php

declare(strict_types=1);

use LaravelGravatar\Image;
use LaravelGravatar\Profile;

if (! function_exists('gravatar')) {
    /**
     * Return a new Gravatar Image instance.
     *
     * @param  string|null  $email  The email address to generate the Gravatar for
     * @param  string|null  $presetName  Optional preset name to apply default settings
     * @return Image The configured Gravatar image instance
     */
    function gravatar(?string $email = null, ?string $presetName = null): Image
    {
        return app('gravatar')->image($email, $presetName);
    }
}

if (! function_exists('gravatar_profile')) {
    /**
     * Return a new Gravatar Profile instance.
     *
     * @param  string|null  $email  The email address to generate the profile for
     * @param  string|null  $format  Optional format (json, xml, php, vcf, qr)
     * @return Profile The configured Gravatar profile instance
     */
    function gravatar_profile(?string $email = null, ?string $format = null): Profile
    {
        return app('gravatar')->profile($email, $format);
    }
}
