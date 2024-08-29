<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;



 Route::post('login', [AuthController::class, 'login']);
Route::group(['prefix'=> 'auth'],function($router){  
Route::post('register', [AuthController::class, 'register']);

});

Route::middleware(['auth:api'])->group(function () {
   
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});



// uer
Route::post('/add-leave',[UserController::class,'AddLeave']);
Route::middleware('auth:api')->get('/get-leave', [UserController::class,'getLeave']);
// for sandwich leave
Route::middleware('auth:api')->get('/get-leaves', [UserController::class,'getLeaves']);
Route::delete('/delete-leave/{id}',[UserController::class,'deleteLeave']);
Route::post('update-leave/{id}', [UserController::class, 'updateLeave']);
Route::get('leave-details/{id}', [UserController::class, 'leaveDetails']);
// for update
Route::get('/get-userleave/{id}', [UserController::class, 'getUserLeave']);
Route::get('/get-user',[UserController::class,'getUser']);
// Route::get('/paidleaves/{id}',[UserController::class,'calculateCarryForwardLeaves']);



Route::post('/add-managerleave',[ManagerController::class,'AddManagerLeave']);
Route::get('/get-managerleave',[ManagerController::class,'getManagerLeave']);
Route::delete('/delete-managerleave/{id}',[ManagerController::class,'deleteManagerLeave']);
Route::post('update-managerleave/{id}', [ManagerController::class, 'updateManagerLeave']);

// admin 
Route::get('/get-adminleaves',[AdminController::class,'getAdminLeave']);
Route::post('/update-leavestatus/{id}', [AdminController::class, 'updateLeaveStatus']);
Route::post('/add-holiday',[AdminController::class,'addHoliday']);
Route::get('/get-holiday',[AdminController::class,'getHoliday']);
Route::delete('/delete-holiday/{id}',[AdminController::class,'deleteHoliday']);
Route::post('/update-holiday/{id}',[AdminController::class,'updateHoliday']);
Route::get('/holidays-events',[AdminController::class,'getHolidaysAndEvents']);
Route::get('/attendance',[AdminController::class,'attendance']);




