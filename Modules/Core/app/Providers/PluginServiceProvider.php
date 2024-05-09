<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\ConfigContract;
use Modules\Core\Contracts\LocalPluginRepositoryContract;
use Modules\Core\Contracts\PluginActivatorInterface;
use Modules\Core\Exceptions\InvalidActivatorClass;
use Modules\Core\Supports\Config;
use Modules\Core\Supports\LocalPluginRepository;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(LocalPluginRepositoryContract::class, function ($app) {
            $path = base_path("extends/Plugins");
            return new LocalPluginRepository($app, $path);
        });

        $this->app->singleton(
            ConfigContract::class,
            function ($app) {
                return new Config($app, $app['cache']);
            }
        );

        $this->app->singleton(
            PluginActivatorInterface::class,
            function ($app) {
                $activetorClass = config('core.db_activator');
                if ($activetorClass === null) {
                    throw InvalidActivatorClass::missConfig();
                }
                return new $activetorClass($app, $app[ConfigContract::class]);
            }
        );

        $this->app->alias(LocalPluginRepositoryContract::class, 'plugins');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [LocalPluginRepositoryContract::class, 'plugins'];
    }
}