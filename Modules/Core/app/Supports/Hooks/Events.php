<?php
namespace Modules\Core\Supports\Hooks;

use Modules\Core\Contracts\HookContracts;

class Events implements HookContracts{

    /**
     * Holds all the registard actions
     * 
     * @var \Modules\Core\Supports\Hooks\Action
     */

    protected $actions;

    /**
     * Holds all the registard filters
     * 
     * @var \Modules\Core\Supports\Hooks\Filter
     */

    protected $filters;

    /**
     * Holds the priority
     * 
     * @var int
     */

    protected $priority;

    /**
     * Holds the callback
     * 
     * @var string
     */

    protected $callback;

    /**
     * Holds the args
     * 
     * @var int
     */

    protected $args;
    
    /**
     * Create a new instance
     * 
     * @return void
     */
    public function __construct()
    {
        $this->actions = new Action();
        $this->filters = new Filter();
    }

    /**
     * Get the action instance
     *
     * @return \Modules\Core\Supports\Hooks\Action
     */
    public function getAction()
    {
        return $this->actions;
    }

    /**
     * Get the filter instance
     *
     * @return \Modules\Core\Supports\Hooks\Filter
     */

    public function getFilter()
    {
        return $this->filters;
    }

    /**
     * Get the priority
     *
     * @return int
     */

    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get the callback
     *
     * @return string
     */

    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Get the args
     *
     * @return int
     */

    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Add action
     *
     * @param string $hook
     * @param string $callback
     * @param int $priority
     * @param int $args
     * @return void
     */

    public function addAction($hook, $callback, $priority = 10, $args = 1)
    {
        $this->actions->listen($hook, $callback, $priority, $args);
    }

    /**
     * Remove action
     *
     * @param string $hook
     * @param string $callback
     * @param int $priority
     * @return void
     */

    public function removeAction($hook, $callback, $priority = 10)
    {
        $this->actions->remove($hook, $callback, $priority);
    }

    /**
     * Remove all actions
     *
     * @param string $hook
     * @param int $priority
     * @return void
     */

    public function removeAllAction($hook = null, $priority = 10)
    {
        $this->actions->removeAll($hook, $priority);
    }

    /**
     * Do action
     *
     * @param string $hook
     * @param mixed $args
     * @return void
     */

    public function doAction($hook, $args = '')
    {
        $this->actions->fire($hook, $args);
    }

    /**
     * Check if action exists
     *
     * @param string $hook
     * @return bool
     */

    public function hasAction($hook)
    {
        return $this->actions->has($hook);
    }

    /**
     * Add filter
     *
     * @param string $hook
     * @param string $callback
     * @param int $priority
     * @param int $args
     * @return void
     */

    public function addFilter($hook, $callback, $priority = 10, $args = 1)
    {
        $this->filters->listen($hook, $callback, $priority, $args);
    }

    /**
     * Remove filter
     *
     * @param string $hook
     * @param string $callback
     * @param int $priority
     * @return void
     */

    public function removeFilter($hook, $callback, $priority = 10)
    {
        $this->filters->remove($hook, $callback, $priority);
    }

    /**
     * Remove all filters
     *
     * @param string $hook
     * @param int $priority
     * @return void
     */

    public function removeAllFilter($hook = null, $priority = 10)
    {
        $this->filters->removeAll($hook, $priority);
    }

    /**
     * Apply filter
     *
     * @param string $hook
     * @param mixed $value
     * @param mixed $args
     * @return mixed
     */

    public function applyFilter($hook, $value, $args = '')
    {
        return $this->filters->fire($hook, $value, $args);
    }

    /**
     * Check if filter exists
     *
     * @param string $hook
     * @return bool
     */

    public function hasFilter($hook)
    {
        return $this->filters->has($hook);
    }

    /**
     * Add hook
     *
     * @param string $hook
     * @param string $callback
     * @param int $priority
     * @param int $args
     * @return void
     */

    public function addHook($hook, $callback, $priority = 10, $args = 1)
    {
        $this->addAction($hook, $callback, $priority, $args);
        $this->addFilter($hook, $callback, $priority, $args);
    }

    /**
     * Remove hook
     *
     * @param string $hook
     * @param string $callback
     * @param int $priority
     * @return void
     */

    public function removeHook($hook, $callback, $priority = 10)
    {
        $this->removeAction($hook, $callback, $priority);
        $this->removeFilter($hook, $callback, $priority);
    }

    /**
     * Remove all hooks
     *
     * @param string $hook
     * @param int $priority
     * @return void
     */

    public function removeAllHook($hook = null, $priority = 10)
    {
        $this->removeAllAction($hook, $priority);
        $this->removeAllFilter($hook, $priority);
    }

    /**
     * Do hook
     *
     * @param string $hook
     * @param mixed $args
     * @return void
     */

    public function doHook($hook, $args = '')
    {
        $this->doAction($hook, $args);
    }

    /**
     * Check if hook exists
     *
     * @param string $hook
     * @return bool
     */

    public function hasHook($hook)
    {
        return $this->hasAction($hook);
    }

    /**
     * Set the action
     * 
     * @param \Modules\Core\Supports\Hooks\Action $actions
     * @return void
     */

     public function Action(){
        $args = func_get_args();
        $hook = $args[0];
        unset($args[0]);
        $args = array_values($args);
        $this->actions->fire($hook, $args);
     }

    /**
     * Set the filter
     * 
     * @param \Modules\Core\Supports\Hooks\Filter $filters
     * @return void
     */

    public function Filter(){
        $args = func_get_args();
        $hook = $args[0];
        unset($args[0]);
        $args = array_values($args);
        return $this->filters->fire($hook, $args);
    }
}