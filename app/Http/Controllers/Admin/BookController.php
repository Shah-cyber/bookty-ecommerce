<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Trope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view books')->only(['index', 'show']);
        $this->middleware('permission:create books')->only(['create', 'store']);
        $this->middleware('permission:edit books')->only(['edit', 'update', 'quickUpdate']);
        $this->middleware('permission:delete books')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with(['genre', 'tropes']);

        // Search by title, author, or slug
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->where('genre_id', $request->genre);
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('stock', '>', 10);
                    break;
                case 'low_stock':
                    $query->whereBetween('stock', [1, 10]);
                    break;
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
            }
        }

        // Sort
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'stock_asc':
                $query->orderBy('stock', 'asc');
                break;
            case 'stock_desc':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $perPage = $request->per_page ?? 10;
        $books = $query->paginate($perPage);
        
        // Get all genres for filter
        $genres = Genre::orderBy('name')->get();

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.books._table', compact('books'))->render(),
                'pagination' => [
                    'current_page' => $books->currentPage(),
                    'last_page' => $books->lastPage(),
                    'total' => $books->total(),
                    'from' => $books->firstItem(),
                    'to' => $books->lastItem(),
                ]
            ]);
        }

        return view('admin.books.index', compact('books', 'genres'));
    }

    /**
     * Quick update book stock via AJAX.
     */
    public function quickUpdate(Request $request, Book $book)
    {
        $request->validate([
            'stock' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
            'condition' => 'sometimes|in:new,preloved',
        ]);

        $updateData = [];
        
        if ($request->has('stock')) {
            $updateData['stock'] = $request->stock;
        }
        
        if ($request->has('price')) {
            $updateData['price'] = $request->price;
        }
        
        if ($request->has('condition')) {
            $updateData['condition'] = $request->condition;
        }

        $book->update($updateData);
        $book->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully',
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'stock' => $book->stock,
                'price' => $book->price,
                'condition' => $book->condition,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();
        $tropes = Trope::all();
        return view('admin.books.create', compact('genres', 'tropes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:books',
            'author' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:new,preloved',
            'genre_id' => 'required|exists:genres,id',
            'cover_image' => 'nullable|image|max:2048', // 2MB max
            'tropes' => 'nullable|array',
            'tropes.*' => 'exists:tropes,id',
        ]);

        $data = $request->except(['cover_image', 'tropes']);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books', 'public');
            $data['cover_image'] = $path;
        }

        // Create the book
        $book = Book::create($data);

        // Sync tropes
        if ($request->has('tropes')) {
            $book->tropes()->sync($request->tropes);
        }
        
        // Cache clearing is handled by BookObserver automatically

        return redirect()->route('admin.books.index')
            ->with('success', "'{$book->title}' by {$book->author} has been added to the catalog!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['genre', 'tropes']);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $genres = Genre::all();
        $tropes = Trope::all();
        return view('admin.books.edit', compact('book', 'genres', 'tropes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:books,slug,' . $book->id,
            'author' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'condition' => 'required|in:new,preloved',
            'genre_id' => 'required|exists:genres,id',
            'cover_image' => 'nullable|image|max:3072', // 3MB max
            'tropes' => 'nullable|array',
            'tropes.*' => 'exists:tropes,id',
        ]);

        $data = $request->except(['cover_image', 'tropes']);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            
            $path = $request->file('cover_image')->store('books', 'public');
            $data['cover_image'] = $path;
        }

        // Update the book
        $book->update($data);
        
        // Refresh the model to ensure fresh data
        $book->refresh();

        // Sync tropes
        $book->tropes()->sync($request->tropes ?? []);
        
        // Cache clearing is handled by BookObserver automatically

        return redirect()->route('admin.books.show', $book)
            ->with('success', "'{$book->title}' has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book)
    {
        $bookTitle = $book->title;
        
        // Delete cover image if exists
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        // Delete the book
        $book->delete();
        
        // Cache clearing is handled by BookObserver automatically

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Book '{$bookTitle}' has been removed from the catalog."
            ]);
        }

        return redirect()->route('admin.books.index')
            ->with('success', "Book '{$bookTitle}' has been removed from the catalog.");
    }
}
