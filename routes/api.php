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
Route::post('/add-leave',[UserController::class,'AddLeave']);
Route::middleware('auth:api')->get('/get-leave', [UserController::class,'getLeave']);
// for sandwich leave
Route::middleware('auth:api')->get('/get-leaves', [UserController::class,'getLeaves']);
Route::delete('/delete-leave/{id}',[UserController::class,'deleteLeave']);
Route::post('update-leave/{id}', [UserController::class, 'updateLeave']);
// for all pages
Route::get('leave-details/{id}', [UserController::class, 'leaveDetails']);
// for update
Route::get('/get-userleave/{id}', [UserController::class, 'getUserLeave']);
Route::get('/get-user',[UserController::class,'getUser']);
Route::get('/get-adminleaves',[AdminController::class,'getAdminLeave']);
Route::post('/update-leavestatus/{id}', [AdminController::class, 'updateLeaveStatus']);
Route::post('/add-holiday',[AdminController::class,'addHoliday']);
Route::get('/get-holiday',[AdminController::class,'getHoliday']);
Route::delete('/delete-holiday/{id}',[AdminController::class,'deleteHoliday']);
Route::post('/update-holiday/{id}',[AdminController::class,'updateHoliday']);
Route::get('/holidays-events',[AdminController::class,'getHolidaysAndEvents']);
Route::get('/attendance',[AdminController::class,'attendance']);

Route::get('/managerleave-request',[ManagerController::class,'ManagerLeaveRequests']);
Route::post('/update-status/{id}', [ManagerController::class, 'updateStatus']);
Route::get('leaverequest-details/{id}', [ManagerController::class, 'leaveRequestDetails']);
Route::post('/add-managerleave',[ManagerController::class,'AddManagerLeave']);
Route::get('/get-managerleaves', [ManagerController::class, 'getManagerLeave']);
Route::delete('/delete-managerleave/{id}', [ManagerController::class, 'deleteManagerLeave']);
Route::get('/get-sandwichleave',[ManagerController::class,'getSandwichLeaves']);
Route::get('/get-updateleave/{id}',[ManagerController::class,'getManagerUpdateLeave']);
Route::post('/update-managerleave/{id}',[ManagerController::class,'updateManagerLeave']);
Route::get('/manager-attendance',[ManagerController::class,'Managerattendance']);





