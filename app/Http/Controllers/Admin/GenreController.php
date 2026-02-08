<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Genre::withCount('books');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'books_asc':
                $query->orderBy('books_count', 'asc');
                break;
            case 'books_desc':
                $query->orderBy('books_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $perPage = $request->per_page ?? 10;
        $genres = $query->paginate($perPage);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.genres._table', compact('genres'))->render(),
                'pagination' => [
                    'current_page' => $genres->currentPage(),
                    'last_page' => $genres->lastPage(),
                    'total' => $genres->total(),
                    'from' => $genres->firstItem(),
                    'to' => $genres->lastItem(),
                ]
            ]);
        }

        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:genres',
            'description' => 'nullable|string',
        ]);

        Genre::create($request->all());

        return redirect()->route('admin.genres.index')
            ->with('success', "Genre '{$request->name}' has been created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return redirect()->route('admin.genres.edit', $genre);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        $genre->loadCount('books');
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:genres,slug,' . $genre->id,
            'description' => 'nullable|string',
        ]);

        $genre->update($request->all());

        return redirect()->route('admin.genres.index')
            ->with('success', "Genre '{$genre->name}' has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Genre $genre)
    {
        // Check if genre has books
        if ($genre->books()->count() > 0) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot delete '{$genre->name}' because it has {$genre->books()->count()} associated books."
                ], 422);
            }
            return redirect()->route('admin.genres.index')
                ->with('error', "Cannot delete '{$genre->name}' because it has {$genre->books()->count()} associated books.");
        }

        $genreName = $genre->name;
        $genre->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Genre '{$genreName}' has been deleted successfully!"
            ]);
        }

        return redirect()->route('admin.genres.index')
            ->with('success', "Genre '{$genreName}' has been deleted successfully!");
    }
}
