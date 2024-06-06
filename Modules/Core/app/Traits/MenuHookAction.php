<?php

namespace Modules\Core\Traits;

use Modules\Core\Facades\GlobalData;

trait MenuHookAction
{

    public function addAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void
    {
        $admin_menu =  GlobalData::get('admin_menu', []);

        // $admin_menu[] = [
        //     'title' =>  $menuTitle,
        //     'slug' => $menuSlug,
        //     'args' => $args
        // ];

        // GlobalData::set('admin_menu', $admin_menu);

        $admin_menu[] = [
            'title' =>  "Dashboard",
            'slug' => "dashboard",
            'args' => [
                'icon' => 'fa fa-dashboard',
                'route' => 'dashboard',
                'permission' => 'view-dashboard',
                'order' => 1
            ]
        ];

        $admin_menu[] = [
            'title' =>  "Menu",
            'slug' => "menu",
            'args' => [
                'icon' => 'fa fa-bars',
                'route' => 'menu',
                'permission' => 'view-menu',
                'order' => 2
            ]
        ];
    }
}
