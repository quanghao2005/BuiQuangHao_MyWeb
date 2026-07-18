<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;

// ==========================================
// Cấu hình các Route giao diện Client
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Sản phẩm
Route::get('/san-pham', [ClientProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ClientProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ClientProductController::class, 'category'])->name('products.category');
Route::get('/brand/{slug}', [ClientProductController::class, 'brand'])->name('products.brand');
Route::get('/search', [ClientProductController::class, 'search'])->name('products.search');
Route::get('/ajax-search', [ClientProductController::class, 'ajaxSearch'])->name('products.ajaxSearch');

// Bài viết
Route::get('/posts', [\App\Http\Controllers\Client\PostController::class, 'index'])->name('client.posts.index');
Route::get('/posts/{slug}', [\App\Http\Controllers\Client\PostController::class, 'show'])->name('client.posts.show');

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/update-ajax', [CartController::class, 'updateAjax'])->name('cart.update_ajax');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::match(['get', 'post'], '/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [CartController::class, 'placeOrder'])->name('checkout.post');
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
// Authentication Routes (Global)
// ==========================================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('register.post');
Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])->name('forgotpass');
Route::post('/forgotpass', [AuthController::class, 'postForgotPassword'])->name('forgotpass.post');
Route::get('/forgotpass/otp', [AuthController::class, 'otpForm'])->name('forgotpass.otp');
Route::post('/forgotpass/otp', [AuthController::class, 'postOtp'])->name('forgotpass.otp.post');
Route::get('/forgotpass/reset', [AuthController::class, 'resetPasswordForm'])->name('forgotpass.reset');
Route::post('/forgotpass/reset', [AuthController::class, 'postResetPassword'])->name('forgotpass.reset.post');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/changepass', [AuthController::class, 'changePassword'])->name('changepass');
    Route::post('/changepass', [AuthController::class, 'postChangePassword'])->name('changepass.post');

    // Profile (Thông tin khách hàng)
    Route::get('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/orders', [\App\Http\Controllers\Client\ProfileController::class, 'orders'])->name('profile.orders');
    Route::post('/profile/update', [\App\Http\Controllers\Client\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [\App\Http\Controllers\Client\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/profile/change-password', [\App\Http\Controllers\Client\ProfileController::class, 'updatePassword'])->name('profile.change_password');
});

// ==========================================
// Cấu hình các Route Quản trị Admin (Lab 06 & Lab 07)
// ==========================================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    // Redirect /admin to /admin/dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

        // Dashboard & Global API
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
        Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart_data');
        Route::get('/sidebar-stats', [DashboardController::class, 'sidebarStats'])->name('sidebar_stats');

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
            
            // Orders
            Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
            Route::get('orders/{id}/modal', [OrderController::class, 'showModal']);
            Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
            Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

            // Banners
            Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
        });
        
        // Allowed for both Admin (1) and Staff (2)
        Route::resource('products', ProductController::class)->only(['index'])->middleware('roles:1,2');
    });
