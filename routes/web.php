<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// Các Route Demo
// ==========================================
Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id?}', [DemoController::class, 'index5']);
Route::get('/demo6/{parram1}/{parram2}', [DemoController::class, 'index6']);

Route::get('test1', [ProductController::class, 'test1']);
Route::get('test2', [ProductController::class, 'test2']);

// ==========================================
// Cấu hình các Route Quản trị Admin (Lab 06 & Lab 07)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Authentication
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
    Route::post('/forgotpass', [AuthController::class, 'postForgotPassword'])->name('forgotpass.post');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        // Change password
        Route::get('/changepass', [AuthController::class, 'changePassword'])->name('changepass');
        Route::post('/changepass', [AuthController::class, 'postChangePassword'])->name('changepass.post');

        // Redirect /admin to /admin/dashboard
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD - Resource route
        Route::middleware('roles:1')->group(function () {
            // Trash routes for Soft Delete (Categories)
            Route::get('trash/categories', [CategoryController::class, 'trash'])->name('categories.trash');
            Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
            Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
            
            Route::resource('categories', CategoryController::class);
            Route::resource('brands', BrandController::class);
            
            // Custom route for deleting sub images
            Route::delete('products/delete-image/{id}', [ProductController::class, 'deleteImage']);
            Route::resource('products', ProductController::class)->except(['index']);
            Route::resource('users', UserController::class);
            Route::resource('posts', PostController::class);
        });
        
        // Allowed for both Admin (1) and Staff (2)
        Route::resource('products', ProductController::class)->only(['index'])->middleware('roles:1,2');
    });
});
