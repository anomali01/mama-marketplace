<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ValidatorController;
use App\Http\Controllers\CheckoutController;

// --- ROUTE BUATAN KITA (PRIORITAS) ---

// 1. Halaman Landing
Route::get('/', function () {
    return view('auth.landing');
})->name('landing');

// 2. Home/Dashboard setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/trending', [HomeController::class, 'trending'])->name('trending');
    
    // Products
    Route::resource('products', ProductController::class);
    
    // Orders
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{order}/upload-payment', [OrderController::class, 'uploadPaymentProof'])->name('orders.upload-payment');
    Route::post('/orders/{order}/upload-delivery', [OrderController::class, 'uploadDeliveryProof'])->name('orders.upload-delivery');
    Route::post('/orders/{order}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
    Route::post('/orders/{order}/pack', [OrderController::class, 'packOrder'])->name('orders.pack');
    Route::post('/orders/{order}/ship', [OrderController::class, 'shipOrder'])->name('orders.ship');
    Route::post('/orders/{order}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');
    
    // Cart (placeholder)
    Route::get('/cart', function () {
        return view('cart.index');
    })->name('cart.index');
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Messages - Chat dengan penjual
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{seller}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{seller}/fetch', [App\Http\Controllers\MessageController::class, 'getMessages'])->name('messages.fetch');
    Route::get('/messages/unread/count', [App\Http\Controllers\MessageController::class, 'unreadCount'])->name('messages.unread');
    
    // Notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread/count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [App\Http\Controllers\NotificationController::class, 'recent'])->name('notifications.recent');
    Route::post('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/clear', [App\Http\Controllers\NotificationController::class, 'clearAll'])->name('notifications.clear');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profile Settings
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.settings.update');
    Route::patch('/profile/settings/password', [ProfileController::class, 'updatePassword'])->name('profile.settings.password');
    
    // Seller Routes
    Route::get('/seller/register', [SellerController::class, 'register'])->name('seller.register');
    Route::post('/seller/register', [SellerController::class, 'store'])->name('seller.store');
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    Route::get('/seller/products', [SellerController::class, 'products'])->name('seller.products');
    Route::get('/seller/edit-shop', [SellerController::class, 'editShop'])->name('seller.edit-shop');
    Route::patch('/seller/edit-shop', [SellerController::class, 'updateShop'])->name('seller.update-shop');

    // Withdrawal Routes (Seller)
    Route::get('/seller/withdrawals', [App\Http\Controllers\WithdrawalController::class, 'index'])->name('seller.withdrawals');
    Route::post('/seller/withdrawals', [App\Http\Controllers\WithdrawalController::class, 'store'])->name('seller.withdrawals.store');
    Route::post('/seller/withdrawals/{withdrawal}/confirm', [App\Http\Controllers\WithdrawalController::class, 'confirm'])->name('seller.withdrawals.confirm');
});

// Validator Routes
Route::middleware(['auth', 'validator'])->prefix('validator')->name('validator.')->group(function () {
    Route::get('/dashboard', [ValidatorController::class, 'dashboard'])->name('dashboard');
    
    // Products verification
    Route::get('/products/pending', [ValidatorController::class, 'pendingProducts'])->name('products.pending');
    Route::get('/products/verified', [ValidatorController::class, 'verifiedProducts'])->name('products.verified');
    Route::get('/products/rejected', [ValidatorController::class, 'rejectedProducts'])->name('products.rejected');
    Route::get('/products/{product}', [ValidatorController::class, 'showProduct'])->name('products.show');
    Route::patch('/products/{product}/approve', [ValidatorController::class, 'approveProduct'])->name('products.approve');
    Route::patch('/products/{product}/reject', [ValidatorController::class, 'rejectProduct'])->name('products.reject');
    
    // Sellers
    Route::get('/sellers', [ValidatorController::class, 'sellers'])->name('sellers.index');
    Route::get('/sellers/{seller}', [ValidatorController::class, 'showSeller'])->name('sellers.show');
    Route::post('/sellers/{seller}/verify', [ValidatorController::class, 'verifySeller'])->name('sellers.verify');

    // Orders - Payment Confirmation
    Route::get('/orders', [ValidatorController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [ValidatorController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{order}/confirm-payment', [ValidatorController::class, 'confirmPayment'])->name('orders.confirm-payment');

    // Withdrawal Requests (Validator)
    Route::get('/withdrawals', [App\Http\Controllers\WithdrawalController::class, 'validatorIndex'])->name('withdrawals');
    Route::get('/withdrawals/{withdrawal}', [App\Http\Controllers\WithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('/withdrawals/{withdrawal}/process', [App\Http\Controllers\WithdrawalController::class, 'process'])->name('withdrawals.process');
    Route::post('/withdrawals/{withdrawal}/upload-proof', [App\Http\Controllers\WithdrawalController::class, 'uploadProof'])->name('withdrawals.upload-proof');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/validators', [App\Http\Controllers\AdminController::class, 'validators'])->name('validators');
    Route::post('/validators/{validator}/approve', [App\Http\Controllers\AdminController::class, 'approveValidator'])->name('validators.approve');
    Route::delete('/validators/{validator}/reject', [App\Http\Controllers\AdminController::class, 'rejectValidator'])->name('validators.reject');
});

// Route Testing (Pintu Belakang)
Route::get('/cek-mama', function () {
    return view('auth.login');
});

// Include auth routes dari Laravel Breeze (login, register, logout, dll)
require __DIR__.'/auth.php';
