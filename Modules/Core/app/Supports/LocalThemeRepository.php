<?php

namespace Modules\Core\Supports;

use Illuminate\Container\Container;
use Modules\Core\Contracts\LocalThemeRepositoryContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Modules\Core\Exceptions\ThemeNotFoundException;
use Modules\Core\Interfaces\ThemeInterface;

class LocalThemeRepository implements LocalThemeRepositoryContract
{
    protected Container $app;

    protected string $basePath;

    protected Theme $theme;

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
        foreach($themeDirectory as $themePath){
            $theme = $this->createTheme(
                $this->app,
                $themePath
            );

            if(!$name = $theme->getName()){
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
        foreach($this->all() as $theme){
            if($theme->getLower() == strtolower($name)){
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
        if(!$theme = $this->find($name)){
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
        if(isset($this->currentTheme)){
            return $this->currentTheme;
        }
    }
}