<?php

declare(strict_types=1);

namespace LaravelGravatar;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/gravatar.php', 'gravatar');

        $this->app->singleton('gravatar', fn ($app): Gravatar => new Gravatar($app['config']['gravatar']));
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/gravatar.php' => $this->app->configPath('gravatar.php'),
            ], 'gravatar-config');
        }
    }
}
