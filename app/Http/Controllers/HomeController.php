<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured books (newest arrivals)
        $newArrivals = Book::with('genre')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            
        // Get genres with book count
        $genres = Genre::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(4)
            ->get();
            
        return view('home.index', compact('newArrivals', 'genres'));
    }
}
