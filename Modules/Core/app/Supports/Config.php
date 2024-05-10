<?php

namespace Modules\Core\Supports;

use Illuminate\Cache\CacheManager;
use Illuminate\Container\Container;
use Modules\Core\Contracts\ConfigContract;
use Modules\Core\Models\Config as ConfigModel;
use Illuminate\Support\Collection;

class Config implements ConfigContract
{
    protected array $configs = [];
    protected CacheManager $cache;
    public function __construct(Container $app, CacheManager $cache)
    {
        
        $this->cache = $cache;
        if(Installer::alreadyInstalled()){
            $this->configs = $this->cache
                ->store('file')
                ->rememberForever(
                    $this->getCacheKey(),
                    function () {
                        return ConfigModel::all()->pluck('value', 'key')->toArray();
                    }
                );
        }
    }

    public function getCacheKey(): string
    {
        return cache_prifix('mojar_configs_');
    }

    public function getConfig(string $key, string|array $default = null): null|string|array
    {
        return "hello";
    }

    public function setConfig(string $key, string|array $value = null): ConfigModel
    {
        return new Config();
    }

    public function getConfigs(array $keys, string|array $default = null): array
    {
        return [];
    }

    public function all(): Collection
    {
        return new Collection();
    }
}
