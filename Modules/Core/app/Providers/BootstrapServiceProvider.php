<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\LocalPluginRepositoryContract;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app[LocalPluginRepositoryContract::class]->register();
    }

    /**
     * Bootstrap the application events.
     */

    public function boot(): void
    {
        $this->app[LocalPluginRepositoryContract::class]->boot();
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}