<?php

declare(strict_types=1);

namespace Tests;

use LaravelGravatar\Facades\Gravatar;
use LaravelGravatar\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Gravatar' => Gravatar::class,
        ];
    }
}
