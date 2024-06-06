<?php

/**
 * Mojar CMS - A Laravel CMS with Content Management Features
 * 
 * @package  mojahid/mojar 
 * @author Mojahid <raofahmedmojahid@gmail.com>
 * @version 1.0.0
 * @link https://github.com/devmojahid
 */

namespace Modules\Backend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Facades\GlobalData;
use Modules\Core\Traits\MenuHookAction;

class BackendController extends Controller
{
    use MenuHookAction;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->addAdminMenu('Dashboard', 'admin.dashboard');
        dd(GlobalData::all());
        return view('backend::dashboard');
        // return view('backend::index');
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
    public function store(Request $request): RedirectResponse
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
    public function update(Request $request, $id): RedirectResponse
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
}
