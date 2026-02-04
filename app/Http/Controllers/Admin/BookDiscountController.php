<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = BookDiscount::with('book')->latest()->paginate(6);
        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::orderBy('title')->get();
        return view('admin.discounts.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'discount_type' => 'required|in:amount,percent',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'description' => 'nullable|string|max:255',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Deactivate any existing active discounts for this book
            BookDiscount::where('book_id', $request->book_id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
            
            // Validate sensible ranges
            $book = Book::findOrFail($request->book_id);
            if ($request->discount_type === 'percent' && ($request->discount_value <= 0 || $request->discount_value > 100)) {
                return back()->withInput()->with('error', 'Percentage discount must be between 1 and 100.');
            }
            if ($request->discount_type === 'amount' && $request->discount_value > $book->price) {
                return back()->withInput()->with('error', 'Fixed discount must be less than or equal to the book price (RM '.number_format($book->price, 2).').');
            }
            
            // Create new discount
            $discount = new BookDiscount();
            $discount->book_id = $request->book_id;
            
            if ($request->discount_type === 'amount') {
                $discount->discount_amount = $request->discount_value;
            } else {
                $discount->discount_percent = $request->discount_value;
            }
            
            $discount->starts_at = $request->starts_at;
            $discount->ends_at = $request->ends_at;
            $discount->description = $request->description;
            // Handle free shipping toggle correctly (hidden 0 + checkbox 1)
            $discount->free_shipping = $request->boolean('free_shipping');
            $discount->is_active = true;
            $discount->save();
            
            DB::commit();
            
            return redirect()->route('admin.discounts.index')
                ->with('success', 'Discount created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating discount: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $discount = BookDiscount::with('book')->findOrFail($id);
        return view('admin.discounts.show', compact('discount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $discount = BookDiscount::findOrFail($id);
        $books = Book::orderBy('title')->get();
        return view('admin.discounts.edit', compact('discount', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $discount = BookDiscount::findOrFail($id);
        
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'discount_type' => 'required|in:amount,percent',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Validate sensible ranges for the chosen book
            $book = Book::findOrFail($request->book_id);
            if ($request->discount_type === 'percent' && ($request->discount_value <= 0 || $request->discount_value > 100)) {
                return back()->withInput()->with('error', 'Percentage discount must be between 1 and 100.');
            }
            if ($request->discount_type === 'amount' && $request->discount_value > $book->price) {
                return back()->withInput()->with('error', 'Fixed discount must be less than or equal to the book price (RM '.number_format($book->price, 2).').');
            }
            
            // If the discount is being activated and it's for a different book than before,
            // deactivate any existing active discounts for the new book
            if ($request->is_active && $request->book_id != $discount->book_id) {
                BookDiscount::where('book_id', $request->book_id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }
            
            // Update the discount
            $discount->book_id = $request->book_id;
            
            // Reset both discount fields first
            $discount->discount_amount = null;
            $discount->discount_percent = null;
            
            if ($request->discount_type === 'amount') {
                $discount->discount_amount = $request->discount_value;
            } else {
                $discount->discount_percent = $request->discount_value;
            }
            
            $discount->starts_at = $request->starts_at;
            $discount->ends_at = $request->ends_at;
            $discount->description = $request->description;
            // Toggles
            $discount->free_shipping = $request->boolean('free_shipping');
            $discount->is_active = $request->boolean('is_active');
            $discount->save();
            
            DB::commit();
            
            return redirect()->route('admin.discounts.index')
                ->with('success', 'Discount updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating discount: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $discount = BookDiscount::findOrFail($id);
            $discount->delete();
            
            return redirect()->route('admin.discounts.index')
                ->with('success', 'Discount deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting discount: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle the active status of the discount.
     */
    public function toggleActive(string $id)
    {
        try {
            $discount = BookDiscount::findOrFail($id);
            $book_id = $discount->book_id;
            
            DB::beginTransaction();
            
            if (!$discount->is_active) {
                // Deactivate any other active discounts for this book
                BookDiscount::where('book_id', $book_id)
                    ->where('id', '!=', $id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }
            
            // Toggle the status
            $discount->is_active = !$discount->is_active;
            $discount->save();
            
            DB::commit();
            
            $status = $discount->is_active ? 'activated' : 'deactivated';
            return redirect()->route('admin.discounts.index')
                ->with('success', "Discount {$status} successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating discount status: ' . $e->getMessage());
        }
    }
}
