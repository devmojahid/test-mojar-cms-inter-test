<?php

namespace Modules\Core\Supports\Hooks;

class Filter extends Event{

    /**
     * Holds the value
     * 
     * @var mixed
     */
    protected $value;
    /**
     * Has filter
     * 
     * @param string $hook
     */

    public function has($hook)
    {
        return $this->hasHook($hook);
    }

    /**
     * fire filter
     * 
     * @param string $action
     * @param mixed $args
     * @return mixed
     * 
     */

     public function fire($action, $args)
     {
        $this->value = isset($args[0]) ? $args[0] : null;

         $listeners = $this->listeners->where('hook', $action);
 
         if($listeners->isEmpty()){
             return $args;
         }
 
         $listeners->each(function($listener) use ($args){
             $parameters = [];
             for($i = 0; $i < $listener['args']; $i++){
                 $value = $args[$i] ?? null;
                 $parameters[] = $value;
             }
             call_user_func_array($listener['callback'], $parameters);
         });

         echo $this->value;
     }

    /**
     * Remove filter
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
     * Remove all filter
     * 
     * @param string $hook
     * @param int $priority
     */

    public function removeAll($hook = null, $priority = 10)
    {
        $this->removeAllHook($hook, $priority);
    }
}