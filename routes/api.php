<?php

use App\Http\Controllers\Product\BrandController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\RateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require_once __DIR__ . '/Api/auth.php';

route::apiResource('products', ProductController::class);
route::apiResource('categories', CategoryController::class);
route::apiResource('brands', BrandController::class);
route::apiResource('rates', RateController::class);
