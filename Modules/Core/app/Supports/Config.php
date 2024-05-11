<?php

namespace Modules\Core\Supports;

use Illuminate\Cache\CacheManager;
use Illuminate\Container\Container;
use Illuminate\Support\Arr;
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
        if (Installer::alreadyInstalled()) {
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
        $configKeys = explode('.', $key);
        $value = $this->configs[$configKeys[0]] ?? $default;
        if (is_json($value)) {
            $value = json_decode($value, true);
            if (count($configKeys) > 1) {
                unset($configKeys[0]);
                $value = Arr::get($value, implode('.', $configKeys), $default);
            }
        }

        return $value;
    }

    public function setConfig(string $key, string|array $value = null): ConfigModel
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $config = ConfigModel::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        $this->configs[$key] = $value;
        $this->cache->store('file')->forever($this->getCacheKey(), $this->configs);
        return $config;
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
