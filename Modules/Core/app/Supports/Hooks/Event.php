<?php 

namespace Modules\Core\Supports\Hooks;

abstract class Event{
    /**
     * Holds the Event listeners
     * 
     * @var \Illuminate\Support\Collection
     */

    protected $listeners = [];

    /**
     * constructor method
     * 
     * @return void
     */

    public function __construct()
    {
        $this->listeners = collect([]);
    }

    /**
     * Add a new listener
     * 
     * @param string $hook
     * @param string $callback
     * @param int $priority
     * @param int $args
     * @return void
     */

     public function listen($hook, $callback, $priority = 10, $args = 1)
     {
        /*
            * Check if the callback is callable
        */
        // if(!is_callable($callback)){
        //     throw new \Exception('Invalid callback');
        // }
        
         $this->listeners->push([
             'hook' => $hook,
             'callback' => $callback,
             'priority' => $priority,
             'args' => $args
         ]);

        $this->listeners = $this->listeners->sortBy('priority');

         return $this;
     }

     /*
     * Trigger all callbacks attached to the hook
     * 
     * @param string $hook
     * @param mixed $params
     * @return mixed
     */

        // public function fire($hook, $params = '')
        // {
        //     $listeners = $this->listeners->where('hook', $hook);
    
        //     if($listeners->isEmpty()){
        //         return $params;
        //     }
    
        //     foreach($listeners as $listener){
        //         $params = call_user_func_array($listener['callback'], [$params]);
        //     }
    
        //     return $params;
        // }

         /**
     * TA CMS: Filters a value.
     *
     * @param string $action Name of action
     * @param array $args Arguments passed to the filter
     *
     * @return string Always returns the value
     */
    public function fire($action, $args)
    {
        
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
    }

    /**
     * remove hook for extending class
     *
     * @param [type] $hook
     * @param [type] $callback
     * @param integer $priority
     * @return void
     */
    protected function removeHook($hook, $callback, $priority = 10)
    {
        $this->listeners = $this->listeners->reject(function($listener) use ($hook, $callback, $priority){
            return $listener['hook'] == $hook && $listener['callback'] == $callback && $listener['priority'] == $priority;
        });
    }

    /**
     * Remove all hooks for extending class
     * 
     * @param string $hook
     * @param int $priority
     */

    protected function removeAllHook($hook = null, $priority = 10)
    {
        $this->listeners = $this->listeners->reject(function($listener) use ($hook, $priority){
            return $listener['hook'] == $hook && $listener['priority'] == $priority;
        });
    }

    /**
     * Check if hook exists for extending class
     * 
     * @param string $hook
     * @return bool
     */

    protected function hasHook($hook)
    {
        return $this->listeners->where('hook', $hook)->isNotEmpty();
    }
}