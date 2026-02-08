<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\UserBookInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the user's wishlist.
     */
    public function index()
    {
        $user = Auth::user();
        $wishlistItems = $user->wishlist()->with('book.genre')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }
    
    /**
     * Add a book to the user's wishlist.
     */
    public function add(Book $book)
    {
        $user = Auth::user();
        
        // Check if book is already in wishlist
        if ($user->hasBookInWishlist($book->id)) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book is already in your wishlist.'
                ], 400);
            }
            
            return redirect()->back()->with('error', 'Book is already in your wishlist.');
        }
        
        // Add book to wishlist
        $wishlistItem = new Wishlist([
            'user_id' => Auth::id(),
            'book_id' => $book->id
        ]);
        
        $wishlistItem->save();
        
        // Track 'wishlist' interaction for recommendations
        UserBookInteraction::record(Auth::id(), $book->id, 'wishlist');
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Book added to your wishlist!',
                'wishlist_count' => $user->wishlist()->count(),
                'book' => [
                    'id' => $book->id,
                    'title' => $book->title
                ]
            ]);
        }
        
        return redirect()->back()->with('success', 'Book added to your wishlist!');
    }
    
    /**
     * Remove a book from the user's wishlist.
     */
    public function remove(Book $book)
    {
        $user = Auth::user();
        $deleted = $user->wishlist()->where('book_id', $book->id)->delete();
        
        if ($deleted) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Book removed from your wishlist!',
                    'wishlist_count' => $user->wishlist()->count(),
                    'book' => [
                        'id' => $book->id,
                        'title' => $book->title
                    ]
                ]);
            }
            
            return redirect()->back()->with('success', 'Book removed from your wishlist!');
        }
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Book was not in your wishlist.'
            ], 400);
        }
        
        return redirect()->back()->with('error', 'Book was not in your wishlist.');
    }
    
    /**
     * Toggle a book in the user's wishlist (add if not present, remove if present).
     */
    public function toggle(Book $book)
    {
        $user = Auth::user();
        if ($user->hasBookInWishlist($book->id)) {
            return $this->remove($book);
        } else {
            return $this->add($book);
        }
    }

    /**
     * Clear all items from the user's wishlist.
     */
    public function clear()
    {
        $user = Auth::user();
        $deleted = $user->wishlist()->delete();
        
        if ($deleted) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your wishlist has been cleared!',
                    'wishlist_count' => 0
                ]);
            }
            
            return redirect()->route('wishlist.index')->with('success', 'Your wishlist has been cleared!');
        }
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Your wishlist is already empty.'
            ], 400);
        }
        
        return redirect()->route('wishlist.index')->with('info', 'Your wishlist is already empty.');
    }
}
