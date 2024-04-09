<?php

use App\Http\Controllers\Cart\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
   Route::apiResource('shopping-cart',CartController::class);
});

//product 
