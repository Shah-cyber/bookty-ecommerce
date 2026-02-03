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

// About page route
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Contact page routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

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
Route::middleware(['auth', 'role:admin|superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Book management - with permission checks
    Route::middleware(['permission:view books'])->group(function () {
        Route::get('books', [BookController::class, 'index'])->name('books.index');
        Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');
    });
    Route::middleware(['permission:create books'])->group(function () {
        Route::get('books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('books', [BookController::class, 'store'])->name('books.store');
    });
    Route::middleware(['permission:edit books'])->group(function () {
        Route::get('books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::patch('books/{book}', [BookController::class, 'update']);
    });
    Route::middleware(['permission:delete books'])->group(function () {
        Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });
    
    // Genre management - with permission checks
    Route::middleware(['permission:view genres'])->group(function () {
        Route::get('genres', [GenreController::class, 'index'])->name('genres.index');
        Route::get('genres/{genre}', [GenreController::class, 'show'])->name('genres.show');
    });
    Route::middleware(['permission:create genres'])->group(function () {
        Route::get('genres/create', [GenreController::class, 'create'])->name('genres.create');
        Route::post('genres', [GenreController::class, 'store'])->name('genres.store');
    });
    Route::middleware(['permission:edit genres'])->group(function () {
        Route::get('genres/{genre}/edit', [GenreController::class, 'edit'])->name('genres.edit');
        Route::put('genres/{genre}', [GenreController::class, 'update'])->name('genres.update');
        Route::patch('genres/{genre}', [GenreController::class, 'update']);
    });
    Route::middleware(['permission:delete genres'])->group(function () {
        Route::delete('genres/{genre}', [GenreController::class, 'destroy'])->name('genres.destroy');
    });
    
    // Trope management - with permission checks
    Route::middleware(['permission:view tropes'])->group(function () {
        Route::get('tropes', [TropeController::class, 'index'])->name('tropes.index');
        Route::get('tropes/{trope}', [TropeController::class, 'show'])->name('tropes.show');
    });
    Route::middleware(['permission:create tropes'])->group(function () {
        Route::get('tropes/create', [TropeController::class, 'create'])->name('tropes.create');
        Route::post('tropes', [TropeController::class, 'store'])->name('tropes.store');
    });
    Route::middleware(['permission:edit tropes'])->group(function () {
        Route::get('tropes/{trope}/edit', [TropeController::class, 'edit'])->name('tropes.edit');
        Route::put('tropes/{trope}', [TropeController::class, 'update'])->name('tropes.update');
        Route::patch('tropes/{trope}', [TropeController::class, 'update']);
    });
    Route::middleware(['permission:delete tropes'])->group(function () {
        Route::delete('tropes/{trope}', [TropeController::class, 'destroy'])->name('tropes.destroy');
    });
    
    // Order management - with permission checks
    Route::middleware(['permission:view orders'])->group(function () {
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('orders/{order}/invoice/pdf', [OrderController::class, 'invoicePdf'])->name('orders.invoice.pdf');
    });
    Route::middleware(['permission:manage orders'])->group(function () {
        Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::patch('orders/{order}', [OrderController::class, 'update']);
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });
    
    // Customer management - with permission checks
    Route::middleware(['permission:view customers'])->group(function () {
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    });
    
    // Discount management - with permission checks
    // IMPORTANT: Create routes must come BEFORE {discount} parameter routes
    Route::middleware(['permission:create discounts'])->group(function () {
        Route::get('discounts/create', [App\Http\Controllers\Admin\BookDiscountController::class, 'create'])->name('discounts.create');
        Route::post('discounts', [App\Http\Controllers\Admin\BookDiscountController::class, 'store'])->name('discounts.store');
    });
    Route::middleware(['permission:view discounts'])->group(function () {
        Route::get('discounts', [App\Http\Controllers\Admin\BookDiscountController::class, 'index'])->name('discounts.index');
        Route::get('discounts/{discount}', [App\Http\Controllers\Admin\BookDiscountController::class, 'show'])->name('discounts.show');
    });
    Route::middleware(['permission:edit discounts'])->group(function () {
        Route::get('discounts/{discount}/edit', [App\Http\Controllers\Admin\BookDiscountController::class, 'edit'])->name('discounts.edit');
        Route::put('discounts/{discount}', [App\Http\Controllers\Admin\BookDiscountController::class, 'update'])->name('discounts.update');
        Route::patch('discounts/{discount}', [App\Http\Controllers\Admin\BookDiscountController::class, 'update']);
        Route::post('discounts/{discount}/toggle', [App\Http\Controllers\Admin\BookDiscountController::class, 'toggleActive'])->name('discounts.toggle');
    });
    Route::middleware(['permission:delete discounts'])->group(function () {
        Route::delete('discounts/{discount}', [App\Http\Controllers\Admin\BookDiscountController::class, 'destroy'])->name('discounts.destroy');
    });
    
    // Coupon management - with permission checks
    // IMPORTANT: Create routes and static paths must come BEFORE {coupon} parameter routes
    Route::middleware(['permission:create coupons'])->group(function () {
        Route::get('coupons/create', [App\Http\Controllers\Admin\CouponController::class, 'create'])->name('coupons.create');
        Route::post('coupons', [App\Http\Controllers\Admin\CouponController::class, 'store'])->name('coupons.store');
    });
    Route::middleware(['permission:view coupons'])->group(function () {
        Route::get('coupons', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupons.index');
        Route::get('coupons/generate-code', [App\Http\Controllers\Admin\CouponController::class, 'generateCode'])->name('coupons.generate-code');
        Route::get('coupons/{coupon}', [App\Http\Controllers\Admin\CouponController::class, 'show'])->name('coupons.show');
    });
    Route::middleware(['permission:edit coupons'])->group(function () {
        Route::get('coupons/{coupon}/edit', [App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('coupons.edit');
        Route::put('coupons/{coupon}', [App\Http\Controllers\Admin\CouponController::class, 'update'])->name('coupons.update');
        Route::patch('coupons/{coupon}', [App\Http\Controllers\Admin\CouponController::class, 'update']);
        Route::post('coupons/{coupon}/toggle', [App\Http\Controllers\Admin\CouponController::class, 'toggleActive'])->name('coupons.toggle');
    });
    Route::middleware(['permission:delete coupons'])->group(function () {
        Route::delete('coupons/{coupon}', [App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('coupons.destroy');
    });
    
    // Flash sale management - with permission checks
    // IMPORTANT: Create routes must come BEFORE {flash_sale} parameter routes
    Route::middleware(['permission:create flash sales'])->group(function () {
        Route::get('flash-sales/create', [App\Http\Controllers\Admin\FlashSaleController::class, 'create'])->name('flash-sales.create');
        Route::post('flash-sales', [App\Http\Controllers\Admin\FlashSaleController::class, 'store'])->name('flash-sales.store');
        Route::post('flash-sales/books-by-genre', [App\Http\Controllers\Admin\FlashSaleController::class, 'getBooksByGenre'])->name('flash-sales.books-by-genre');
    });
    Route::middleware(['permission:view flash sales'])->group(function () {
        Route::get('flash-sales', [App\Http\Controllers\Admin\FlashSaleController::class, 'index'])->name('flash-sales.index');
        Route::get('flash-sales/{flash_sale}', [App\Http\Controllers\Admin\FlashSaleController::class, 'show'])->name('flash-sales.show');
    });
    Route::middleware(['permission:edit flash sales'])->group(function () {
        Route::get('flash-sales/{flash_sale}/edit', [App\Http\Controllers\Admin\FlashSaleController::class, 'edit'])->name('flash-sales.edit');
        Route::put('flash-sales/{flash_sale}', [App\Http\Controllers\Admin\FlashSaleController::class, 'update'])->name('flash-sales.update');
        Route::patch('flash-sales/{flash_sale}', [App\Http\Controllers\Admin\FlashSaleController::class, 'update']);
        Route::post('flash-sales/{flash_sale}/toggle', [App\Http\Controllers\Admin\FlashSaleController::class, 'toggleActive'])->name('flash-sales.toggle');
    });
    Route::middleware(['permission:delete flash sales'])->group(function () {
        Route::delete('flash-sales/{flash_sale}', [App\Http\Controllers\Admin\FlashSaleController::class, 'destroy'])->name('flash-sales.destroy');
    });

    // Dashboard data endpoints
    Route::get('top-selling', [DashboardController::class, 'getTopSellingBooksData'])->name('top-selling');
    Route::get('sales-this-period', [DashboardController::class, 'getSalesThisPeriodData'])->name('sales-this-period');
    
    // Reports - with permission checks
    Route::middleware(['permission:view reports'])->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('index');
        Route::get('/sales', [App\Http\Controllers\Admin\ReportsController::class, 'sales'])->name('sales');
        Route::get('/customers', [App\Http\Controllers\Admin\ReportsController::class, 'customers'])->name('customers');
        Route::get('/inventory', [App\Http\Controllers\Admin\ReportsController::class, 'inventory'])->name('inventory');
        Route::get('/promotions', [App\Http\Controllers\Admin\ReportsController::class, 'promotions'])->name('promotions');
        Route::get('/shipping', [App\Http\Controllers\Admin\ReportsController::class, 'shipping'])->name('shipping');
        Route::get('/profitability', [App\Http\Controllers\Admin\ReportsController::class, 'profitability'])->name('profitability');
    });
    
    // Report exports - with export permission
    Route::middleware(['permission:export reports'])->prefix('reports')->name('reports.')->group(function () {
        Route::get('/export/sales', [App\Http\Controllers\Admin\ReportsController::class, 'exportSales'])->name('export.sales');
        Route::get('/export/customers', [App\Http\Controllers\Admin\ReportsController::class, 'exportCustomers'])->name('export.customers');
        Route::get('/export/profitability', [App\Http\Controllers\Admin\ReportsController::class, 'exportProfitability'])->name('export.profitability');
    });

    // Review reports management - with permission checks
    Route::middleware(['permission:view reviews'])->prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/reports', [App\Http\Controllers\Admin\ReviewReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [App\Http\Controllers\Admin\ReviewReportController::class, 'show'])->name('reports.show');
        Route::get('/helpful', [App\Http\Controllers\Admin\ReviewHelpfulController::class, 'index'])->name('helpful.index');
    });
    Route::middleware(['permission:manage reviews'])->prefix('reviews')->name('reviews.')->group(function () {
        Route::patch('/reports/{report}/status', [App\Http\Controllers\Admin\ReviewReportController::class, 'updateStatus'])->name('reports.status');
    });

    // Admin settings - with permission checks
    Route::middleware(['permission:view settings'])->prefix('settings')->name('settings.')->group(function () {
        Route::get('/system', [SettingsController::class, 'system'])->name('system');
    });

    // Postage Rates management - with permission checks
    Route::middleware(['permission:view postage rates'])->prefix('postage-rates')->name('postage-rates.')->group(function () {
        Route::get('/', [PostageRateController::class, 'index'])->name('index');
        Route::get('/history/all', [PostageRateController::class, 'allHistory'])->name('all-history');
        Route::get('/history/{region}', [PostageRateController::class, 'history'])->name('history');
        Route::get('/verify-integrity', [PostageRateController::class, 'verifyIntegrity'])->name('verify-integrity');
    });
    Route::middleware(['permission:manage postage rates'])->prefix('postage-rates')->name('postage-rates.')->group(function () {
        Route::get('/create', [PostageRateController::class, 'create'])->name('create');
        Route::post('/', [PostageRateController::class, 'store'])->name('store');
        Route::get('/{postage_rate}/edit', [PostageRateController::class, 'edit'])->name('edit');
        Route::put('/{postage_rate}', [PostageRateController::class, 'update'])->name('update');
        Route::patch('/{postage_rate}', [PostageRateController::class, 'update']);
        Route::delete('/{postage_rate}', [PostageRateController::class, 'destroy'])->name('destroy');
    });
    
    // Recommendation Analytics - with permission checks
    Route::middleware(['permission:view recommendations'])->prefix('recommendations')->name('recommendations.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\RecommendationAnalyticsController::class, 'index'])->name('index');
        Route::get('/settings', [\App\Http\Controllers\Admin\RecommendationAnalyticsController::class, 'settings'])->name('settings');
        Route::get('/user/{user}', [\App\Http\Controllers\Admin\RecommendationAnalyticsController::class, 'userDetails'])->name('user.details');
    });
    Route::middleware(['permission:manage recommendations'])->prefix('recommendations')->name('recommendations.')->group(function () {
        Route::post('/settings', [\App\Http\Controllers\Admin\RecommendationAnalyticsController::class, 'updateSettings'])->name('settings.update');
    });
});

// Superadmin routes (requires superadmin role OR access superadmin permission)
Route::middleware(['auth', 'role_or_permission:superadmin|access superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    
    // Real-time dashboard API endpoints
    Route::get('/api/stats', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'getRealtimeStats'])->name('api.stats');
    Route::get('/api/user-registrations', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'getRealtimeUserRegistrations'])->name('api.user-registrations');
    Route::get('/api/recent-users', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'getRecentUsers'])->name('api.recent-users');
    Route::get('/api/system-health', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'getSystemHealth'])->name('api.system-health');
    
    // Admin management - requires manage admins permission
    Route::middleware(['permission:manage admins'])->group(function () {
        Route::resource('admins', App\Http\Controllers\SuperAdmin\AdminController::class);
    });
    
    // System settings - requires manage system settings permission
    Route::middleware(['permission:manage system settings'])->group(function () {
        Route::get('/settings', [App\Http\Controllers\SuperAdmin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\SuperAdmin\SettingController::class, 'update'])->name('settings.update');
    });
    
    // Role and permission management - requires manage roles/permissions
    Route::middleware(['permission:manage roles'])->group(function () {
        Route::resource('roles', App\Http\Controllers\SuperAdmin\RoleController::class);
    });
    Route::middleware(['permission:manage permissions'])->group(function () {
        Route::resource('permissions', App\Http\Controllers\SuperAdmin\PermissionController::class);
    });
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