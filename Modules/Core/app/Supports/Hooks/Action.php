<?php

namespace Modules\Core\Supports\Hooks;

class Action extends Event
{
   

    /**
     * Has action
     *
     * @param string $hook
     */

    public function has($hook)
    {
        return $this->hasHook($hook);
    }

    /**
     * Remove action
     *
     * @param string $hook
     * @param string $callback
     * @param int $priority
     * @param int $args
     */

    public function remove($hook, $callback, $priority = 10)
    {
        $this->removeHook($hook, $callback, $priority);
    }

    /**
     * Remove all action
     *
     * @param string $hook
     * @param int $priority
     */

    public function removeAll($hook = null, $priority = 10)
    {
        $this->removeAllHook($hook, $priority);
    }
}