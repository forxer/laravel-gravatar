<?php

namespace LaravelGravatar;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/gravatar.php', 'gravatar');

        $this->app->singleton('gravatar', function ($app) {
            return new Gravatar($app['config']['gravatar']);
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/gravatar.php' => $this->app->configPath('gravatar.php'),
            ], 'gravatar-config');
        }
    }
}
