<?php

namespace Modules\Backend\Http\Controllers\Plugins;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Facades\Plugin;

class PluginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $plugins = Plugin::all();
        $count = Plugin::count();
        return view('backend::index', compact('plugins', 'count'));
    }

    /**
     * Activate the plugin. 
     * 
     */

    public function activate(Request $request)
    {
        $pluginName = $request->get('plugin');
        Plugin::enable($pluginName);
        $plugin = Plugin::find($pluginName);
        return redirect()->back();
    }

    /**
     * Deactivate the plugin.
     */

    public function deactivate(Request $request)
    {
        $pluginName = $request->get('plugin');
        Plugin::disable($pluginName);
        $plugin = Plugin::find($pluginName);
        return redirect()->back();
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
}