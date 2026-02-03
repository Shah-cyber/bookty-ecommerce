<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\FlashSale;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\BookDiscount;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(private RecommendationService $recommendationService)
    {
    }

    public function index()
    {
        // Collect all active promotions for display
        $promotions = collect();
        
        // 1. Get active coupons
        $activeCoupons = Coupon::active()
            ->where('discount_value', '>', 0)
            ->withCount('usages')
            ->orderBy('discount_value', 'desc')
            ->take(2)
            ->get();
        
        foreach ($activeCoupons as $coupon) {
            $promotions->push([
                'type' => 'coupon',
                'id' => $coupon->id,
                'title' => $coupon->discount_type === 'percentage' 
                    ? number_format($coupon->discount_value) . '% OFF' 
                    : 'RM ' . number_format($coupon->discount_value, 2) . ' OFF',
                'subtitle' => 'Use Code: ' . $coupon->code,
                'code' => $coupon->code,
                'description' => $coupon->description,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_value,
                'min_purchase' => $coupon->min_purchase_amount,
                'ends_at' => $coupon->expires_at,
                'free_shipping' => $coupon->free_shipping,
                'max_uses' => $coupon->max_uses_total,
                'current_uses' => $coupon->usages_count ?? 0,
                'link' => route('books.index'),
                'link_text' => 'Shop Now',
                'gradient' => 'from-purple-600 via-purple-700 to-pink-600',
                'accent' => 'purple',
            ]);
        }
        
        // 2. Get active flash sales
        $activeFlashSales = FlashSale::active()
            ->withCount('books')
            ->orderBy('discount_value', 'desc')
            ->take(2)
            ->get();
        
        foreach ($activeFlashSales as $flashSale) {
            $promotions->push([
                'type' => 'flash_sale',
                'id' => $flashSale->id,
                'title' => $flashSale->discount_type === 'percentage' 
                    ? number_format($flashSale->discount_value) . '% OFF' 
                    : 'RM ' . number_format($flashSale->discount_value, 2) . ' OFF',
                'subtitle' => $flashSale->name,
                'code' => null,
                'description' => $flashSale->description,
                'discount_type' => $flashSale->discount_type,
                'discount_value' => $flashSale->discount_value,
                'min_purchase' => null,
                'ends_at' => $flashSale->ends_at,
                'free_shipping' => $flashSale->free_shipping,
                'max_uses' => null,
                'current_uses' => 0,
                'books_count' => $flashSale->books_count,
                'link' => route('books.index'),
                'link_text' => 'View ' . $flashSale->books_count . ' Sale Books',
                'gradient' => 'from-orange-500 via-red-500 to-pink-500',
                'accent' => 'orange',
            ]);
        }
        
        // 3. Get active book discounts (group by similar discounts, show top ones)
        $activeBookDiscounts = BookDiscount::active()
            ->with('book')
            ->orderByRaw('COALESCE(discount_percent, 0) DESC, COALESCE(discount_amount, 0) DESC')
            ->take(4)
            ->get();
        
        // Group book discounts if multiple exist
        if ($activeBookDiscounts->count() > 0) {
            $topDiscount = $activeBookDiscounts->first();
            $discountValue = $topDiscount->discount_percent ?? $topDiscount->discount_amount;
            $isPercent = $topDiscount->discount_percent > 0;
            
            $promotions->push([
                'type' => 'book_discount',
                'id' => $topDiscount->id,
                'title' => $isPercent 
                    ? 'Up to ' . number_format($discountValue) . '% OFF' 
                    : 'Save up to RM ' . number_format($discountValue, 2),
                'subtitle' => 'Special Book Discounts',
                'code' => null,
                'description' => $topDiscount->description ?? ($activeBookDiscounts->count() . ' books on sale!'),
                'discount_type' => $isPercent ? 'percentage' : 'fixed',
                'discount_value' => $discountValue,
                'min_purchase' => null,
                'ends_at' => $topDiscount->ends_at,
                'free_shipping' => $topDiscount->free_shipping,
                'max_uses' => null,
                'current_uses' => 0,
                'books_count' => $activeBookDiscounts->count(),
                'featured_book' => $topDiscount->book,
                'link' => route('books.index'),
                'link_text' => 'View Discounted Books',
                'gradient' => 'from-indigo-600 via-blue-600 to-cyan-500',
                'accent' => 'indigo',
            ]);
        }
        
        // Sort promotions by discount value and limit to 4
        $promotions = $promotions->sortByDesc('discount_value')->take(4);
        $newArrivals = Book::with(['genre', 'reviews'])
            ->latest() // orders by created_at desc
            ->take(20)
            ->get();

        // Get newest books for the hero section (for guest users)
        // The carousel will display all these books, showing them one at a time
        // Limit to 12 to keep good performance while showing all recent additions
        $heroBooks = Book::with(['genre', 'reviews'])
            ->latest()
            ->take(12)
            ->get();

        // Get genres with book count
        $genres = Genre::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(8)
            ->get();

        // Get active flash sales
        $activeFlashSale = FlashSale::with([
            'books' => function ($query) {
                $query->with(['genre', 'reviews']);
            }
        ])
            ->active()
            ->orderBy('ends_at', 'asc')
            ->first();

        // Get personalized recommendations for authenticated users
        $recommendations = null;
        if (Auth::check()) {
            try {
                $recommendations = $this->recommendationService->recommendForUser(Auth::user(), 6);
            } catch (\Exception $e) {
                // Fallback to new arrivals if recommendations fail
                $recommendations = $newArrivals->take(6);
            }
        }

        // Get featured testimonials (highest rated reviews with comments)
        $testimonials = \App\Models\Review::with(['user', 'book'])
            ->where('is_approved', true)
            ->whereNotNull('comment')
            ->where('rating', '>=', 4) // Only 4 and 5 star reviews
            ->where('comment', '!=', '') // Ensure comment is not empty
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Calculate testimonial statistics
        // Count unique customers who have made orders
        $totalCustomers = \App\Models\Order::distinct('user_id')->count('user_id');

        // If no orders yet, count all users
        if ($totalCustomers === 0) {
            $totalCustomers = \App\Models\User::count();
        }

        $totalBooksSold = \App\Models\OrderItem::sum('quantity') ?: 0;
        $averageRating = \App\Models\Review::where('is_approved', true)->avg('rating');
        $totalReviews = \App\Models\Review::where('is_approved', true)->count();

        // Calculate satisfaction rate (percentage of 4 and 5 star reviews)
        $positiveReviews = \App\Models\Review::where('is_approved', true)
            ->where('rating', '>=', 4)
            ->count();
        $satisfactionRate = $totalReviews > 0 ? round(($positiveReviews / $totalReviews) * 100) : 95; // Default to 95% if no reviews

        return view('home.index', compact(
            'newArrivals',
            'heroBooks',
            'genres',
            'activeFlashSale',
            'recommendations',
            'testimonials',
            'totalCustomers',
            'totalBooksSold',
            'averageRating',
            'satisfactionRate',
            'promotions'
        ));
    }
}
