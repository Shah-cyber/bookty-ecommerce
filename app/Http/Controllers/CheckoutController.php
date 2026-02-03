<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PostageRateService;
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

        // HYBRID APPROACH: Get current history record for audit trail
        $postageRateService = app(PostageRateService::class);
        $historyRecord = $postageRateService->getCurrentHistory($region === 'labuan' ? 'sabah' : $region);
        
        // Fallback to direct model if no history (shouldn't happen after seeding)
        if (!$historyRecord) {
            $rateModel = \App\Models\PostageRate::where('region', $region === 'labuan' ? 'sabah' : $region)->first();
            $shippingCustomerPrice = $rateModel?->customer_price ?? 0;
            $shippingActualCost = $rateModel?->actual_cost ?? 0;
            $historyRecordId = null;
        } else {
            $shippingCustomerPrice = $historyRecord->customer_price;
            $shippingActualCost = $historyRecord->actual_cost;
            $historyRecordId = $historyRecord->id;
        }

        // Check for free shipping via promotions or coupons
        $isFreeShipping = false;
        $appliedCouponCode = $request->input('coupon_code');
        $appliedCoupon = null;
        $couponDiscount = 0;
        
        if ($appliedCouponCode) {
            $coupon = \App\Models\Coupon::where('code', $appliedCouponCode)->first();
            if ($coupon && $coupon->isValidFor(Auth::user(), $totalAmount)) {
                $appliedCoupon = $coupon;
                
                // Calculate coupon discount
                $couponDiscount = $coupon->calculateDiscount($totalAmount);
                
                // Check for free shipping
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

        // Apply coupon discount to subtotal (before shipping)
        $subtotalBeforeDiscount = $totalAmount;
        $totalAmount -= $couponDiscount;
        
        // Add shipping to total
        $totalAmount += $shippingCustomerPrice;
        
        // --- End Calculation Logic ---

        
        // === REWRITTEN ATOMIC TRANSACTION ===
        try {
            // 1. Start the database transaction
            DB::beginTransaction();
            
            // 2. Create the order with HYBRID APPROACH
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_region' => $region,
                
                // HYBRID: Denormalized prices (for fast queries) ✅
                'shipping_customer_price' => $shippingCustomerPrice,
                'shipping_actual_cost' => $shippingActualCost,
                
                // HYBRID: History FK (for audit trail) ✅
                'postage_rate_history_id' => $historyRecordId,
                
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_phone' => $request->shipping_phone,
                'is_free_shipping' => $isFreeShipping,
                
                // Coupon information (usage recorded after successful payment)
                'coupon_id' => $appliedCoupon?->id,
                'coupon_code' => $appliedCoupon?->code,
                'discount_amount' => $couponDiscount,
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

                // 6.5. SUCCESS: Auto-save shipping info to user profile if profile is incomplete
                // This improves UX by automatically filling profile from checkout data
                /** @var \App\Models\User $user */
                $user = Auth::user();
                $profileUpdated = false;
                
                // Only update if the field is empty (don't overwrite existing data)
                if (empty($user->address_line1) && !empty($request->shipping_address)) {
                    $user->address_line1 = $request->shipping_address;
                    $profileUpdated = true;
                }
                if (empty($user->city) && !empty($request->shipping_city)) {
                    $user->city = $request->shipping_city;
                    $profileUpdated = true;
                }
                if (empty($user->state) && !empty($request->shipping_state)) {
                    $user->state = $request->shipping_state;
                    $profileUpdated = true;
                }
                if (empty($user->postal_code) && !empty($request->shipping_postal_code)) {
                    $user->postal_code = $request->shipping_postal_code;
                    $profileUpdated = true;
                }
                if (empty($user->phone_number) && !empty($request->shipping_phone)) {
                    $user->phone_number = $request->shipping_phone;
                    $profileUpdated = true;
                }
                
                if ($profileUpdated) {
                    $user->save();
                }

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
        $apiUrl = config('services.toyyibpay.api_url', 'https://dev.toyyibpay.com/index.php/api/createBill');

        if (!$secretKey || !$categoryCode) {
            Log::error("ToyyibPay Configuration Missing", [
                'has_secret_key' => !empty($secretKey),
                'has_category_code' => !empty($categoryCode)
            ]);
            
            return [
                'success' => false,
                'message' => 'ToyyibPay configuration is missing. Please check your .env file. Make sure TOYYIBPAY_SECRET_KEY and TOYYIBPAY_CATEGORY_CODE are set.'
            ];
        }

        // Validate required bill data
        $requiredFields = ['bill_name', 'bill_description', 'amount', 'return_url', 'callback_url', 'reference_no', 'customer_name', 'customer_email', 'customer_phone'];
        foreach ($requiredFields as $field) {
            if (empty($billData[$field])) {
                Log::error("ToyyibPay Missing Required Field", ['field' => $field]);
                return [
                    'success' => false,
                    'message' => "Missing required field: {$field}"
                ];
            }
        }

        try {
            // Increase timeout and add retry logic for ToyyibPay server issues
            $response = Http::timeout(60)
                ->retry(2, 2000) // Retry 2 times with 2 second delay
                ->asForm()
                ->post($apiUrl, [
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
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error("ToyyibPay Connection Error", [
                'message' => $e->getMessage(),
                'url' => $apiUrl
            ]);
            
            return [
                'success' => false,
                'message' => 'Unable to connect to payment gateway. The payment service may be temporarily unavailable. Please try again in a few minutes.'
            ];
        } catch (\Illuminate\Http\Client\RequestException $e) {
            // Handle timeout and gateway errors
            $statusCode = $e->response?->status();
            
            Log::error("ToyyibPay Request Exception", [
                'message' => $e->getMessage(),
                'status_code' => $statusCode,
                'url' => $apiUrl
            ]);
            
            if ($statusCode == 504 || $statusCode == 502 || $statusCode == 503) {
                return [
                    'success' => false,
                    'message' => 'Payment gateway is temporarily unavailable (Server timeout). Please try again in a few minutes. If the problem persists, the payment service may be experiencing issues.'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Payment gateway error: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            Log::error("ToyyibPay Request Exception", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Payment gateway error: ' . $e->getMessage()
            ];
        }

        // Log the status code and response body for debugging
        Log::info("ToyyibPay API Request", [
            'url' => $apiUrl,
            'data' => [
                'billName' => $billData['bill_name'],
                'billAmount' => $billData['amount'],
                'customerEmail' => $billData['customer_email'],
                'categoryCode' => $categoryCode,
            ]
        ]);
        
        Log::info("ToyyibPay API Response Status: " . $response->status());
        Log::info("ToyyibPay API Response Body: " . $response->body());

        $responseBody = trim($response->body());
        $result = $response->json();

        // Check for gateway timeout or server errors
        if ($response->status() == 504 || $response->status() == 502 || $response->status() == 503) {
            Log::error("ToyyibPay Server Error", [
                'status' => $response->status(),
                'response_body' => $responseBody,
                'url' => $apiUrl
            ]);
            
            return [
                'success' => false,
                'message' => 'Payment gateway server is temporarily unavailable (Gateway Timeout). This is a server-side issue with the payment provider. Please try again in a few minutes.'
            ];
        }
        
        // Check if response is successful (HTTP 200)
        if ($response->successful()) {
            // FIRST: Try to parse as JSON and check for SUCCESS (BillCode exists)
            if ($result !== null && is_array($result) && isset($result[0])) {
                // Check for SUCCESS first - if BillCode exists, it's a success!
                if (isset($result[0]['BillCode']) && !empty($result[0]['BillCode'])) {
                    $billCode = $result[0]['BillCode'];
                    Log::info("ToyyibPay Bill Created Successfully", [
                        'bill_code' => $billCode,
                        'order_reference' => $billData['reference_no']
                    ]);
                    
                    return [
                        'success' => true,
                        'bill_code' => $billCode,
                        'payment_url' => "https://dev.toyyibpay.com/{$billCode}"
                    ];
                }
                
                // Check if the response contains an error message (ToyyibPay returns errors even with 200 status)
                if (isset($result[0]['msg'])) {
                    $errorMessage = $result[0]['msg'];
                    Log::error("ToyyibPay API Error Message", [
                        'message' => $errorMessage,
                        'full_response' => $result
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => 'Payment gateway error: ' . $errorMessage
                    ];
                }
                
                // Check if response contains error code
                if (isset($result[0]['code']) && $result[0]['code'] != '0') {
                    $errorMessage = $result[0]['msg'] ?? 'Unknown error from payment gateway';
                    Log::error("ToyyibPay API Error Code", [
                        'code' => $result[0]['code'],
                        'message' => $errorMessage,
                        'full_response' => $result
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => 'Payment gateway error: ' . $errorMessage
                    ];
                }
            }
            
            // SECOND: If not valid JSON or no BillCode, check for plain text error responses
            // Only check for error patterns if it's NOT valid JSON with BillCode
            if ($result === null || !isset($result[0]['BillCode'])) {
                // Check for plain text error responses (ToyyibPay sometimes returns plain text errors)
                // Only match if it's a known error pattern, not JSON
                if (preg_match('/\[(CATEGORY-NOT-MATCH|INVALID-SECRET-KEY|INVALID-CATEGORY|.*?)\]/', $responseBody, $matches)) {
                    $errorCode = $matches[1];
                    
                    // Skip if it looks like JSON (contains quotes and BillCode)
                    if (strpos($errorCode, 'BillCode') !== false || strpos($errorCode, '"') !== false) {
                        // This is actually JSON, not an error - skip this check
                    } else {
                        $errorMessages = [
                            'CATEGORY-NOT-MATCH' => 'The category code does not match your ToyyibPay account. Please check your TOYYIBPAY_CATEGORY_CODE in .env file.',
                            'INVALID-SECRET-KEY' => 'Invalid secret key. Please check your TOYYIBPAY_SECRET_KEY in .env file.',
                            'INVALID-CATEGORY' => 'Invalid category code. Please verify the category exists in your ToyyibPay dashboard.',
                        ];
                        
                        $errorMessage = $errorMessages[$errorCode] ?? "Payment gateway error: [{$errorCode}]";
                        
                        Log::error("ToyyibPay API Plain Text Error", [
                            'error_code' => $errorCode,
                            'response_body' => $responseBody,
                            'category_code_used' => $categoryCode
                        ]);
                        
                        return [
                            'success' => false,
                            'message' => $errorMessage
                        ];
                    }
                }
                
                // If response is not valid JSON and no error pattern matched
                if ($result === null && !empty($responseBody)) {
                    Log::error("ToyyibPay API Invalid JSON Response", [
                        'response_body' => $responseBody,
                        'category_code_used' => $categoryCode
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => 'Payment gateway returned an invalid response. Please check your ToyyibPay configuration.'
                    ];
                }
            }
        }

        // Log the error if the bill creation failed
        Log::error("ToyyibPay Error: Failed to create bill", [
            'status' => $response->status(),
            'response_body' => $responseBody,
            'response_json' => $result,
            'request_data' => [
                'billName' => $billData['bill_name'],
                'amount' => $billData['amount'],
                'categoryCode' => $categoryCode,
            ]
        ]);
        
        // Extract error message from response if available
        $errorMessage = 'Failed to create payment bill.';
        if (isset($result[0]['msg'])) {
            $errorMessage = $result[0]['msg'];
        } elseif (isset($result['msg'])) {
            $errorMessage = $result['msg'];
        } elseif (is_string($result)) {
            $errorMessage = $result;
        } elseif (!empty($responseBody)) {
            // Try to extract error from plain text response
            if (preg_match('/\[(.*?)\]/', $responseBody, $matches)) {
                $errorCode = $matches[1];
                $errorMessage = "Payment gateway error: [{$errorCode}]";
            } else {
                $errorMessage = "Payment gateway error: " . substr($responseBody, 0, 100);
            }
        }
        
        return [
            'success' => false,
            'message' => $errorMessage
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
