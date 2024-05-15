<?php

namespace Modules\Core\Supports\Activators;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Filesystem\Filesystem;
use Modules\Core\Contracts\ConfigContract;
use Modules\Core\Contracts\PluginActivatorInterface;
use Modules\Core\Facades\Config;
use Modules\Core\Supports\Plugin;

class DbActivator implements PluginActivatorInterface
{

    private CacheManager $cache;
    private Filesystem $file;
    private ConfigRepository $config;
    private ConfigContract $configContract;
    private array $moduleStatuses;
    public function __construct($app, ConfigContract $configContract)
    {
        $this->cache = $app['cache'];
        $this->file = $app['files'];
        $this->config = $app['config'];
        $this->configContract = $configContract;
        $this->moduleStatuses = $this->getModuleStatuses();
    }

    public function getModuleStatuses(): array
    {
        try {
            return $this->configContract->getConfig('plugin_statuse', []);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function enable(Plugin $plugin): void
    {
        $this->setActiveByName($plugin->getName(), true);
    }

    public function disable(Plugin $plugin): void
    {
        $this->setActiveByName($plugin->getName(), false);
    }

    public function hasStatus(Plugin $plugin, bool $status): bool
    {

        if (!isset($this->moduleStatuses[$plugin->getName()])) {
            return $status === false;
        }
        return $status === true;
    }

    public function setActive(Plugin $plugin, bool $active): void
    {
        $this->setActiveByName($plugin->getName(), $active);
    }

    public function delete(Plugin $plugin): void
    {
        unset($this->moduleStatuses[$plugin->getName()]);
        $this->writeData();
    }

    public function getAutoloadInfo(Plugin $plugin): array
    {
        return $this->moduleStatuses[$plugin->getName()] ?? [];
    }

    public function reset(): void
    {
        $this->moduleStatuses = [];
        $this->writeData();
    }

    public function setActiveByName(string $name, bool $active): void
    {
        if ($active) {
            $this->moduleStatuses[$name] = $name;
        } else {
            unset($this->moduleStatuses[$name]);
        }

        $this->writeData();
    }

    private function writeData(): void
    {
        set_config('plugin_statuse', $this->moduleStatuses);
        $this->configContract->setConfig('plugin_statuse', $this->moduleStatuses);
    }
}
