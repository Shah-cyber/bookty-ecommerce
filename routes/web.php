<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TropeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\PostageRateController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\SettingController;
use App\Http\Controllers\ToyyibPayController;
use App\Http\Controllers\SuperAdmin\PermissionController;
use App\Http\Controllers\BookController as CustomerBookController;

// Customer routes
Route::get('/', [HomeController::class, 'index'])->name('home');
// Recommendation endpoints (JSON responses)
Route::middleware(['auth'])->group(function () {
    Route::get('/api/recommendations/me', [\App\Http\Controllers\Api\RecommendationController::class, 'forUser'])
        ->name('api.recommendations.me');
});

Route::get('/api/recommendations/similar/{book}', [\App\Http\Controllers\Api\RecommendationController::class, 'similarToBook'])
    ->name('api.recommendations.similar');
Route::get('/books', [CustomerBookController::class, 'index'])->name('books.index');
Route::get('/books/{book:slug}', [CustomerBookController::class, 'show'])->name('books.show');
Route::get('/books/{book:slug}/reviews', [CustomerBookController::class, 'reviews'])->name('books.reviews');

// About page route
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Contact page route
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Social Login Routes
Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

// Dashboard route - redirect based on role
Route::get('/dashboard', function () {
    // For simplicity, we'll use the CheckRole middleware logic
    // This is already applied in the routes below
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
    Route::get('/profile/orders/{order}/invoice', [ProfileController::class, 'invoice'])->name('profile.orders.invoice');
    Route::get('/profile/orders/{order}/invoice/pdf', [ProfileController::class, 'invoicePdf'])->name('profile.orders.invoice.pdf');
});

// Cart and checkout routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/quick-add/{book}', [CartController::class, 'quickAdd'])->name('cart.quick-add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    
    // Book reviews
    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('books.reviews.store');
    
    // Review helpful votes and reports
    Route::post('/reviews/{review}/helpful', [ReviewController::class, 'toggleHelpful'])->name('reviews.helpful');
    Route::post('/reviews/{review}/report', [ReviewController::class, 'report'])->name('reviews.report');
    
    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{book}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{book}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/toggle/{book}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
    
    // Track user interactions for recommendations
    Route::post('/api/track-interaction', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
            'action' => 'required|string|in:view,click,wishlist,cart,purchase'
        ]);
        
        \App\Models\UserBookInteraction::record(
            Auth::id(),
            $request->book_id,
            $request->action
        );
        
        return response()->json(['success' => true]);
    })->name('api.track-interaction');
});

// Admin routes (requires admin or superadmin role)
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('books', BookController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('tropes', TropeController::class);
    Route::resource('orders', OrderController::class);
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('orders/{order}/invoice/pdf', [OrderController::class, 'invoicePdf'])->name('orders.invoice.pdf');
    Route::resource('customers', CustomerController::class)->only(['index', 'show']);
    
    // Discount management
    Route::resource('discounts', App\Http\Controllers\Admin\BookDiscountController::class);
    Route::post('discounts/{discount}/toggle', [App\Http\Controllers\Admin\BookDiscountController::class, 'toggleActive'])->name('discounts.toggle');
    
    // Coupon management
    Route::resource('coupons', App\Http\Controllers\Admin\CouponController::class);
    Route::post('coupons/{coupon}/toggle', [App\Http\Controllers\Admin\CouponController::class, 'toggleActive'])->name('coupons.toggle');
    Route::get('coupons/generate-code', [App\Http\Controllers\Admin\CouponController::class, 'generateCode'])->name('coupons.generate-code');
    
    // Flash sale management
    Route::resource('flash-sales', App\Http\Controllers\Admin\FlashSaleController::class);
    Route::post('flash-sales/{flash_sale}/toggle', [App\Http\Controllers\Admin\FlashSaleController::class, 'toggleActive'])->name('flash-sales.toggle');
    Route::post('flash-sales/books-by-genre', [App\Http\Controllers\Admin\FlashSaleController::class, 'getBooksByGenre'])->name('flash-sales.books-by-genre');

    // Dashboard data endpoints
    Route::get('top-selling', [DashboardController::class, 'getTopSellingBooksData'])->name('top-selling');
    Route::get('sales-this-period', [DashboardController::class, 'getSalesThisPeriodData'])->name('sales-this-period');
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('index');
        Route::get('/sales', [App\Http\Controllers\Admin\ReportsController::class, 'sales'])->name('sales');
        Route::get('/customers', [App\Http\Controllers\Admin\ReportsController::class, 'customers'])->name('customers');
        Route::get('/inventory', [App\Http\Controllers\Admin\ReportsController::class, 'inventory'])->name('inventory');
        Route::get('/promotions', [App\Http\Controllers\Admin\ReportsController::class, 'promotions'])->name('promotions');
        Route::get('/shipping', [App\Http\Controllers\Admin\ReportsController::class, 'shipping'])->name('shipping');
        Route::get('/profitability', [App\Http\Controllers\Admin\ReportsController::class, 'profitability'])->name('profitability');
        
        // Export routes
        Route::get('/export/sales', [App\Http\Controllers\Admin\ReportsController::class, 'exportSales'])->name('export.sales');
        Route::get('/export/customers', [App\Http\Controllers\Admin\ReportsController::class, 'exportCustomers'])->name('export.customers');
        Route::get('/export/profitability', [App\Http\Controllers\Admin\ReportsController::class, 'exportProfitability'])->name('export.profitability');
    });

    // Review reports management
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/reports', [App\Http\Controllers\Admin\ReviewReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [App\Http\Controllers\Admin\ReviewReportController::class, 'show'])->name('reports.show');
        Route::patch('/reports/{report}/status', [App\Http\Controllers\Admin\ReviewReportController::class, 'updateStatus'])->name('reports.status');
        
        // Review helpful analytics
        Route::get('/helpful', [App\Http\Controllers\Admin\ReviewHelpfulController::class, 'index'])->name('helpful.index');
    });

    // Admin settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/system', [SettingsController::class, 'system'])->name('system');
    });

    // Postage Rates management
    Route::prefix('postage-rates')->name('postage-rates.')->group(function () {
        Route::get('/history/all', [PostageRateController::class, 'allHistory'])->name('all-history');
        Route::get('/history/{region}', [PostageRateController::class, 'history'])->name('history');
        Route::get('/verify-integrity', [PostageRateController::class, 'verifyIntegrity'])->name('verify-integrity');
    });
    Route::resource('postage-rates', PostageRateController::class)->except(['show']);
    
    // Recommendation Analytics
    Route::prefix('recommendations')->name('recommendations.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\RecommendationAnalyticsController::class, 'index'])->name('index');
        Route::get('/settings', [\App\Http\Controllers\Admin\RecommendationAnalyticsController::class, 'settings'])->name('settings');
        Route::post('/settings', [\App\Http\Controllers\Admin\RecommendationAnalyticsController::class, 'updateSettings'])->name('settings.update');
        Route::get('/user/{user}', [\App\Http\Controllers\Admin\RecommendationAnalyticsController::class, 'userDetails'])->name('user.details');
    });
});

// Superadmin routes (requires superadmin role)
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    
    // Real-time dashboard API endpoints
    Route::get('/api/stats', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'getRealtimeStats'])->name('api.stats');
    Route::get('/api/user-registrations', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'getRealtimeUserRegistrations'])->name('api.user-registrations');
    Route::get('/api/recent-users', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'getRecentUsers'])->name('api.recent-users');
    Route::get('/api/system-health', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'getSystemHealth'])->name('api.system-health');
    
    // Admin management
    Route::resource('admins', App\Http\Controllers\SuperAdmin\AdminController::class);
    
    // System settings
    Route::get('/settings', [App\Http\Controllers\SuperAdmin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\SuperAdmin\SettingController::class, 'update'])->name('settings.update');
    
    // Role and permission management
    Route::resource('roles', App\Http\Controllers\SuperAdmin\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\SuperAdmin\PermissionController::class);
});

// API routes
Route::prefix('api')->middleware('auth')->group(function () {
    Route::post('/coupons/validate', [App\Http\Controllers\Api\CouponController::class, 'validate'])->name('api.coupons.validate');
    Route::post('/postage/rate', [App\Http\Controllers\Api\PostageController::class, 'rate'])->name('api.postage.rate');
});

// ToyyibPay routes (no auth required for callbacks)
Route::prefix('toyyibpay')->name('toyyibpay.')->group(function () {
    Route::post('/callback', [ToyyibPayController::class, 'callback'])->name('callback');
    Route::get('/return', [ToyyibPayController::class, 'return'])->name('return');
    Route::get('/check-status/{order}', [ToyyibPayController::class, 'checkStatus'])->name('check-status')->middleware('auth');
});

// Authentication routes
require __DIR__.'/auth.php';