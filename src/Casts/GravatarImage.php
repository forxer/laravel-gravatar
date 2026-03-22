<?php

declare(strict_types=1);

namespace LaravelGravatar\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use LaravelGravatar\Image;

/**
 * Eloquent cast for Gravatar images.
 *
 * Automatically converts an email address attribute to a Gravatar Image instance.
 */
class GravatarImage implements CastsAttributes
{
    /**
     * @param  string|null  $presetName  Optional preset name to apply to all instances
     */
    public function __construct(
        protected readonly ?string $presetName = null,
    ) {}

    /**
     * Cast the given email address to a Gravatar Image instance.
     *
     * @param  Model  $model  The model instance
     * @param  string  $key  The attribute key
     * @param  mixed  $value  The email address value
     * @param  array<string, mixed>  $attributes  All model attributes
     * @return Image The configured Gravatar image instance
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Image
    {
        return app('gravatar')
            ->image($value, $this->presetName);
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
