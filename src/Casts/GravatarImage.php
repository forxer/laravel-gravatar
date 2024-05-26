<?php

declare(strict_types=1);

namespace LaravelGravatar\Casts;

use Illuminate\Container\Container;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class GravatarImage implements CastsAttributes
{
    public function __construct(
        protected ?string $presetName = null
    ) {
    }

    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return Container::getInstance()->make('gravatar')
            ->image($value)
            ->setPreset($this->presetName);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return $value;
    }
}
