<?php

namespace Modules\Core\Supports;

use Modules\Core\Contracts\ConfigContract;
use Modules\Core\Models\Config as ConfigModel;
use Illuminate\Support\Collection;

class Config implements ConfigContract
{
    public function getConfig(string $key, string|array $default = null): null|string|array
    {
        return null;
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
