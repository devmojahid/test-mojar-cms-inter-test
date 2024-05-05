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

interface HookContracts{
    public function getAction();
    public function getFilter();
    public function getPriority();
    public function getCallback();
    public function getArgs();

    public function addAction($hook, $callback, $priority = 10, $args = 1);
    public function removeAction($hook, $callback, $priority = 10);
    public function removeAllAction($hook = null, $priority = 10);
    public function doAction($hook, $args = '');
    public function hasAction($hook);
    public function addFilter($hook, $callback, $priority = 10, $args = 1);
    public function removeFilter($hook, $callback, $priority = 10);
    public function removeAllFilter($hook = null, $priority = 10);
    public function applyFilter($hook, $value, $args = '');
    public function hasFilter($hook);

    public function addHook($hook, $callback, $priority = 10, $args = 1);
    public function removeHook($hook, $callback, $priority = 10);
    public function removeAllHook($hook = null, $priority = 10);
    public function doHook($hook, $args = '');
    public function hasHook($hook);
    
}