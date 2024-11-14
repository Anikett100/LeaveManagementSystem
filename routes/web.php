<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear', function () {
    $exitCode = Artisan::call('optimize');
    return "cache cleared";
});

Route::post('/login', [AuthController::class, 'login']);



