<?php

use Illuminate\Support\Facades\Route;
use Modules\Backend\Http\Controllers\{
    BackendController,
    MenuController,
    PageController,
    Plugins\PluginController
};
use Modules\Backend\Http\Controllers\Auth\ForgotPasswordController;
use Modules\Backend\Http\Controllers\Auth\LoginController;
use Modules\Backend\Http\Controllers\Auth\RegisterController;
use Modules\Backend\Http\Controllers\Auth\ResetPasswordController;
use Modules\Backend\Http\Controllers\Auth\SocialLoginController;
use Modules\Core\Facades\GlobalData;

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
        // $menuData = GlobalData::all();
        // dd($menuData);

        return view('backend::dashboard');
    })->name('admin.dashboard');

    Route::get("/menu", [MenuController::class, "index"])->name('admin.menu');

    Route::get("add-page", [PageController::class, "index"])->name('admin.add-page');

    Route::post("store-page", [PageController::class, "store"])->name('admin.store-page');

    Route::get("login", [LoginController::class, "index"])->name('admin.login');
    Route::post("login", [LoginController::class, "store"])->name('admin.login');

    Route::get("register", [RegisterController::class, "index"])->name('admin.register');
    Route::post("register", [RegisterController::class, "store"])->name('admin.register');

    Route::get("forgot-password", [ForgotPasswordController::class, "index"])->name('admin.forgot-password');
    Route::post("/forgot-password", [ForgotPasswordController::class, "store"])->name('admin.forgot-password');
    Route::get("/reset-password/{email}/{token}", [ResetPasswordController::class, "resetPassword"])->name('admin.reset-password');
    Route::post("/reset-password/{email}/{token}", [ResetPasswordController::class, "reset"])->name('admin.reset-password');

    Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback'])->name('auth.social.callback');
    Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirectToProvider'])->name('auth.social.redirect');
});
