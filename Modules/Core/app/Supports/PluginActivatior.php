<?php
namespace Modules\Core\Supports;

class PluginActivatior
{

    /**
     * Activate the given plugin.
     *
     * @param  string  $plugin
     * @return void
     */
    // public function activate(string $plugin): void
    // {
    //     $plugin = $this->getPlugin($plugin);

    //     $this->require($plugin->path.'/bootstrap.php');

    //     // $this->registerProviders($plugin);
    // }

    /**
     * Get the plugin instance.
     *
     * @param  string  $plugin
     * @return \Modules\Core\Supports\Plugin
     */
    // protected function getPlugin(string $plugin): Plugin
    // {
    //     $plugin = $this->getPluginInformation($plugin);

    //     return new Plugin($plugin);
    // }

    /**
     * Get the plugin information.
     *
     * @param  string  $plugin
     * @return array
     */
    // protected function getPluginInformation(string $plugin): array
    // {
    //     $path = base_path('plugins/'.$plugin.'/module.json');

    //     if (! file_exists($path)) {
    //         throw new PluginNotFoundException($plugin);
    //     }

    //     return json_decode(file_get_contents($path), true);
    // }

    /**
     * Require the bootstrap file for the plugin.
     *
     * @param  string  $path
     * @return void
     */
    // protected function require(string $path): void
    // {
    //     require $path;
    // }

    /**
     * Register the service providers for the plugin.
     *
     * @param  \Modules\Core\Supports\Plugin  $plugin
     * @return void
     */
    // protected function registerProviders(Plugin $plugin): void
    // {
    //     foreach ($plugin->moduleJson['providers'] as $provider) {
    //         $this->app->register($provider);
    //     }
    // }
}   