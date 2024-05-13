<?php

Route::get('test', function () {
    return 'Hello from the blog plugin';
})->name('admin.test');

Route::get("zahid", function () {
    return "Hello from Zahid";
})->name('admin.zahid');