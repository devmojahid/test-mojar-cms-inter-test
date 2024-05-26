<?php

use Illuminate\Support\Facades\Route;
use Modules\Backend\Http\Controllers\{
    BackendController,
    MenuController,
    PageController,
    Plugins\PluginController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('backend', BackendController::class)->names('backend');
});

Route::group(['prefix' => 'admin/plugins'], function () {
    Route::get('/', [PluginController::class, 'index'])->name('admin.plugins.index');
    Route::post('/actiate', [PluginController::class, 'activate'])->name('backend.plugin.activate');
    Route::post('/deactivate', [PluginController::class, 'deactivate'])->name('backend.plugin.deactivate');
});


Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('backend::dashboard');
    })->name('admin.dashboard');

    Route::get("/menu", [MenuController::class, "index"])->name('admin.menu');

    Route::get("add-page", [PageController::class, "index"])->name('admin.add-page');

    Route::post("store-page", [PageController::class, "store"])->name('admin.store-page');
});
