<?php

namespace Modules\Core\Supports;

use Modules\Core\Facades\HookAction;

class MenuAction
{
    public function getAllMenus()
    {
        return $this->allMenus();
    }

    public function allMenus()
    {
        /* The `HookAction::addAdminMenu()` method is being called to add a menu item to the admin menu.
       Here's what each parameter represents: */
        HookAction::addAdminMenu(
            trans('cms::app.dashboard'),
            'dashboard',
            [
                'icon' => 'fa fa-dashboard',
                'position' => 1,
            ]
        );


        // HookAction::addAdminMenu('Dashboard', 'dashboard', [
        //     'icon' => 'fa fa-tachometer-alt',
        //     'position' => 10,
        //     'permission' => '[admin]',
        //     'url' => 'dashboard',
        //     'turbolinks' => true,
        // ]);

        // HookAction::addAdminMenu('Users', 'users', [
        //     'icon' => 'fa fa-users',
        //     'position' => 30,
        //     'permission' => '[admin]',
        //     'url' => 'users',
        //     'turbolinks' => true,
        // ]);
    }
}