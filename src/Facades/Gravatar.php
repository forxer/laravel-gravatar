<?php

namespace LaravelGravatar\Facades;

use Illuminate\Support\Facades\Facade;

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
