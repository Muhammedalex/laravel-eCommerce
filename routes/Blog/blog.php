<?php

use App\Http\Controllers\Blog\BlogCategoryController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\BlogLikeController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('blog_categories', BlogCategoryController::class);
    // Route::post('blog_likes', [BlogLikeController::class, 'like']);
});


Route::apiResource('blogs', BlogController::class);
Route::post('blog_likes', [BlogLikeController::class, 'like']);
