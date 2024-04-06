<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/users', UserController::class)->except('update');
    Route::post('users/{user}',[UserController::class , 'update']);
});