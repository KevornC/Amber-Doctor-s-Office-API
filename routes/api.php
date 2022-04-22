<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//System Check

Route::get('/system/status',[App\Http\Controllers\SystemCheckController::class,'systemStatus']);

//Guest Appointment

Route::post('/set/appointment',[App\Http\Controllers\VisitorsController::class,'setAppointment']);

//Modify Password
Route::get('/forgot/password/{email}',[App\Http\Controllers\UserController::class,'resetPassword']);
Route::post('/update/password',[App\Http\Controllers\UserController::class,'updatePassword']);


//Login
Route::post('/login',[App\Http\Controllers\LoginController::class,'login'])->name('login');


Route::group(['middleware'=>['auth:sanctum']],function(){
    //Staff Check

Route::get('/staff/status/{id}',[App\Http\Controllers\UserController::class,'staffCheck']);

    //Doctor - Dashboard

Route::get('/doctor/dashboard',[\App\Http\Controllers\DoctorController::class, 'dashboard']);
Route::get('/edit/appointment/{id}',[\App\Http\Controllers\DoctorController::class, 'editAppointment']);
Route::post('/update/appointment/{id}/{id2}',[\App\Http\Controllers\DoctorController::class, 'updateAppointment']);
Route::get('/appointment/search/{id}',[\App\Http\Controllers\UserController::class, 'searchAppointment']);
Route::post('/update/status',[\App\Http\Controllers\UserController::class, 'updateStatus']);

//All Appointments

Route::get('/all/appointments',[\App\Http\Controllers\UserController::class, 'allAppointments']);


//Doctor - Staff

Route::get('/staff/show',[\App\Http\Controllers\DoctorController::class, 'index']);
Route::post('/staff/create',[\App\Http\Controllers\DoctorController::class, 'store']);
Route::get('/staff/edit/{id}',[\App\Http\Controllers\DoctorController::class, 'edit']);
Route::post('/staff/update/{id}',[\App\Http\Controllers\DoctorController::class, 'update']);
Route::get('/staff/disable/{id}',[\App\Http\Controllers\DoctorController::class, 'disable']);
Route::get('/staff/enable/{id}',[\App\Http\Controllers\DoctorController::class, 'enable']);
Route::get('/staff/update/password/{id}',[\App\Http\Controllers\DoctorController::class, 'updatePassword']);
Route::get('/staff/search/{id}',[\App\Http\Controllers\DoctorController::class, 'search']);


Route::get('/logout',[\App\Http\Controllers\LoginController::class, 'logout']);

});
