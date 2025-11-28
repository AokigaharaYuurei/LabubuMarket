<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Продукты
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/card/{id}', [ProductController::class, 'card'])->name('products.card');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

    // Корзина
    Route::get('/cart', [CartController::class, 'index'])->name('basket.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Заказы
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/success/{orderId}', [OrderController::class, 'success'])->name('order.success');

    // Админка заказов
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::patch('/admin/orders/{orderId}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

    
});

require __DIR__.'/auth.php';