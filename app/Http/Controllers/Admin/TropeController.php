<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trope;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TropeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view tropes')->only(['index', 'show']);
        $this->middleware('permission:create tropes')->only(['create', 'store']);
        $this->middleware('permission:edit tropes')->only(['edit', 'update']);
        $this->middleware('permission:delete tropes')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Trope::withCount('books');

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
        $tropes = $query->paginate($perPage);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.tropes._table', compact('tropes'))->render(),
                'pagination' => [
                    'current_page' => $tropes->currentPage(),
                    'last_page' => $tropes->lastPage(),
                    'total' => $tropes->total(),
                    'from' => $tropes->firstItem(),
                    'to' => $tropes->lastItem(),
                ]
            ]);
        }

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
            ->with('success', "Trope '{$request->name}' has been created successfully!");
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
        $trope->loadCount('books');
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
            ->with('success', "Trope '{$trope->name}' has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Trope $trope)
    {
        $tropeName = $trope->name;
        $trope->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Trope '{$tropeName}' has been deleted successfully!"
            ]);
        }

        return redirect()->route('admin.tropes.index')
            ->with('success', "Trope '{$tropeName}' has been deleted successfully!");
    }
}
