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
    public function index()
    {
        $genres = Genre::withCount('books')->latest()->paginate(10);
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
            ->with('success', "🏷️ Genre '{$request->name}' has been created successfully!");
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
            ->with('success', "✅ Genre '{$genre->name}' has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        // Check if genre has books
        if ($genre->books()->count() > 0) {
            return redirect()->route('admin.genres.index')
                ->with('error', "⚠️ Cannot delete '{$genre->name}' because it has {$genre->books()->count()} associated books.");
        }

        $genre->delete();

        return redirect()->route('admin.genres.index')
            ->with('success', "🗑️ Genre '{$genre->name}' has been deleted successfully!");
    }
}
