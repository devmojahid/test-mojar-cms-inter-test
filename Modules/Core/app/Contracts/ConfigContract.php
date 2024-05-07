<?php 

namespace Modules\Core\Contracts;

use Illuminate\Support\Collection;
use Modules\Core\Models\Config;

interface ConfigContract
{
    /**
     * Get the value of the given key.
     *
     * @param string $key
     * @param string|array|null $default
     *
     * @return string|array|null
     */
    public function getConfig(string $key, string|array $default = null): null|string|array;

    /**
     * Set the value of the given key.
     *
     * @param string $key
     * @param string|array|null $default
     *
     * @return string|array|null
     */
    public function setConfig(string $key, string|array $value = null): Config;

    /**
     * Get Configs
     *
     * @param array $keys
     * @param string|array|null $default
     * @return array
     */   

    public function getConfigs(array $keys, string|array $default = null): array;

    /**
     * Get all the configuration values.
     *
     * @return array
     */
    public function all(): Collection;
}