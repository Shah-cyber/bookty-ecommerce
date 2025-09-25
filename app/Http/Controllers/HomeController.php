<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\FlashSale;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $newArrivals = Book::with(['genre', 'reviews'])
            ->latest() // orders by created_at desc
            ->take(20)
            ->get();
            
        // Get genres with book count
        $genres = Genre::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(8)
            ->get();
        
        // Get active flash sales
        $activeFlashSale = FlashSale::with(['books' => function($query) {
                $query->with(['genre', 'reviews']);
            }])
            ->active()
            ->orderBy('ends_at', 'asc')
            ->first();
            
        return view('home.index', compact('newArrivals', 'genres', 'activeFlashSale'));
    }
}
