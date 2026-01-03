<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Trope;
use App\Models\User;
use App\Models\UserBookInteraction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['genre', 'tropes', 'reviews']);
        
        // Apply genre filter
        if ($request->has('genre') && $request->genre) {
            $query->where('genre_id', $request->genre);
        }
        
        // Apply trope filter
        if ($request->has('trope') && $request->trope) {
            $query->whereHas('tropes', function($q) use ($request) {
                $q->where('tropes.id', $request->trope);
            });
        }

        // Apply author filter
        if ($request->has('author') && $request->author) {
            $query->where('author', $request->author);
        }
        
        // Apply price filter
        if ($request->has('price_min') && $request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        
        if ($request->has('price_max') && $request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }
        
        // Apply sorting
        $sort = $request->sort ?? 'newest';
        
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $books = $query->paginate(12);
        
        // Get all genres, tropes and authors for filters
        $genres = Genre::all();
        $tropes = Trope::all();
        $authors = Book::select('author')->distinct()->orderBy('author')->pluck('author');
        
        return view('books.index', compact('books', 'genres', 'tropes', 'authors'));
    }
    
    public function show(Book $book)
    {
        $book->load(['genre', 'tropes']);
        
        // Get related books from the same genre
        $relatedBooks = Book::where('genre_id', $book->genre_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();
        
        // Get reviews for this book with pagination
        $reviews = $book->reviews()
            ->with('user')
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Show 5 reviews per page
        
        // Check if the current user can leave a review (if authenticated)
        $canReview = false;
        $hasReviewed = false;
        $orderItem = null;
        
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            $canReview = $user->canReviewBook($book->id);
            $hasReviewed = $user->hasReviewedBook($book->id);
            
            // If the user can review but hasn't yet, get the order item for the review form
            if ($canReview && !$hasReviewed) {
                $orderItem = $user->getOrderItemForBookReview($book->id);
            }
            
            // Track 'view' interaction for recommendations
            UserBookInteraction::record($user->id, $book->id, 'view');
        }
        
        // Calculate review statistics
        $reviewStats = $this->calculateReviewStats($book);
        
        // Get reviews with images for gallery
        $reviewsWithImages = $book->reviews()
            ->whereNotNull('images')
            ->where('images', '!=', '[]')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        return view('books.show', compact('book', 'relatedBooks', 'reviews', 'canReview', 'hasReviewed', 'orderItem', 'reviewStats', 'reviewsWithImages'));
    }
    
    /**
     * Calculate review statistics for the book
     */
    private function calculateReviewStats($book)
    {
        $totalReviews = $book->reviews->count();
        
        if ($totalReviews === 0) {
            return [
                'average' => 0,
                'total' => 0,
                'breakdown' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
                'percentages' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]
            ];
        }
        
        // Get rating breakdown
        $breakdown = $book->reviews()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->pluck('count', 'rating')
            ->toArray();
        
        // Fill missing ratings with 0
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($breakdown[$i])) {
                $breakdown[$i] = 0;
            }
        }
        
        // Calculate percentages
        $percentages = [];
        foreach ($breakdown as $rating => $count) {
            $percentages[$rating] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
        }
        
        return [
            'average' => round($book->average_rating ?: 0, 1),
            'total' => $totalReviews,
            'breakdown' => $breakdown,
            'percentages' => $percentages
        ];
    }
}
