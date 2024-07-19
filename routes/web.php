<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear', function () {
    $exitCode = Artisan::call('optimize');
    return "cache cleared";
});
