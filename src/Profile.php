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
 * Uses the Gravatar REST API v3 which returns JSON only.
 *
 * @see https://docs.gravatar.com/api/profiles/
 */
class Profile extends GravatarProfile {}
