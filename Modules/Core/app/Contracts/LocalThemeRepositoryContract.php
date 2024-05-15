<?php

namespace Modules\Core\Contracts;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Modules\Core\Interfaces\ThemeInterface;

interface LocalThemeRepositoryContract
{
    /**
     * Get all theme info
     * 
     * @param bool $collection
     * @return array|Collection
    */

    public function scan(bool $collection = false): array|Collection;

    /**
     * Find a theme by name
     * 
     * @param string $name this is the name of the theme
     * @return ThemeInterface|null  return the theme if found
    */

    public function find(string $name): ?ThemeInterface;

    /**
     * Find a specific theme by name
     * 
     * @param string $name this is the name of the theme
     * @return ThemeInterface  return the theme if found
     * @throws ThemeNotFoundException if the theme is not found
    */

    public function findOrFail(string $name): ThemeInterface;

    /**
     * Retrive all themes
     * 
     * @param bool $collection
     * @return array|Collection
     */

    public function all(bool $collection = false): array|Collection;
    
    /**
     * Get the active theme
     * 
     * @return ThemeInterface
     */

    public function currentTheme(): ThemeInterface;

    /**
     * Has theme
     * 
     * @param string $name
     * @return bool
     */

    public function has(string $name): bool;

    /**
     * Delete a theme
     * 
     * @param string $name
     * @return bool
     */

    public function delete(string $name): bool;

    /**
     * Render a theme
     * 
     * @param string $view
     * @param array $params
     * @param string $theme
     * @return string|View|Factory|Response
     */

    public function render(string $view, array $params = [], ?string $theme = null): string|View|Factory|Response;

    /**
     * Parse a theme
     * 
     * @param mixed $params
     * @param string $theme
     * @return mixed
     */

    public function parseParam(mixed $params, ?string $theme = null): mixed;
}