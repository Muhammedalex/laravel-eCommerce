<?php

use App\Http\Controllers\Auth\ForgetPassController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('auth/register' , [RegisterController::class , 'register']);
Route::post('auth/confirm' , [RegisterController::class , 'confirm']);
Route::post('auth/forget-password' , [ForgetPassController::class , 'forgotPass']);
Route::post('auth/reset-password' , [ForgetPassController::class , 'resetPass']);
Route::post('auth/login' , [LoginController::class , 'login']);

//auth middleware

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [LoginController::class, 'logout']);
});





