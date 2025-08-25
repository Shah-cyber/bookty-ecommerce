<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        $cart->load('items.book');
        
        return view('checkout.index', compact('cart'));
    }
    
    public function process(Request $request)
    {
        $cart = Auth::user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_phone' => 'required|string|max:20',
        ]);
        
        // Calculate total amount
        $totalAmount = 0;
        foreach ($cart->items as $item) {
            $totalAmount += $item->book->price * $item->quantity;
        }
        
        try {
            DB::beginTransaction();
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_phone' => $request->shipping_phone,
            ]);
            
            // Create order items and update stock
            foreach ($cart->items as $item) {
                // Check if there's enough stock
                if ($item->book->stock < $item->quantity) {
                    throw new \Exception("Not enough stock for {$item->book->title}");
                }
                
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->price,
                ]);
                
                // Update book stock
                $item->book->decrement('stock', $item->quantity);
            }
            
            // Clear the cart
            $cart->items()->delete();
            
            DB::commit();
            
            // For a real application, we would process payment here
            // For now, we'll just simulate a successful payment
            $order->update(['payment_status' => 'paid']);
            
            return redirect()->route('checkout.success', ['order' => $order->id]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function success(Request $request)
    {
        $order = Order::findOrFail($request->order);
        
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized action.');
        }
        
        $order->load('items.book');
        
        return view('checkout.success', compact('order'));
    }
}
