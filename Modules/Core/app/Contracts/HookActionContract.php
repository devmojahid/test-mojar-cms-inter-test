<?php

namespace Modules\Core\Contracts;

interface HookActionContract
{
    /**
     * Add an action to the hook manager.
     *
     * @param string   $tag        The name of the action.
     * @param callable $callback   The callback function to execute when the action is called.
     * @param int      $priority   (Optional) The priority of the action. Default is 20.
     * @param int      $arguments  (Optional) The number of arguments the callback accepts. Default is 1.
     *
     * @return void
     */

    // public function addAction($tag, $callback, $priority = 20, $arguments = 1);

    /**
     * Add a new filter to the hook system.
     *
     * @param string $tag The tag name of the filter.
     * @param callable $callback The callback function to execute when the filter is applied.
     * @param int $priority The priority of the filter. Default is 20.
     * @param int $arguments The number of arguments accepted by the filter. Default is 1.
     *
     * @return void
     */

    // public function addFilter($tag, $callback, $priority = 20, $arguments = 1);

    /**
     * Apply filters to a value.
     * 
     * @param string $tag The name of the filter.
     * @param mixed $value The value to filter.
     * @param mixed $args Additional arguments to pass to the filter.
     * 
     * @return mixed
     */

    // public function applyFilters(string $tag, mixed $value, ...$args): mixed;

    /**
     * Add admin menu.
     * 
     * @param string $title The title of the menu.
     * @param string $slug The slug of the menu.
     * @param array $args The arguments of the menu.
     * - string icon The icon of the menu.
     * - string parent The parent menu slug.
     * - int position The position of the menu.
     * 
     * @return void
     */

    public function addAdminMenu(string $title, string $slug, array $args = []): void;
}
