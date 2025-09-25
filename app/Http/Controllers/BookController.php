<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Trope;
use Illuminate\Http\Request;
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
        
        // Get all genres and tropes for filters
        $genres = Genre::all();
        $tropes = Trope::all();
        
        return view('books.index', compact('books', 'genres', 'tropes'));
    }
    
    public function show(Book $book)
    {
        $book->load(['genre', 'tropes']);
        
        // Get related books from the same genre
        $relatedBooks = Book::where('genre_id', $book->genre_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();
        
        // Get reviews for this book
        $reviews = $book->reviews()
            ->with('user')
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Check if the current user can leave a review (if authenticated)
        $canReview = false;
        $hasReviewed = false;
        $orderItem = null;
        
        if (Auth::check()) {
            $user = Auth::user();
            $canReview = $user->canReviewBook($book->id);
            $hasReviewed = $user->hasReviewedBook($book->id);
            
            // If the user can review but hasn't yet, get the order item for the review form
            if ($canReview && !$hasReviewed) {
                $orderItem = $user->getOrderItemForBookReview($book->id);
            }
        }
            
        return view('books.show', compact('book', 'relatedBooks', 'reviews', 'canReview', 'hasReviewed', 'orderItem'));
    }
}
