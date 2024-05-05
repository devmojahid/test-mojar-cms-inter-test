<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\HookContracts;
use Modules\Core\Supports\Hooks\Events;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(HookContracts::class, function ($app) {
            return new Events();
        });
    }

    /**
     * Boot the application events.
     */

    public function boot(): void
    {
        Blade::directive('do_action', function ($expression) {
            return "<?php app('Modules\Core\Contracts\HookContracts')->doAction({$expression}); ?>";
});

Blade::directive('apply_filters', function ($expression) {
return "<?php echo app('Modules\Core\Contracts\HookContracts')->applyFilter({$expression}); ?>";
});
}

/**
* Get the services provided by the provider.
*/
public function provides(): array
{
return [];
}
}