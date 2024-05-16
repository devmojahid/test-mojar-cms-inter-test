<?php

namespace Modules\Core\Supports;

use Illuminate\Container\Container;
use Modules\Core\Contracts\LocalThemeRepositoryContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Modules\Core\Exceptions\ThemeNotFoundException;
use Modules\Core\Interfaces\ThemeInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class LocalThemeRepository implements LocalThemeRepositoryContract
{
    protected Container $app;

    protected string $basePath;

    protected Theme $currentTheme;

    public function __construct(Container $app, string $path)
    {
        $this->app = $app;
        $this->basePath = $path;
    }

    /**
     * Get all theme info
     * 
     * @param bool $collection
     * @return array|Collection
     */

    public function scan(bool $collection = false): array|Collection
    {
        $themeDirectory = File::directories($this->basePath);
        $themes = [];
        foreach ($themeDirectory as $themePath) {
            $theme = $this->createTheme(
                $this->app,
                $themePath
            );

            if (!$name = $theme->getName()) {
                continue;
            }

            $themes[$name] = $collection ? $theme->getInfo()->array() : $theme;
        }
        return $collection ? (new Collection($themes)) : $themes;
    }

    /**
     * Find a theme by name
     * 
     * @param string $name this is the name of the theme
     * @return ThemeInterface|null  return the theme if found
     */
    public function find(string $name): ?ThemeInterface
    {
        foreach ($this->all() as $theme) {
            if ($theme->getLower() == strtolower($name)) {
                return $theme;
            }
        }
        return null;
    }

    /**
     * Find a specific theme by name
     * 
     * @param string $name this is the name of the theme
     * @return ThemeInterface  return the theme if found
     * @throws ThemeNotFoundException if the theme is not found
     */

    public function findOrFail(string $name): ThemeInterface
    {
        if (!$theme = $this->find($name)) {
            throw new ThemeNotFoundException("Theme [{$name}] not found");
        }
        return $theme;
    }

    /**
     * Current theme
     * 
     * @return Theme
     */

    public function currentTheme(): Theme
    {
        if (isset($this->currentTheme)) {
            return $this->currentTheme;
        }

        return $this->currentTheme = $this->findOrFail($this->app['config']->get('core.theme'));
    }

    /**
     * Retrive all themes
     * 
     * @param bool $collection
     * @return array|Collection
     */

    public function all(bool $collection = false): array|Collection
    {
        return $this->scan($collection);
    }

    /**
     * Has theme
     * 
     * @param string $name
     * @return bool
     */

    public function has(string $name): bool
    {
        return $this->find($name) !== null;
    }

    /**
     * Delete a theme
     * 
     * @param string $name
     * @return bool
     */

    public function delete(string $name): bool
    {
        return $this->findOrFail($name)->delete();
    }

    /**
     * Render a theme
     * 
     * @param string $view
     * @param array $params
     * @param string $theme
     * @return string|View|Factory|Response
     */

    public function render(string $view, array $params = [], ?string $theme = null): string|View|Factory|Response
    {
        $theme = $theme ? $this->findOrFail($theme) : $this->currentTheme();
        return $this->themeRender($theme)->render($view, $params);
    }

    /**  
     * Parse a theme
     * 
     * @param mixed $params
     * @param string $theme
     * @return mixed
     */

    public function parseParam(mixed $params, ?string $theme = null): mixed
    {
        $theme = $theme ? $this->findOrFail($theme) : $this->currentTheme();
        return $this->themeRender($theme)->parseParam($params);
    }

    /**
     * Theme render
     * 
     * @param Theme $theme
     * @return themeRender
     */

    protected function themeRender(ThemeInterface $theme): themeRender
    {
        return $this->app->make(ThemeRender::class, ['theme' => $theme]);
    }

    /**
     * Create a theme
     * 
     * @param Container $app
     * @param string $path
     * @return Theme
     */

    protected function createTheme(...$args): Theme
    {
        return new Theme(...$args);
    }
}
