<?php

/**
 * Mojar CMS - A Laravel CMS with Content Management Features
 * 
 * @package  mojahid/mojar 
 * @author Mojahid <raofahmedmojahid@gmail.com>
 * @version 1.0.0
 * @link https://github.com/devmojahid
 */

namespace Modules\Core\Contracts;

use Modules\Core\Exceptions\PluginNotFoundException;

interface LocalPluginRepositoryContract{
    /**
     * Get all plugins.
     *
     * @return array
     */

    public function all();
    
    /**
     * Get cached plugins.
     *
     * @return array
     */

    public function getCached();

    /**
     * Scan all available plugins.
     *
     * @return array
     */

    public function scan();

    /**
     * Get plugin as plugin collection instance.
     *
     * @return array
     */

     public function toCollaction();

    /**
     * Get scanned paths.
     * 
     * @return array
     */

    public function getScannedPaths();
    
    /**
     * Get enabled plugins.
     * 
     * @return array
     */

    public function allEnabled();

    /**
     * Get disabled plugins.
     * 
     * @return array
     */

    public function allDisabled();

    /**
     * Get count of all plugins.
     */

    public function count();

    /**
     * Get all ordered plugins.
     * 
     * @param string $direction
     * @return array
     */

    public function getOrdered($direction = 'asc');

    /**
     * Get by status.
     * 
     * @param string $status
     * @return array
     */

    public function getByStatus($status);

    /**
     * Find a spacific plugin.
     * 
     * @param string $name
     * 
     */

    public function find(string $name);
    
    /**
     * Find a specific plugin .If there return the plugin, if not, throw an exception.
     * 
     * @param string $name
     * @return array
     * @throws PluginNotFoundException
     */

    public function findOrFail(string $name);

    /**
     * Get module path.
     * 
     * @param string $name
     */

    public function getModulePath(string $name);

    /**
     * Get files
     * 
     * @return \illuminate\Filesystem\Filesystem
     */

    public function getFiles();

    /**
     * Get config data from configurations.
     * 
     * @param string|null $default
     * @return mixed
     */

     public function config(string $key = null, $default = null);

     /**
      * Get a plugin path.
      */

    public function getPath();

    /**
     * Get a plugin by its alias.
     * 
     * @param string $alias
     */

    public function findByAlias(string $alias);

    /**
     * Boot the plugin.
     */

    public function boot(): void;

    /**
     * Register the plugin.
     */

     public function register(): void;

     /**
      * Get assetPath for a plugin.
      * 
      * @param string $module
      * @return string
      * @throws PluginNotFoundException
      */

    public function assetPath(string $module);

    /**
     * Delete a specific plugin.
     * 
     * @param string $name
     * @return bool
     */

    public function delete(string $name);

    /**
     * Determine if a plugin enabled.
     * 
     * @param string $name
     * @return bool
     * @throws PluginNotFoundException
     */

    public function isEnabled(string $name);

    /**
     * Determine if a plugin disabled.
     * 
     * @param string $name
     * @return bool
     * @throws PluginNotFoundException
     */

    public function isDisabled(string $name);
    

}  