<?php

use Illuminate\Routing\Route;

Route::get('test', function () {
    return 'Hello from the blog plugin';
})->name('admin.test');
