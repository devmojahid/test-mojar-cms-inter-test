<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Facades\GlobalData;
use Modules\Core\Supports\MenuAction;
use Modules\Core\Traits\MenuHookAction;

class MenuController extends Controller
{
    // use MenuHookAction;

    public function __construct(MenuAction $menuAction)
    {
        $menuAction->getAllMenus();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menuData = GlobalData::get('admin_menu');
        dd($menuData);
        return view('backend::menu', compact('menuData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('backend::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('backend::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function menu_builder_sidebar()
    {
        echo e(
            view('backend::menu.menu-builder-sidebar', [
                'menus' => apply_filter('menu_builder_sidebar_menus', [])
            ])
        );
    }
}