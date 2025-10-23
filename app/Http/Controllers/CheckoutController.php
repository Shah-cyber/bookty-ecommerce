<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            'shipping_phone' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'shipping_region' => 'nullable|in:sm,sabah,sarawak,labuan',
            'shipping_customer_price' => 'nullable|numeric|min:0',
            'shipping_actual_cost' => 'nullable|numeric|min:0',
        ]);
        
        // --- Start Calculation Logic (Same as before) ---
        
        // Calculate subtotal amount
        $totalAmount = 0;
        foreach ($cart->items as $item) {
            $totalAmount += $item->book->price * $item->quantity;
        }

        // Determine shipping region and rate
        $state = strtolower($request->shipping_state);
        $smStates = ['johor','kedah','kelantan','melaka','negeri sembilan','pahang','perak','perlis','pulau pinang','penang','selangor','terengguanu','kuala lumpur','putrajaya'];
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
        $appliedCouponCode = $request->input('coupon_code');
        if ($appliedCouponCode) {
            $coupon = \App\Models\Coupon::where('code', $appliedCouponCode)->first();
            if ($coupon && $coupon->is_active && now()->between($coupon->starts_at, $coupon->expires_at)) {
                if ($coupon->free_shipping) {
                    $isFreeShipping = true;
                }
            }
        }

        if (!$isFreeShipping) {
            foreach ($cart->items as $item) {
                $book = $item->book;
                if (($book->active_flash_sale && $book->active_flash_sale->free_shipping) ||
                    ($book->discount && $book->discount->free_shipping)) {
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
        
        // --- End Calculation Logic ---

        
        // === REWRITTEN ATOMIC TRANSACTION ===
        try {
            // 1. Start the database transaction
            DB::beginTransaction();
            
            // 2. Create the order
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
            
            // 3. Create order items and update stock
            foreach ($cart->items as $item) {
                // Lock the book row for update to prevent race conditions
                $book = $item->book()->lockForUpdate()->first();
                
                if ($book->stock < $item->quantity) {
                    // This will trigger the rollback
                    throw new \Exception("Not enough stock for {$book->title}");
                }
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $book->price,
                    'cost_price' => $book->cost_price,
                    'total_selling' => $book->price * $item->quantity,
                    'total_cost' => ($book->cost_price ?? 0) * $item->quantity,
                ]);
                
                // Update book stock
                $book->decrement('stock', $item->quantity);
            }
            
            // 4. Create ToyyibPay bill *inside* the transaction
            $billData = [
                'bill_name' => 'Bookty Order #' . $order->public_id,
                'bill_description' => 'Payment for order #' . $order->public_id,
                'amount' => $this->convertToCents($totalAmount),
                'return_url' => route('toyyibpay.return'),
                'callback_url' => route('toyyibpay.callback'),
                'reference_no' => $order->public_id,
                'customer_name' => Auth::user()->name,
                'customer_email' => Auth::user()->email,
                'customer_phone' => $this->formatPhoneNumber($request->shipping_phone),
                'email_content' => 'Thank you for your purchase! Your order #' . $order->public_id . ' has been received.',
            ];

            $paymentResult = $this->createToyyibPayBill($billData);

            // 5. Check if bill creation was successful
            if ($paymentResult['success']) {
                // 6. SUCCESS: Update the order with payment info
                $order->update([
                    'toyyibpay_bill_code' => $paymentResult['bill_code'],
                    'toyyibpay_payment_url' => $paymentResult['payment_url'],
                ]);

                // 7. SUCCESS: Clear the cart
                $cart->items()->delete();
                
                // 8. SUCCESS: Commit all changes to the database
                DB::commit();
                
                // 9. SUCCESS: Redirect to the payment gateway
                return redirect($paymentResult['payment_url']);

            } else {
                // 10. FAIL: Bill creation failed. Throw an exception to
                // trigger the rollback and undo everything.
                throw new \Exception($paymentResult['message'] ?? 'Payment gateway is unavailable. Please try again.');
            }
            
        } catch (\Exception $e) {
            // 11. CATCH: An error occurred (stock, payment, etc.)
            // Roll back all database changes (order, stock, etc.)
            DB::rollBack();
            
            // Send the user back to the checkout page with the error message
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

    /**
     * Create ToyyibPay bill using direct API call
     */
    private function createToyyibPayBill($billData)
    {
        $secretKey = config('services.toyyibpay.secret_key');
        $categoryCode = config('services.toyyibpay.category_code');

        if (!$secretKey || !$categoryCode) {
            return [
                'success' => false,
                'message' => 'ToyyibPay configuration is missing. Please check your .env file.'
            ];
        }

        $response = Http::asForm()->post('https://dev.toyyibpay.com/index.php/api/createBill', [
            'userSecretKey' => $secretKey,
            'categoryCode' => $categoryCode,
            'billName' => $billData['bill_name'],
            'billDescription' => $billData['bill_description'],
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $billData['amount'], // In cents
            'billReturnUrl' => $billData['return_url'],
            'billCallbackUrl' => $billData['callback_url'],
            'billExternalReferenceNo' => $billData['reference_no'],
            'billTo' => $billData['customer_name'],
            'billEmail' => $billData['customer_email'],
            'billPhone' => $billData['customer_phone'],
            'billPaymentChannel' => 0, // FPX only
            'billContentEmail' => $billData['email_content'],
            'billChargeToCustomer' => 0, // Charge FPX to customer
            'billExpiryDays' => 3
        ]);

        // Log the status code and response body for debugging
        Log::info("ToyyibPay API Response Status: " . $response->status());
        Log::info("ToyyibPay API Response Body: " . $response->body());

        $result = $response->json();

        if ($response->successful()) {
            if (isset($result[0]['BillCode'])) {
                $billCode = $result[0]['BillCode'];
                return [
                    'success' => true,
                    'bill_code' => $billCode,
                    'payment_url' => "https://dev.toyyibpay.com/{$billCode}"
                ];
            }
        }

        // Log the error if the bill creation failed
        Log::error("ToyyibPay Error: Failed to create bill. Response: " . json_encode($result));
        return [
            'success' => false,
            'message' => 'Failed to create ToyyibPay bill. Please try again.'
        ];
    }

    /**
     * Convert amount to cents (ToyyibPay requirement)
     */
    private function convertToCents($amount)
    {
        return (int) round($amount * 100);
    }

    /**
     * Format phone number for ToyyibPay (Malaysian format)
     */
    private function formatPhoneNumber($phone)
    {
        // Remove all non-numeric characters except +
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // If it starts with +60, keep it as is
        if (str_starts_with($phone, '+60')) {
            return $phone;
        }
        
        // If it starts with 60, add +
        if (str_starts_with($phone, '60')) {
            return '+' . $phone;
        }
        
        // If it starts with 0, replace with +60
        if (str_starts_with($phone, '0')) {
            return '+60' . substr($phone, 1);
        }
        
        // If it's just numbers, assume it's a Malaysian number
        if (preg_match('/^[0-9]+$/', $phone)) {
            // If it's 10 digits starting with 1, add +60
            if (strlen($phone) === 10 && str_starts_with($phone, '1')) {
                return '+60' . $phone;
            }
            // If it's 11 digits starting with 01, replace 01 with +60
            if (strlen($phone) === 11 && str_starts_with($phone, '01')) {
                return '+60' . substr($phone, 1);
            }
            // If it's 9 digits, add +601
            if (strlen($phone) === 9) {
                return '+601' . $phone;
            }
        }
        
        // For international numbers that don't start with +60, use a default Malaysian number
        // This handles cases like +1 (284) 719-9039 which are not Malaysian numbers
        if (str_starts_with($phone, '+') && !str_starts_with($phone, '+60')) {
            // Use a default Malaysian number for testing
            return '+60123456789';
        }
        
        // Default: add +60 prefix
        return '+60' . $phone;
    }
}
