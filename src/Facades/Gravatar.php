<?php

namespace LaravelGravatar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \LaravelGravatar\Gravatar create()
 * @method static \Gravatar\Image image(?string $email = null, ?string $presetName = null)
 * @method static \Gravatar\Image avatar(?string $email = null, ?string $presetName = null)
 * @method static \Gravatar\Profile profile(?string $email = null, ?string $format = null)
 */
class Gravatar extends Facade
{
    /**
     * The facade accessor string.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gravatar';
    }
}
