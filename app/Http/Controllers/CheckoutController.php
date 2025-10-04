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
            'shipping_region' => 'nullable|in:sm,sabah,sarawak,labuan',
            'shipping_customer_price' => 'nullable|numeric|min:0',
            'shipping_actual_cost' => 'nullable|numeric|min:0',
        ]);
        
        // Calculate subtotal amount
        $totalAmount = 0;
        foreach ($cart->items as $item) {
            $totalAmount += $item->book->price * $item->quantity;
        }

        // Determine shipping region and rate
        $state = strtolower($request->shipping_state);
        $smStates = ['johor','kedah','kelantan','melaka','negeri sembilan','pahang','perak','perlis','pulau pinang','penang','selangor','terengganu','kuala lumpur','putrajaya'];
        $region = 'sm';
        if (in_array($state, ['sabah'])) { $region = 'sabah'; }
        elseif (in_array($state, ['sarawak'])) { $region = 'sarawak'; }
        elseif (in_array($state, ['labuan','wilayah persekutuan labuan'])) { $region = 'labuan'; }
        elseif (!in_array($state, $smStates)) { $region = 'sm'; }

        $rateModel = \App\Models\PostageRate::where('region', $region === 'labuan' ? 'sabah' : $region)->first();
        $shippingCustomerPrice = $rateModel?->customer_price ?? 0;
        $shippingActualCost = $rateModel?->actual_cost ?? 0;

        // Check for free shipping via promotions or coupons
        $isFreeShipping = false;
        // Coupon free shipping
        $appliedCouponCode = $request->input('coupon_code');
        if ($appliedCouponCode) {
            $coupon = \App\Models\Coupon::where('code', $appliedCouponCode)->first();
            if ($coupon && $coupon->is_active && now()->between($coupon->starts_at, $coupon->expires_at)) {
                if ($coupon->free_shipping) {
                    $isFreeShipping = true;
                }
            }
        }
        // Book discounts or flash sales on cart items
        if (!$isFreeShipping) {
            foreach ($cart->items as $item) {
                $book = $item->book;
                // Flash sale free shipping
                if ($book->active_flash_sale && $book->active_flash_sale->free_shipping) {
                    $isFreeShipping = true;
                    break;
                }
                // Book discount free shipping
                if ($book->discount && $book->discount->free_shipping) {
                    $isFreeShipping = true;
                    break;
                }
            }
        }

        if ($isFreeShipping) {
            $shippingCustomerPrice = 0;
        }

        // Add shipping to total
        $totalAmount += $shippingCustomerPrice;
        
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
                'shipping_region' => $region,
                'shipping_customer_price' => $shippingCustomerPrice,
                'shipping_actual_cost' => $shippingActualCost,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_phone' => $request->shipping_phone,
                'is_free_shipping' => $isFreeShipping,
            ]);
            
            // Create order items and update stock
            foreach ($cart->items as $item) {
                // Check if there's enough stock
                if ($item->book->stock < $item->quantity) {
                    throw new \Exception("Not enough stock for {$item->book->title}");
                }
                
                // Create order item with cost tracking
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->price,
                    'cost_price' => $item->book->cost_price,
                    'total_selling' => $item->book->price * $item->quantity,
                    'total_cost' => ($item->book->cost_price ?? 0) * $item->quantity,
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
