<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Shop routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Email Verification
    Route::get('/verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart-clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/{order}/upload-proof', [CheckoutController::class, 'uploadProof'])->name('checkout.uploadProof');
    
    // Order history
    Route::get('/orders', [CheckoutController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [CheckoutController::class, 'orderDetail'])->name('orders.detail');

    // Profile (pelanggan) - edit data diri sendiri
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('admin')
        ->name('dashboard');
    
    // Product management
    Route::resource('products', ProductController::class)
        ->middleware('admin');

    // User management (pelanggan) - admin hanya bisa lihat dan hapus
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
        ->only(['index','destroy'])
        ->middleware('admin');
    
    // Order management
    Route::get('/orders', [OrderController::class, 'index'])
        ->middleware('admin')
        ->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->middleware('admin')
        ->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->middleware('admin')
        ->name('orders.updateStatus');
    Route::put('/orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])
        ->middleware('admin')
        ->name('orders.updatePaymentStatus');
    Route::put('/orders/{order}/shipment', [OrderController::class, 'updateShipment'])
        ->middleware('admin')
        ->name('orders.updateShipment');
});
