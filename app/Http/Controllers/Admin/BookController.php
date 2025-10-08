<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Trope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['genre', 'tropes'])->latest()->paginate(6);
        return view('admin.books.index', compact('books'));
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

        return redirect()->route('admin.books.index')
            ->with('success', " '{$book->title}' by {$book->author} has been added to the catalog!");
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

        // Sync tropes
        $book->tropes()->sync($request->tropes ?? []);

        return redirect()->route('admin.books.show', $book)
            ->with('success', " '{$book->title}' has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Delete cover image if exists
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        // Delete the book
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', " Book '{$book->title}' has been removed from the catalog.");
    }
}
