<?php

namespace forxer\LaravelGravatar;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/gravatar.php' => $this->app->configPath() . '/' . 'gravatar.php',
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/gravatar.php', 'gravatar');

        $this->app->singleton('gravatar', function ($app) {
            return new Gravatar($app);
        });
    }
}
