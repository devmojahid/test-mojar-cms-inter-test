<?php

namespace Modules\Core\Supports;

use Illuminate\Support\Traits\Macroable;
use Modules\Core\Contracts\LocalPluginRepositoryContract;
use Illuminate\Container\Container;
use Illuminate\Cache\CacheManager;
use illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Core\Exceptions\PluginNotFoundException;

class LocalPluginRepository implements LocalPluginRepositoryContract
{
    use Macroable;

    /**
     * Application instance.
     * 
     * @var Container
     */
    protected Container $app;

    /**
     * The plugin path.
     * 
     * @var string|null
     */

    protected ?string $path;

    /**
     * The scanned paths.
     *
     * @var array
     */

    protected array $paths = [];

    /**
     * Url generator instance.
     * 
     * @var UrlGenerator
     */

    protected UrlGenerator $url;

    /**
     * Filesystem
     * 
     * @var Filesystem
     */

    protected Filesystem $files;

    /**
     * ConfigRepository.
     * 
     * @var ConfigRepository
     */

    protected ConfigRepository $config;

    /**
     * Cache Manager.
     * 
     * @var CacheManager
     */

    protected CacheManager $cache;

    /**
     * Constructor class.
     * 
     * @param Container $app
     * @param string $path
     */

    public function __construct(Container $app, string $path = null)
    {
        $this->app = $app;
        $this->path = $path;
        $this->url = $app['url'];
        $this->files = $app['files'];
        $this->config = $app['config'];
        $this->cache = $app['cache'];
    }

    /**
     * Add other plugin location
     * 
     * @param string $path
     * @return $this
     */

    public function addLocation(string $path)
    {
        $this->paths[] = $path;
        return $this;
    }

    /**
     * Get all additional paths.
     * 
     * @return string
     */

    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * Get all scanned paths.
     * 
     * @return array
     */

    public function getScannedPaths(): array
    {
        $paths = $this->paths;
        $paths[] = $this->getPath() . "/*";
        return array_map(function ($path) {
            return Str::endsWith($path, '/*') ? $path : Str::finish($path, '/*');
        }, $paths);
    }

    /**
     * get path
     *
     * @return string
     */

    public function getPath(): string
    {
        return $this->path ?: base_path('plugins');
    }

    /**
     * Scan all available plugins.
     * 
     * @return array
     */

    public function scan(bool $collection = false): array|Collection
    {
        $paths = $this->getScannedPaths();
        $plugins = [];
        foreach ($paths as $path) {
            $manifests = $this->getFiles()->glob("{$path}/composer.json");
            is_array($manifests) || $manifests = [];

            foreach ($manifests as $manifest) {
                $plugin = $this->createPlugin($this->app, dirname($manifest));

                if (!$name = $plugin->getName()) {
                    continue;
                }

                if (!$plugin->isVisible()) {
                    continue;
                }

                $plugins[$name] = $collection ? $plugin->getInfo()->toArray() : $plugin;
            }
        }
        return $collection ? collect($plugins) : $plugins;
    }

    /**
     * Get all plugins.
     *
     * @param bool $collection
     * @return array|Collection
     * @throws Exception
     */
    public function all(bool $collection = false): array|Collection
    {
        if (!$this->config('core.cache.enabled')) {
            return $this->scan();
        }
        return $this->formatCached($this->getCached());
    }


    /**
     * Format cached plugins.with array of plugins.
     * 
     * @param array $plugins
     * 
     * @return array 
     */

    public function formatCached(array $cached): array
    {
        $modules = [];
        foreach ($cached as $name => $module) {
            $path = $module['path'];
            $modules[$name] = $this->createPlugin($this->app, $path);
        }
        return $modules;
    }

    /**
     * Get cached plugins.
     *
     * @return array
     */
    public function getCached(): array
    {
        return $this->cache->remember(
            $this->config('core.cache.key'),
            $this->config('core.cache.lifetime'),
            function () {
                return $this->toCollaction()->toArray();
            }
        );
    }

    /**
     * Get plugin as plugin collection instance.
     *
     *@return PluginCollection
     *@throws Exception
     */
    public function toCollaction(): PluginCollection
    {
        return new PluginCollection($this->scan());
    }


    /**
     * Get plugin by status
     * 
     * @param $status
     * @return array
     * @throws Exception
     */
    public function getByStatus($status): array
    {
        $modules = [];
        foreach ($this->all() as $name => $module) {
            if ($module->isStatus($status)) {
                $modules[$name] = $module;
            }
        }
        return $modules;
    }

    /**
     * Determine plugin is exists.
     * 
     * @param string $name
     * @return bool
     * @throws Exception
     */

    public function has($name): bool
    {
        return array_key_exists($name, $this->all());
    }

    /**
     * Get enabled plugins.
     * 
     * @return array
     */

    public function allEnabled(): array
    {
        return $this->getByStatus(true);
    }

    /**
     * Get disabled plugins.
     * 
     * @return array
     */

    public function allDisabled(): array
    {
        return $this->getByStatus(false);
    }

    /**
     * Get count of all plugins.
     *
     * @return int
     */

    public function count(): int
    {
        return count($this->all());
    }

    /**
     * Get all ordered plugins.
     * 
     * @param string $direction
     * @return array
     */

    public function getOrdered($direction = 'asc'): array
    {

        $modules = $this->allEnabled();
        uasort($modules, function (Plugin $a, Plugin $b) use ($direction) {
            if ($a->get('order') == $b->get('order')) {
                return 0;
            }

            if ($direction == 'asc') {
                return $a->get('order') > $b->get('order') ? 1 : -1;
            }

            return $a->get('order') < $b->get('order') ? 1 : -1;
        });
        return $modules;
    }

    public function register(): void
    {
        foreach ($this->getOrdered() as $module) {
            $module->register();
        }
    }

    public function boot(): void
    {
        foreach ($this->getOrdered() as $module) {
            $module->boot();
        }
    }

    /**
     * Get plugin by name.
     * 
     * @param string $name
     * @return Plugin
     */

    public function find(string $name): Plugin
    {
        foreach ($this->all() as $plugin) {
            if ($plugin->getLowername() === strtolower($name)) {
                return $plugin;
            }
        }
        return null;
    }

    /**
     * Find by alias.
     * 
     * @param string $alias
     * @return Plugin
     */

    public function findByAlias(string $alias): Plugin
    {
        foreach ($this->all() as $plugin) {
            if ($plugin->getAlias() === $alias) {
                return $plugin;
            }
        }
        return null;
    }

    /**
     * Find requiremenets.
     * 
     * @param string $name
     * @return array
     */

    public function findRequirements(string $name): array
    {
        $requirements = [];
        $modules = $this->findOrFail($name);
        foreach ($modules->getRequires() as $requirement) {
            $requirements[] = $this->findByAlias($requirement);
        }
        return $requirements;
    }

    /**
     * findOrFail plugin.
     * 
     * @param string $name
     * @return Plugin
     */

    public function findOrFail(string $name): Plugin
    {
        $module = $this->find($name);
        if (!$module) {
            throw new PluginNotFoundException("Plugin [{$name}] does not exist.");
        }
        return $module;
    }

    /**
     * Get all modules as laravel collection instance.
     * 
     * @return PluginCollection
     * @throws Exception
     */

    public function collections(int $status = 1): PluginCollection
    {
        return new PluginCollection($status ? $this->getByStatus($status) : $this->all());
    }

    /**
     * GetModulePath plugin.
     * 
     * @param string $name
     * @return string
     */

    public function getModulePath(string $name): string
    {
        try {
            return $this->findOrFail($name)->getPath() . '/';
        } catch (PluginNotFoundException $e) {
            $name = Str::lower($name);
            $name = explode('/', $name)[1];
            return $this->getPath() . "/{$name}/";
        }
    }

    /**
     * Get assetPath plugin.
     * 
     * @param string $module
     * @return string
     * @throws Exception
     */

    public function assetPath(string $module): string
    {
        return public_path("plugins/{$module}/assets");
    }

    /**
     * @inheritDoc
     */

    public function config(string $key = null, $default = null)
    {
        return $this->config->get("plugin.{$key}", $default);
    }

    /**
     * getUsedStoragePath plugin.
     * 
     * @return string
     */

    public function getUsedStoragePath(): string
    {
        $directory = storage_path('app/plugins');
        if (!$this->files->exists($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        $path = $directory . '/plugin.used';
        if (!$this->files->exists($path)) {
            $this->files->put($path, '');
        }

        return $path;
    }


    /**
     * Get files.
     * 
     * @return Filesystem
     */

    public function getFiles(): Filesystem
    {
        return $this->files;
    }

    /**
     * Get assetPath for a plugin.
     * 
     * @return string
     */

    public function getAssetsPath(): string
    {
        return public_path('plugins');
    }

    public function assets(string $name, string $path): string
    {
        $url = $this->url->asset("plugins/{$name}/{$path}");
        return str_replace('http://', 'https://', $url);
    }

    /**
     * @inheritDoc
     */
    public function isEnabled(string $name)
    {
        return $this->findOrFail($name)->isEnabled();
    }

    /**
     * @inheritDoc
     */

    public function isDisabled(string $name)
    {
        return !$this->isEnabled($name);
    }

    /**
     * @inheritDoc
     */

    public function enable(string $name)
    {
        $this->findOrFail($name)->enable();
    }

    /**
     * @inheritDoc
     */

    public function disable(string $name)
    {
        $this->findOrFail($name)->disable();
    }

    /**
     * @inheritDoc
     */

    public function delete(string $name)
    {
        $this->findOrFail($name)->delete();
    }

    /**
     * Create a new plugin instance.
     * 
     * @param mixed ...$args
     * @return Plugin
     */

    public function createPlugin(...$args): Plugin
    {
        return new Plugin(...$args);
    }
}