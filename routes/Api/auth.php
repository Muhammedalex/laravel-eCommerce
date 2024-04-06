<?php

use App\Http\Controllers\Auth\ForgetPassController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('auth/register' , [RegisterController::class , 'register']);
Route::post('auth/confirm' , [RegisterController::class , 'confirm']);
Route::post('auth/forget-password' , [ForgetPassController::class , 'forgotPass']);
Route::post('auth/reset-password' , [ForgetPassController::class , 'resetPass']);





