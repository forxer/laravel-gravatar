<?php

declare(strict_types=1);

namespace LaravelGravatar\Casts;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use LaravelGravatar\Profile;

/**
 * Eloquent cast for Gravatar profiles.
 *
 * Automatically converts an email address attribute to a Gravatar Profile instance.
 */
class GravatarProfile implements CastsAttributes
{
    /**
     * Cast the given email address to a Gravatar Profile instance.
     *
     * @param  Model  $model  The model instance
     * @param  string  $key  The attribute key
     * @param  mixed  $value  The email address value
     * @param  array<string, mixed>  $attributes  All model attributes
     * @return Profile The configured Gravatar profile instance
     *
     * @throws BindingResolutionException When the service container cannot resolve the binding
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Profile
    {
        return app('gravatar')->profile($value);
    }

    /**
     * Prepare the value for storage (returns the value unchanged).
     *
     * @param  Model  $model  The model instance
     * @param  string  $key  The attribute key
     * @param  mixed  $value  The value to store
     * @param  array<string, mixed>  $attributes  All model attributes
     * @return mixed The value to be stored in the database
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
