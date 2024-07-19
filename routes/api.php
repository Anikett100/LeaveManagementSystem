<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::middleware(['SecureApi'])->group(function () {
  
// });

Route::post('login', [AuthController::class, 'login']);

Route::group(['prefix'=> 'auth'],function($router){  
 Route::post('register', [AuthController::class, 'register']);

});

Route::middleware(['auth:api'])->group(function () {
   
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


Route::post('/add-leave',[UserController::class,'AddLeave']);
Route::get('/get-leave',[UserController::class,'getLeave']);
Route::delete('/delete-leave/{id}',[UserController::class,'deleteLeave']);
Route::post('update-leave/{id}', [UserController::class, 'updateLeave']);
