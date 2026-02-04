<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flashSales = FlashSale::withCount('books')->latest()->paginate(6);
        return view('admin.flash-sales.index', compact('flashSales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::with('books')->get();
        $books = Book::orderBy('title')->get();
        return view('admin.flash-sales.create', compact('genres', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'books' => 'required|array',
            'books.*' => 'exists:books,id',
            'special_prices' => 'nullable|array',
            'special_prices.*' => 'nullable|numeric|min:0',
        ]);
        
        // Additional validation logic for discount rules and special prices
        // Ensure percentage discounts are between 1 and 100
        if ($request->discount_type === 'percentage') {
            if ($request->discount_value <= 0 || $request->discount_value > 100) {
                return back()->withInput()->with('error', 'Percentage discount must be between 1 and 100.');
            }
        }
        
        // Ensure fixed discount is sensible relative to selected books (less than the cheapest selected book)
        $selectedBooks = Book::whereIn('id', $request->books)->get(['id', 'price']);
        if ($request->discount_type === 'fixed') {
            $minPrice = $selectedBooks->min('price');
            if ($minPrice !== null && $request->discount_value > $minPrice) {
                return back()->withInput()->with('error', 'Fixed discount must be less than or equal to the cheapest selected book price (RM '.number_format($minPrice, 2).').');
            }
        }
        
        // Validate special prices: only for selected books, > 0 and less than original price
        $specialPrices = $request->input('special_prices', []);
        foreach ($specialPrices as $bookId => $specialPrice) {
            // Only validate when user provided a positive value
            if ($specialPrice === null || $specialPrice === '' || (float)$specialPrice <= 0) {
                continue;
            }
            if (!in_array((int)$bookId, $request->books)) {
                return back()->withInput()->with('error', 'Special price provided for an unselected book.');
            }
            $book = $selectedBooks->firstWhere('id', (int)$bookId);
            if ($book) {
                if ($specialPrice >= $book->price) {
                    return back()->withInput()->with('error', "Special price for '{$book->title}' must be less than its original price (RM ".number_format($book->price, 2).').');
                }
            }
        }

        try {
            DB::beginTransaction();
            
            // Create flash sale
            $flashSale = new FlashSale();
            $flashSale->name = $request->name;
            $flashSale->description = $request->description;
            $flashSale->starts_at = date('Y-m-d H:i:s', strtotime($request->starts_at));
            $flashSale->ends_at = date('Y-m-d H:i:s', strtotime($request->ends_at));
            $flashSale->discount_type = $request->discount_type;
            $flashSale->discount_value = $request->discount_value;
            // Use boolean() so hidden "0" + optional "1" checkbox work correctly
            $flashSale->free_shipping = $request->boolean('free_shipping');
            $flashSale->is_active = true;
            $flashSale->save();
            
            // Add books to flash sale
            foreach ($request->books as $index => $bookId) {
                $specialPrice = isset($request->special_prices[$bookId]) && $request->special_prices[$bookId] > 0 
                    ? $request->special_prices[$bookId] 
                    : null;
                
                FlashSaleItem::create([
                    'flash_sale_id' => $flashSale->id,
                    'book_id' => $bookId,
                    'special_price' => $specialPrice,
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('admin.flash-sales.index')
                ->with('success', 'Flash sale created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating flash sale: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flashSale = FlashSale::with(['books' => function($query) {
            $query->withCount('orderItems');
        }])->findOrFail($id);
        
        return view('admin.flash-sales.show', compact('flashSale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $flashSale = FlashSale::with('books')->findOrFail($id);
        $genres = Genre::with('books')->get();
        $books = Book::orderBy('title')->get();
        
        // Get special prices for books in this flash sale
        $specialPrices = [];
        foreach ($flashSale->items as $item) {
            if ($item->special_price) {
                $specialPrices[$item->book_id] = $item->special_price;
            }
        }
        
        return view('admin.flash-sales.edit', compact('flashSale', 'genres', 'books', 'specialPrices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $flashSale = FlashSale::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'books' => 'required|array',
            'books.*' => 'exists:books,id',
            'special_prices' => 'nullable|array',
            'special_prices.*' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        
        // Additional validation logic for discount rules and special prices
        if ($request->discount_type === 'percentage') {
            if ($request->discount_value <= 0 || $request->discount_value > 100) {
                return back()->withInput()->with('error', 'Percentage discount must be between 1 and 100.');
            }
        }
        
        $selectedBooks = Book::whereIn('id', $request->books)->get(['id', 'price', 'title']);
        if ($request->discount_type === 'fixed') {
            $minPrice = $selectedBooks->min('price');
            if ($minPrice !== null && $request->discount_value > $minPrice) {
                return back()->withInput()->with('error', 'Fixed discount must be less than or equal to the cheapest selected book price (RM '.number_format($minPrice, 2).').');
            }
        }
        
        $specialPrices = $request->input('special_prices', []);
        foreach ($specialPrices as $bookId => $specialPrice) {
            // Only validate when user provided a positive value
            if ($specialPrice === null || $specialPrice === '' || (float)$specialPrice <= 0) {
                continue;
            }
            if (!in_array((int)$bookId, $request->books)) {
                return back()->withInput()->with('error', 'Special price provided for an unselected book.');
            }
            $book = $selectedBooks->firstWhere('id', (int)$bookId);
            if ($book) {
                if ($specialPrice >= $book->price) {
                    return back()->withInput()->with('error', "Special price for '{$book->title}' must be less than its original price (RM ".number_format($book->price, 2).').');
                }
            }
        }

        try {
            DB::beginTransaction();
            
            // Update flash sale
            $flashSale->name = $request->name;
            $flashSale->description = $request->description;
            $flashSale->starts_at = date('Y-m-d H:i:s', strtotime($request->starts_at));
            $flashSale->ends_at = date('Y-m-d H:i:s', strtotime($request->ends_at));
            $flashSale->discount_type = $request->discount_type;
            $flashSale->discount_value = $request->discount_value;
            // Handle free shipping toggle using boolean() to respect hidden 0 + checkbox 1 pattern
            $flashSale->free_shipping = $request->boolean('free_shipping');
            // Handle is_active field explicitly with boolean()
            $flashSale->is_active = $request->boolean('is_active');
            $flashSale->save();
            
            // Remove existing items
            $flashSale->items()->delete();
            
            // Add books to flash sale
            foreach ($request->books as $index => $bookId) {
                $specialPrice = isset($request->special_prices[$bookId]) && $request->special_prices[$bookId] > 0 
                    ? $request->special_prices[$bookId] 
                    : null;
                
                FlashSaleItem::create([
                    'flash_sale_id' => $flashSale->id,
                    'book_id' => $bookId,
                    'special_price' => $specialPrice,
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('admin.flash-sales.index')
                ->with('success', 'Flash sale updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating flash sale: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $flashSale = FlashSale::findOrFail($id);
            
            DB::beginTransaction();
            
            // Delete flash sale items first
            $flashSale->items()->delete();
            
            // Delete the flash sale
            $flashSale->delete();
            
            DB::commit();
            
            return redirect()->route('admin.flash-sales.index')
                ->with('success', 'Flash sale deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting flash sale: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle the active status of the flash sale.
     */
    public function toggleActive(string $id)
    {
        try {
            $flashSale = FlashSale::findOrFail($id);
            $flashSale->is_active = !$flashSale->is_active;
            $flashSale->save();
            
            $status = $flashSale->is_active ? 'activated' : 'deactivated';
            return redirect()->route('admin.flash-sales.index')
                ->with('success', "Flash sale {$status} successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating flash sale status: ' . $e->getMessage());
        }
    }
    
    /**
     * Get books by genre.
     */
    public function getBooksByGenre(Request $request)
    {
        $request->validate([
            'genre_id' => 'required|exists:genres,id',
        ]);
        
        $books = Book::where('genre_id', $request->genre_id)
            ->orderBy('title')
            ->get(['id', 'title', 'author', 'price', 'stock']);
            
        return response()->json(['books' => $books]);
    }
}
