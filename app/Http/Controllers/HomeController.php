<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\FlashSale;
use App\Models\Order;
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
            'satisfactionRate'
        ));
    }
}
