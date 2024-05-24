<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    add_filter("the_title", function ($title, $id = null) {
        // return "Hello, $title";
        return ucwords("hello, $title <br> $id");
    });

    add_action("hello_mojahid_echo", function () {
        echo "Hello, Mojahid 2";
    });

    return view('backend::show');
});
