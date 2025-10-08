<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\ReviewHelpful;
use App\Models\ReviewReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Constructor - no middleware needed as it's applied in routes
     */
    public function __construct()
    {
        // Auth middleware is applied in the routes file
    }
    
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'order_item_id' => 'required|exists:order_items,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB per image
        ]);
        
        // Debug: Log the uploaded files
        \Log::info('Review submission debug:', [
            'has_images' => $request->hasFile('images'),
            'files_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
            'all_files' => $request->allFiles(),
        ]);
        
        // Check if user has purchased the book
        if (!Auth::user()->canReviewBook($book->id)) {
            return redirect()->route('books.show', $book)
                ->with('error', 'You can only review books you have purchased.');
        }
        
        // Check if user has already reviewed this book
        if (Auth::user()->hasReviewedBook($book->id)) {
            return redirect()->route('books.show', $book)
                ->with('error', 'You have already reviewed this book.');
        }
        
        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate a unique filename with timestamp
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('reviews', $filename, 'public');
                $imagePaths[] = $path;
            }
        }
        
        // Create the review
        $review = new Review([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'order_item_id' => $request->order_item_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $imagePaths,
            'is_approved' => true, // Auto-approve for now, can be changed for moderation workflow
        ]);
        
        $review->save();
        
        return redirect()->route('books.show', $book)
            ->with('success', 'Thank you for your review!');
    }

    /**
     * Toggle helpful vote for a review.
     */
    public function toggleHelpful(Request $request, Review $review)
    {
        $user = Auth::user();
        
        // Check if user has already marked this review as helpful
        $helpful = ReviewHelpful::where('review_id', $review->id)
            ->where('user_id', $user->id)
            ->first();
        
        if ($helpful) {
            // Remove helpful vote
            $helpful->delete();
            $message = 'Removed helpful vote';
            $isHelpful = false;
        } else {
            // Add helpful vote
            ReviewHelpful::create([
                'review_id' => $review->id,
                'user_id' => $user->id,
            ]);
            $message = 'Marked as helpful';
            $isHelpful = true;
        }
        
        // Get updated helpful count
        $helpfulCount = $review->helpfuls()->count();
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_helpful' => $isHelpful,
                'helpful_count' => $helpfulCount,
            ]);
        }
        
        return back()->with('success', $message);
    }

    /**
     * Report a review for abuse.
     */
    public function report(Request $request, Review $review)
    {
        $request->validate([
            'reason' => 'required|in:spam,inappropriate,offensive,fake,other',
            'description' => 'nullable|string|max:500',
        ]);
        
        $user = Auth::user();
        
        // Check if user has already reported this review
        $existingReport = ReviewReport::where('review_id', $review->id)
            ->where('user_id', $user->id)
            ->first();
        
        if ($existingReport) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already reported this review.',
                ], 400);
            }
            return back()->with('error', 'You have already reported this review.');
        }
        
        // Create report
        ReviewReport::create([
            'review_id' => $review->id,
            'user_id' => $user->id,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending',
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review reported successfully. Thank you for your feedback.',
            ]);
        }
        
        return back()->with('success', 'Review reported successfully. Thank you for your feedback.');
    }
}
