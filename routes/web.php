<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/portal', function () {
    return view('portal');
});
