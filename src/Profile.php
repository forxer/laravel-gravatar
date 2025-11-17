<?php

declare(strict_types=1);

namespace LaravelGravatar;

use Gravatar\Profile as GravatarProfile;

/**
 * Laravel-specific Gravatar profile class.
 *
 * Extends the base Gravatar profile class from forxer/gravatar package
 * to provide Laravel-specific functionality and integration.
 *
 * Supports format validation using ProfileFormat enum from parent library.
 *
 * @see https://docs.gravatar.com/api/profiles/
 * @see \Gravatar\Enum\ProfileFormat
 */
class Profile extends GravatarProfile {}
