<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart;
        
        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }
        
        $cart->load('items.book');
        
        return view('cart.index', compact('cart'));
    }
    
    public function add(Request $request, Book $book)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $book->stock,
        ]);
        
        $cart = Auth::user()->cart;
        
        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }
        
        // Check if the book is already in the cart
        $cartItem = $cart->items()->where('book_id', $book->id)->first();
        
        if ($cartItem) {
            // Update quantity if the book is already in the cart
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($newQuantity > $book->stock) {
                return back()->with('error', "⚠️ Sorry! Only {$book->stock} copies of '{$book->title}' are available.");
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Add new item to cart
            $cart->items()->create([
                'book_id' => $book->id,
                'quantity' => $request->quantity,
            ]);
        }
        
        return back()->with('success', "🛒 '{$book->title}' has been added to your cart!");
    }
    
    public function update(Request $request, CartItem $cartItem)
    {
        // Check if the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->book->stock,
        ]);
        
        $cartItem->update(['quantity' => $request->quantity]);
        
        return back()->with('success', '✅ Cart updated successfully!');
    }
    
    public function remove(CartItem $cartItem)
    {
        // Check if the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }
        
        $cartItem->delete();
        
        return back()->with('success', '🗑️ Item removed from cart.');
    }
}
