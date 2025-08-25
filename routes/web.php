<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TropeController;
use App\Http\Controllers\BookController as CustomerBookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Customer routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books', [CustomerBookController::class, 'index'])->name('books.index');
Route::get('/books/{book:slug}', [CustomerBookController::class, 'show'])->name('books.show');

// About page route
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Dashboard route - redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->hasRole('superadmin')) {
        return redirect()->route('superadmin.dashboard');
    } elseif ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    
    // For regular customers, redirect to home page
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Order history
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/orders/{order}', [ProfileController::class, 'showOrder'])->name('profile.orders.show');
});

// Cart and checkout routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Admin routes (requires admin or superadmin role)
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('books', BookController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('tropes', TropeController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('customers', CustomerController::class)->only(['index', 'show']);
});

// Superadmin routes (requires superadmin role)
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    
    // Admin management
    Route::resource('admins', App\Http\Controllers\SuperAdmin\AdminController::class);
    
    // System settings
    Route::get('/settings', [App\Http\Controllers\SuperAdmin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\SuperAdmin\SettingController::class, 'update'])->name('settings.update');
    
    // Role and permission management
    Route::resource('roles', App\Http\Controllers\SuperAdmin\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\SuperAdmin\PermissionController::class);
});

// Authentication routes
require __DIR__.'/auth.php';