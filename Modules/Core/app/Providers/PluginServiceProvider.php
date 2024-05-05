<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\LocalPluginRepositoryContract;
use Modules\Core\Supports\LocalPluginRepository;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(LocalPluginRepositoryContract::class, function ($app) {
            $path = module_path('Core', 'Plugins');
            return new LocalPluginRepository($app , $path);
        });

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