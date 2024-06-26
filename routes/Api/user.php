<?php

use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\CouponController;
use App\Http\Controllers\User\PhoneController;
use App\Http\Controllers\User\UserController;
use App\Models\Coupon;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/users', UserController::class)->except('update');
    Route::post('users/{user}',[UserController::class , 'update']);
    Route::apiResource('coupons', CouponController::class);
    Route::apiResource('phones', PhoneController::class);
    Route::apiResource('addresses', AddressController::class);


});

//product 
