<?php

use Illuminate\Support\Facades\Route;
use Modules\Backend\Http\Controllers\{
    BackendController,
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
    Route::post('/actiate/{plugin}', [PluginController::class, 'activate'])->name('backend.plugin.activate');
});