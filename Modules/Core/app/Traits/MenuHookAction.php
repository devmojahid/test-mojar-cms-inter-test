<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Arr;
use Modules\Core\Facades\GlobalData;
use Illuminate\Support\Str;


trait MenuHookAction
{

    public function addAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void
    {
        $adminMenu = $this->globalData->get('admin_menu');

        $opts = [
            'title' => $menuTitle,
            'key' => $menuSlug,
            'icon' => 'fa fa-list-ul',
            'parent' => null,
            'position' => 20,
            'permission' => '[admin]',
            'slug' => Str::replace('.', '-', strtolower($menuSlug)),
            'url' => Str::replace('.', '/', strtolower($menuSlug)),
            'turbolinks' => true,
        ];

        $item = array_merge($opts, $args);

        if ($item['parent']) {
            $adminMenu[$item['parent']]['children'][$item['key']] = $item;
        } else {
            if (Arr::has($adminMenu, $item['key'])) {
                if (Arr::has($adminMenu[$item['key']], 'children')) {
                    $adminMenu[$item['key']]['children'][$item['key']] = $item;
                }
                $adminMenu[$item['key']] = $item;
            } else {
                $adminMenu[$item['key']] = $item;
            }
        }

        $this->globalData->set('admin_menu', $adminMenu);
    }
}