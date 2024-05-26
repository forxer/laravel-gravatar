<?php

declare(strict_types=1);

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
     * @return Image
     *
     * @throws BindingResolutionException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return app()->make('gravatar')->profile($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  mixed|null  $value
     * @return mixed
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return $value;
    }
}
