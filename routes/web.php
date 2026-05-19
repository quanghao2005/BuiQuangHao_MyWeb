<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('admin/category', CategoryController::class);
Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id?}', [DemoController::class, 'index5']);
Route::get('/demo6/{parram1}/{parram2}', [DemoController::class, 'index6']);
Route::resource('admin/brand', BrandController::class);
Route::resource('admin/product', ProductController::class);
Route::resource('admin/user', UserController::class);
Route::resource('admin/post', PostController::class);
