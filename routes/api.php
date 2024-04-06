<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require_once __DIR__ . '/Api/auth.php';
require_once __DIR__ . '/Api/user.php';


route::apiResource('products', ProductController::class);
