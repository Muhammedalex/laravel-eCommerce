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
require_once __DIR__ . '/Api/cart.php';

Route::middleware(['auth:sanctum'])->group(function () {
    route::apiResource('categories', CategoryController::class);
    route::apiResource('brands', BrandController::class);
    route::apiResource('colors', ColorController::class);
    route::apiResource('sizes', SizeController::class);
    route::apiResource('tags', TagController::class);
    route::apiResource('rates', RateController::class);
    route::prefix('products')->controller(ProductController::class)->group(function () {
        route::post('/', 'store');
        route::put('{product}', 'update');
        route::delete('{product}', 'destroy');
    });
    // route::apiResource('products',ProductController::class);
});



route::prefix('products')->controller(ProductController::class)->group(function () {
    route::get('/', 'index');
    route::get('{product}', 'show');
});
