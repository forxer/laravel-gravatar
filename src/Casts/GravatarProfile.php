<?php

namespace LaravelGravatar\Casts;

use Gravatar\Image;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class GravatarProfile implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Image
     * @throws BindingResolutionException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return app()->make('gravatar')->profile($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param mixed|null $value
     * @param array $attributes
     * @return mixed
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return $value;
    }
}
