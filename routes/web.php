<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as PublicProductController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');

Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [PublicProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// User Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected User Routes (Checkout, Orders)
Route::middleware('auth')->group(function () {
    Route::get('checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('checkout', [OrderController::class, 'store'])->name('checkout.store');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Profile Routes
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('orders', AdminOrderController::class);
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->only(['index', 'show', 'destroy']);
        Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class)->except(['show', 'edit', 'update']);
    });
});
