<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::post('admin/admin-login',[AdminController::class , 'admin_login']);

Route::middleware(['auth:sanctum'])->group(function () {

Route::put('admin/block/{user}',[AdminController::class , 'blockUser']);
Route::post('admin/create-user',[AdminController::class , 'createUser']);


});



