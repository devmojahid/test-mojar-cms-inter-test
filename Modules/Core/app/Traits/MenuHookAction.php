<?php

namespace Modules\Core\Traits;

use Modules\Core\Facades\GlobalData;

trait MenuHookAction
{

    // public function addAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void
    // {
    //     $admin_menu =  GlobalData::get('admin_menu', []);

    //     // $admin_menu[] = [
    //     //     'title' =>  $menuTitle,
    //     //     'slug' => $menuSlug,
    //     //     'args' => $args
    //     // ];

    //     // GlobalData::set('admin_menu', $admin_menu);

    // }

    public function addAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void
    {
        $adminMenu = GlobalData::get('admin_menu', []);
        // $adminMenu[] = ['title' => $menuTitle, 'slug' => $menuSlug, 'args' => $args];
        $adminMenu[] = ['title' => $menuTitle, 'slug' => $menuSlug, 'args' => $args];
        GlobalData::set('admin_menu', $adminMenu);

        // Optionally output the updated admin menu for debugging
        // dd($adminMenu);
    }
}
