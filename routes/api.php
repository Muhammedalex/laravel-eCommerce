<?php

use App\Http\Controllers\Product\BrandController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ColorController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\RateController;
use App\Http\Controllers\Product\SizeController;
use App\Http\Controllers\Product\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require_once __DIR__ . '/Api/auth.php';
require_once __DIR__ . '/Api/user.php';


route::apiResource('products', ProductController::class);
route::apiResource('categories', CategoryController::class);
route::apiResource('brands', BrandController::class);
route::apiResource('colors', ColorController::class);
route::apiResource('sizes', SizeController::class);
route::apiResource('tags', TagController::class);
route::apiResource('rates', RateController::class);
Route::middleware(['auth:sanctum'])->group(function () {
    route::apiResource('rates', RateController::class);
});