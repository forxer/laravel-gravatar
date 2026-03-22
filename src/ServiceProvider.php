<?php

declare(strict_types=1);

namespace LaravelGravatar;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Laravel Gravatar Service Provider.
 *
 * Registers the Gravatar service and publishes configuration files.
 */
class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * Register the Gravatar service in the container.
     *
     * Merges package configuration and binds the Gravatar singleton.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/gravatar.php', 'gravatar');

        $this->app->singleton('gravatar', fn ($app): Gravatar => new Gravatar($app['config']['gravatar']));

        $this->app->alias('gravatar', Gravatar::class);
    }

    /**
     * Bootstrap the Gravatar service.
     *
     * Publishes configuration file when running in console.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/gravatar.php' => $this->app->configPath('gravatar.php'),
            ], 'gravatar-config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return ['gravatar', Gravatar::class];
    }
}
