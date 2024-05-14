<?php

namespace Modules\Core\Supports;

use Composer\Autoload\ClassLoader;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Translation\Translator;
use Illuminate\View\ViewFinderInterface;
use Modules\Core\Contracts\PluginActivatorInterface;
use Throwable;
use Illuminate\Support\Str;
use Modules\Core\Supports\Json;

class Plugin
{
    use Macroable;

    protected Application $app;
    protected string $name;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected string $path;

    /**
     * The plugin namespace.
     *
     * @var string
     */

    protected string $namespace;

    /**
     * array of plugin service providers.
     *
     * @var array
     */
    protected array $moduleJson = [];

    protected PluginActivatorInterface $activator;

    protected Translator $lang;

    protected ViewFinderInterface $finder;

    private CacheManager $cache;

    private Filesystem $files;

    private Router $router;

    private UrlGenerator $url;

    /**
     * Create a new Plugin instance.
     *
     * @param Application $app
     * @param string $path
     */
    public function __construct(Application $app, string $path)
    {
        $this->path = $path;
        $this->cache = $app['cache'];
        $this->files = $app['files'];
        $this->router = $app['router'];
        $this->url = $app['url'];
        $this->lang = $app['translator'];
        $this->finder = $app['view']->getFinder();
        $this->app = $app;
        $this->name = $this->getName();
        $this->activator = $app[PluginActivatorInterface::class];

        $this->autoloadPSR4();
    }

    /**
     * Get the plugin description 
     * 
     *  @return string
     */

    public function getDescription(): string
    {
        return $this->get('description');
    }

    /**
     * Get specified key from the plugin plugin.json file.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */

    public function get(string $key, $default = null): mixed
    {
        return $this->json()->get($key, $default);
    }

    /**
     * Get json data from the cache , setting as needed.
     * 
     * @return mixed
     */

    // public function json(): array
    // {
    //     return $this->cache->rememberForever("plugin.{$this->name}.json", function () {
    //         return $this->files->exists($this->path('plugin.json'))
    //             ? json_decode($this->files->get($this->path('plugin.json')), true)
    //             : [];
    //     });
    // }

    public function json(string $file = null)
    {
        if ($file == null) {
            $file = 'composer.json';
        }

        // Arr::get(
        //     $this->moduleJson
        //     ,$file,
        //     function () use ($file){
        //         // return $this->moduleJson[$file] = json_decode($this->files->get($this->getPath($file)),true);
        //         return $this->moduleJson[$file] = new Json($this->getPath().'/'.$file, $this->files);
        //     }
        // );
        if (!isset($this->moduleJson[$file])) {
            $this->moduleJson[$file] = new Json($this->getPath() . '/' . $file, $this->files);
        }

        return $this->moduleJson[$file];
    }

    /**
     * Get Path
     * 
     * @param string|null $path
     * @return string
     */

    public function getPath(string $path = null): string
    {
        return $this->path . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Set Path
     * 
     * @param string $path
     * @return $this
     */

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get info 
     * 
     * @param bool $assoc
     * @return null|array|\Illuminate\Support\Collection
     */

    public function getInfo(bool $assoc = false): null|array|\Illuminate\Support\Collection
    {
        $configPath = $this->path . DIRECTORY_SEPARATOR . 'composer.json';
        if ($this->files->exists($configPath)) {
            $config = json_decode($this->files->get($configPath), $assoc);
            return $config;
        }
    }

    /**
     * Get alias 
     * 
     * @return string
     */

    public function getAlias(): string
    {
        return $this->get('alias');
    }

    /**
     * Get priority.
     *
     * @return string
     */
    public function getPriority(): string
    {
        return $this->get('priority');
    }

    /**
     * Get plugin requirements.
     *
     * @return array
     */
    public function getRequires(): array
    {
        return $this->get('require', []);
    }

    /**
     * Get name plugin.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->json()->get('name');
    }

    /**
     * Bootstrap the application event
     */

    public function boot(): void
    {
        $domain = $this->getDomainName();
    }

    /**
     * Get name in lower case.
     *
     * @return string
     */
    public function getLowerName(): string
    {
        return strtolower($this->name);
    }


    /**
     * Get the plugin domain name.
     *
     * @return string
     */

    public function getDomainName(): string
    {
        return $this->getExtraMojar('domain');
    }

    /**
     * Get the plugin extra mojar.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */

    public function getExtraMojar(string $key, $default = null): mixed
    {
        $extra = $this->get('extra', []);
        if ($laravel = Arr::get($extra, 'laravel', [])) {
            return Arr::get($laravel, $key, $default);
        }
        return $default;
    }

    /**
     * Get composer attribute
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */

    public function getComposerAttr(string $key, $default = null): mixed
    {
        return $this->json('composer.json')->get($key, $default);
    }

    /**
     * Plugin is visible
     * 
     * @return bool
     */

    public function isVisible(): bool
    {
        return $this->get('visible', true);
    }


    /**
     * Register the plugin
     *
     * @return void
     */

    public function register(): void
    {
        $this->registerProviders();
        $adminRouter = $this->getPath() . "/src/routes/admin.php";
        $apiRouter = $this->getPath() . "/src/routes/api.php";
        $webHookRouter = $this->getPath() . "/src/routes/webhook.php";
        $themeRouter = $this->getPath() . "/src/routes/theme.php";

        if (file_exists($adminRouter)) {
            $this->router->middleware('admin')
                ->prefix(config('plugin.admin_prefix'))
                ->group($adminRouter);
        }

        if (file_exists($apiRouter)) {
            $this->router->middleware('api')
                ->prefix('api')
                ->as('api.')
                ->group($apiRouter);
        }

        if (file_exists($webHookRouter)) {
            $this->router->middleware('web')
                ->prefix('webhook')
                ->as('webhook.')
                ->group($webHookRouter);
        }

        if (file_exists($themeRouter)) {
            $this->router->middleware('theme')
                ->prefix('theme')
                ->as('theme.')
                ->group($themeRouter);
        }

        $this->fireEvent('registered');
    }

    /**
     * Register the plugin service providers.
     *
     * @return void
     */
    protected function registerProviders(): void
    {
        $providers = $this->getExtraMojar('providers', []);
        foreach ($providers as $provider) {
            $this->app->register($provider);
        }

        if (config('core.plugin_autoload')) {
            $providers = array_merge(
                $this->getExtraLaravel('providers', []),
                $providers
            );
        }

        try {
            (new ProviderRepository($this->app, new Filesystem(), $this->app->getCachedServicesPath()))
                ->load($providers);
        } catch (\Throwable $e) {
            $this->disable();
            throw $e;
        }
    }

    /**
     * Get the plugin extra laravel.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */

    public function getExtraLaravel(string $key, $default = null): mixed
    {
        $extra = $this->get('extra', []);
        if ($laravel = Arr::get($extra, 'laravel', [])) {
            return Arr::get($laravel, $key, $default);
        }
        return $default;
    }

    /**
     * getCachedServicesPath method
     * 
     * @return string
     */

    public function getCachedServicesPath(): string
    {
        return Str::replaceLast('service.php', $this->getSnakeName() . "_module.php", $this->app->getCachedServicesPath());
    }

    /**
     * Get snake name
     *
     * @return string
     */

    public function getSnakeName(): string
    {
        return Str::snake(preg_replace('/[^0-9a-z]/', '', $this->name));
    }

    /**
     * Disable the plugin
     * 
     * @return void
     * 
     */

    public function disable(): void
    {
        $this->fireEvent('disabling');
        $this->activator->disable($this);
        $this->flashcache();
        $this->fireEvent('disabled');
    }

    /**
     * Flash the cache
     * 
     * @return void
     */

    public function flashcache(): void
    {
        if (config('core,cache.enabled')) {
            $this->cache->store()->forget("plugin.{$this->name}.json");
        }
    }

    /**
     * Get studly name
     * 
     * @return string
     */

    public function getStudlyName(): string
    {
        $name = explode('/', $this->name);
        $autor = Str::studly($name[0]);
        $plugin = Str::studly($name[1]);
        return $autor . '/' . $plugin;
    }

    /**
     * Determine what ever the plugin status same with the given status.
     * 
     * @param string $status
     * @return bool
     */

    public function isStatus(bool $status): bool
    {
        return $this->activator->hasStatus($this, $status);
    }

    /**
     * Determine what ever the plugin is enabled.
     * 
     * @return bool
     */

    public function isEnabled(): bool
    {
        return $this->activator->hasStatus($this, true);
    }

    /**
     * Determine what ever the plugin is disabled.
     * 
     * @return bool
     */

    public function isDisabled(): bool
    {
        return !$this->isEnabled();
    }

    /**
     * Set Active status for the plugin.
     * 
     * @return bool
     */

    public function setActive(): bool
    {
        $this->activator->setActive($this, true);
        return true;
    }

    /**
     * Disable the plugin
     * 
     * @return void
     * 
     */

    public function enable(): void
    {
        $this->fireEvent('enableing');
        $this->activator->enable($this);
        $this->flashcache();
        $this->runMigrate();
        $this->publishAssets();
        $this->fireEvent('enabled');
    }

    /**
     * Run the plugin migration
     * 
     * @return void
     */

    public function runMigrate(): void
    {
        Artisan::call('migrate', [
            '--path' => $this->getPath('database/migrations'),
            '--force' => true
        ]);
    }

    /**
     * Publish the plugin assets
     * 
     * @return void
     */


    public function publishAssets(): void
    {
        Artisan::call('vendor:publish', [
            '--tag' => $this->getLowerName() . '-assets',
            '--force' => true
        ]);
    }

    /**
     * Delete the plugin
     * 
     * @return bool
     */

    public function delete(): bool
    {
        $this->fireEvent('deleting');
        $this->activator->delete($this);
        $this->flashcache();
        $this->fireEvent('deleted');
        return $this->json()->getFilesystem()->deleteDirectory($this->getPath());
    }

    /**
     * Fire the given event for the plugin.
     * 
     * @param string $event
     * @return void
     */
    public function fireEvent(string $event): void
    {
        $this->app['events']->dispatch("plugin.{$event}: {$this->getLowerName()}", [$this]);
    }

    /**
     * Auto load PSR-4
     * 
     * @return void
     */

    public function autoloadPSR4(): void
    {
        $locadMaps = $this->activator->getAutoloadInfo($this) ?? [];
        $loader = new ClassLoader();

        foreach ($locadMaps as $loaderMap) {
            if (empty($loaderMap['namespace']) || empty($loaderMap['path'])) {
                continue;
            }

            $loader->setPsr4($loaderMap['namespace'], $this->getPath($loaderMap['path']));
        }
        $loader->register();
    }
    /**
     * Register Files 
     * 
     * @return void
     */

    public function registerFiles(): void
    {
        $files = Arr::get($this->get('autoload', []), 'files', []);
        foreach ($files as $file) {
            include $this->path . DIRECTORY_SEPARATOR . $file;
        }
    }
}
