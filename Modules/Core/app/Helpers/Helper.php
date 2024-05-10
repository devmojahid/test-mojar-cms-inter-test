<?php

/**
 * Mojar CMS - A Laravel CMS with Content Management Features
 * 
 * @package  mojahid/mojar 
 * @author Mojahid <raofahmedmojahid@gmail.com>
 * @version 1.0.0
 * @link https://github.com/devmojahid
 */

use Modules\Core\Facades\Config;
use Modules\Core\Facades\Hook;

if(!function_exists('do_action')){
    /**
     * Do action
     *
     * @param string $hook
     * @param mixed $args
     * @return void
     */
    function do_action($hook, $args = '')
    {
        Hook::doAction($hook, $args);
    }
}

if(!function_exists('add_action')){
    /**
     * Add action
     *
     * @param string $hook
     * @param mixed $callback
     * @param int $priority
     * @param int $args
     * @return void
     */
    function add_action($hook, $callback, $priority = 10, $args = 1)
    {
        Hook::addAction($hook, $callback, $priority, $args);
    }
}

if(!function_exists('apply_filter')){
    /**
     * Apply filter
     *
     * @param string $hook
     * @param mixed $value
     * @param mixed $args
     * @return mixed
     */
    function apply_filter($hook, $value, $args = '')
    {
        return Hook::applyFilter($hook, $value, $args);
    }
}

if(!function_exists('add_filter')){
    /**
     * Add filter
     *
     * @param string $hook
     * @param mixed $callback
     * @param int $priority
     * @param int $args
     * @return void
     */
    function add_filter($hook, $callback, $priority = 10, $args = 1)
    {
        Hook::addFilter($hook, $callback, $priority, $args);
    }
}

if(!function_exists('hello')){
    /**
     * Remove action
     *
     * @param string $hook
     * @param string $callback
     * @param int $priority
     * @return void
     */
    function hello(){
        return 'Hello World';
    }
}

if (!function_exists('hello1')) {
    /**
     * Get module path
     *
     * @param string $module
     * @param string $path
     * @return string
     */
    function hello1()
    {
        return "Hello World";
    }
}

function is_json(mixed $string): bool
    {
        try {
            json_decode($string);

            return json_last_error() === JSON_ERROR_NONE;
        } catch (\Throwable $e) {
            return false;
        }
    }

if (!function_exists('set_config')) {
    /**
     * Set DB config
     *
     * @param string $key
     * @param mixed $value
     * @return \Juzaweb\CMS\Models\Config
     */
    function set_config(string $key, mixed $value)
    {
        return Config::setConfig($key, $value);
    }
}

if(!function_exists('cache_prifix')){
    /**
     * Get cache prifix
     *
     * @param string $prifix
     * @return string
     */
    function cache_prifix($prifix = '')
    {
        return config('core.cache.prefix').$prifix;
    }
}