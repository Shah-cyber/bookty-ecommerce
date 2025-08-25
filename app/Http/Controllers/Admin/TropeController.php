<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trope;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TropeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tropes = Trope::withCount('books')->latest()->paginate(10);
        return view('admin.tropes.index', compact('tropes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tropes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tropes',
            'description' => 'nullable|string',
        ]);

        Trope::create($request->all());

        return redirect()->route('admin.tropes.index')
            ->with('success', "🏷️ Trope '{$request->name}' has been created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Trope $trope)
    {
        return redirect()->route('admin.tropes.edit', $trope);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trope $trope)
    {
        return view('admin.tropes.edit', compact('trope'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trope $trope)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tropes,slug,' . $trope->id,
            'description' => 'nullable|string',
        ]);

        $trope->update($request->all());

        return redirect()->route('admin.tropes.index')
            ->with('success', "✅ Trope '{$trope->name}' has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trope $trope)
    {
        // Delete the trope (the pivot table entries will be automatically deleted due to the cascade)
        $trope->delete();

        return redirect()->route('admin.tropes.index')
            ->with('success', "🗑️ Trope '{$trope->name}' has been deleted successfully!");
    }
}
