@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-serif font-bold text-gray-900 mb-6">Checkout</h1>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-1 order-2 lg:order-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($cart->items as $item)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-16 w-12">
                                    @if($item->book->cover_image)
                                        <img class="h-16 w-12 object-cover rounded" src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}">
                                    @else
                                        <div class="h-16 w-12 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900">{{ $item->book->title }}</h3>
                                            <p class="text-sm text-gray-500">{{ $item->book->author }}</p>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">RM {{ number_format($item->book->price * $item->quantity, 2) }}</p>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Coupon Code -->
                    <div class="mb-4">
                        <div class="flex space-x-2">
                            <input type="text" id="coupon-code" placeholder="Enter coupon code" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 text-sm">
                            <button type="button" id="apply-coupon" class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Apply
                            </button>
                        </div>
                        <div id="coupon-message" class="text-sm mt-1 hidden"></div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Subtotal</span>
                            <span class="text-gray-900 font-medium" id="subtotal">
                                RM {{ number_format($cart->items->sum(function($item) { return $item->book->final_price * $item->quantity; }), 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Shipping</span>
                            <span class="text-gray-900 font-medium" id="shipping-amount">RM 0.00</span>
                        </div>
                        <div id="discount-row" class="justify-between mb-2 hidden">
                            <span class="text-gray-700">Discount</span>
                            <span class="text-green-600 font-medium" id="discount-amount">-RM 0.00</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-4 mt-4">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-purple-600" id="total">
                                RM {{ number_format($cart->items->sum(function($item) { return $item->book->final_price * $item->quantity; }), 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="lg:col-span-2 order-1 lg:order-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h2>
                    
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" readonly class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" readonly class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address', auth()->user()->address_line1) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            @error('shipping_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city', auth()->user()->city) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                @error('shipping_city')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                <select name="shipping_state" id="shipping_state" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                    <option value="">-- Select State --</option>
                                    @php($states = ['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Pulau Pinang','Selangor','Terengganu','Kuala Lumpur','Putrajaya','Sabah','Sarawak','Labuan'])
                                    @foreach($states as $st)
                                        <option value="{{ $st }}" @selected(old('shipping_state', auth()->user()->state) === $st)>{{ $st }}</option>
                                    @endforeach
                                </select>
                                @error('shipping_state')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                <input type="text" name="shipping_postal_code" id="shipping_postal_code" value="{{ old('shipping_postal_code', auth()->user()->postal_code) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                @error('shipping_postal_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone_number) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            @error('shipping_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <h2 class="text-lg font-semibold text-gray-900 mb-4 mt-8">Payment Information</h2>
                        <p class="text-gray-500 mb-6">This is a demo application. No actual payment will be processed.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                <input type="text" id="card_number" value="4242 4242 4242 4242" class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" readonly>
                            </div>
                            
                            <div>
                                <label for="card_name" class="block text-sm font-medium text-gray-700 mb-1">Name on Card</label>
                                <input type="text" id="card_name" value="Demo User" class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" readonly>
                            </div>

                            <div>
                                <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                <input type="text" id="card_expiry" value="12/25" class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" readonly>
                            </div>

                            <div>
                                <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                <input type="text" id="card_cvv" value="123" class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" readonly>
                            </div>
                        </div>

                        <!-- Hidden field for coupon code -->
                        <input type="hidden" name="coupon_code" id="applied-coupon-code">
                        <input type="hidden" name="discount_amount" id="applied-discount-amount" value="0">
                        
                        <input type="hidden" name="shipping_region" id="shipping_region" value="">
                        <input type="hidden" name="shipping_customer_price" id="shipping_customer_price" value="0">
                        <input type="hidden" name="shipping_actual_cost" id="shipping_actual_cost" value="0">

                        <div class="mt-8">
                            <button type="submit" class="w-full px-4 py-3 bg-purple-600 text-white text-center font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                Complete Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Coupon JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const couponCodeInput = document.getElementById('coupon-code');
            const applyCouponBtn = document.getElementById('apply-coupon');
            const couponMessage = document.getElementById('coupon-message');
            const discountRow = document.getElementById('discount-row');
            const discountAmount = document.getElementById('discount-amount');
            const subtotalElement = document.getElementById('subtotal');
            const totalElement = document.getElementById('total');
            const appliedCouponInput = document.getElementById('applied-coupon-code');
            const appliedDiscountInput = document.getElementById('applied-discount-amount');
            
            function parseAmount(text) {
                return parseFloat(text.replace('RM', '').trim());
            }
            function updateTotal() {
                const subtotal = parseAmount(subtotalElement.innerText);
                const shipping = parseFloat(document.getElementById('shipping_customer_price').value || '0');
                const discount = parseFloat(appliedDiscountInput.value || '0');
                const newTotal = subtotal + shipping - discount;
                totalElement.innerText = `RM ${newTotal.toFixed(2)}`;
            }
            
            applyCouponBtn.addEventListener('click', function() {
                const couponCode = couponCodeInput.value.trim();
                
                if (!couponCode) {
                    showMessage('Please enter a coupon code.', 'error');
                    return;
                }
                
                // Show loading state
                applyCouponBtn.disabled = true;
                applyCouponBtn.innerText = 'Applying...';
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Make API request to validate coupon
                fetch(`/api/coupons/validate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        code: couponCode,
                        amount: subtotal
                    })
                })
                .then(response => response.json())
                .then(data => {
                    applyCouponBtn.disabled = false;
                    applyCouponBtn.innerText = 'Apply';
                    
                    if (data.valid) {
                        // Show success message
                        showMessage(data.message, 'success');
                        
                        // Update discount amount
                        discountRow.classList.remove('hidden');
                        discountAmount.innerText = `-RM ${data.discount_amount.toFixed(2)}`;
                        
                        // Update total
                        updateTotal();
                        
                        // Store coupon code and discount amount in hidden inputs
                        appliedCouponInput.value = couponCode;
                        appliedDiscountInput.value = data.discount_amount;
                        
                        // Disable coupon input and button
                        couponCodeInput.disabled = true;
                        applyCouponBtn.innerText = 'Applied';
                        applyCouponBtn.disabled = true;

                        // Re-fetch postage with potential free shipping from coupon
                        try {
                            const stateEl = document.getElementById('shipping_state');
                            if (stateEl && stateEl.value) {
                                fetchPostage(stateEl.value);
                            }
                        } catch (e) { /* no-op */ }
                    } else {
                        // Show error message
                        showMessage(data.message, 'error');
                        
                        // Reset coupon code
                        appliedCouponInput.value = '';
                        appliedDiscountInput.value = '0';
                    }
                })
                .catch(error => {
                    applyCouponBtn.disabled = false;
                    applyCouponBtn.innerText = 'Apply';
                    showMessage('An error occurred. Please try again.', 'error');
                    console.error('Error:', error);
                });
            });
            
            // Function to show message
            function showMessage(message, type) {
                couponMessage.innerText = message;
                couponMessage.classList.remove('hidden', 'text-red-500', 'text-green-500');
                
                if (type === 'error') {
                    couponMessage.classList.add('text-red-500');
                } else {
                    couponMessage.classList.add('text-green-500');
                }
            }
            const shippingState = document.getElementById('shipping_state');
            const shippingAmount = document.getElementById('shipping-amount');
            const shippingRegionInput = document.getElementById('shipping_region');
            const shippingCustomerPriceInput = document.getElementById('shipping_customer_price');
            const shippingActualCostInput = document.getElementById('shipping_actual_cost');

            function fetchPostage(state) {
                if (!state) {
                    shippingAmount.innerText = 'RM 0.00';
                    shippingRegionInput.value = '';
                    shippingCustomerPriceInput.value = '0';
                    shippingActualCostInput.value = '0';
                    updateTotal();
                    return;
                }
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(`/api/postage/rate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ state, coupon_code: document.getElementById('applied-coupon-code').value || '' })
                })
                .then(r => r.json())
                .then(data => {
                    const price = parseFloat(data.customer_price || 0);
                    if (data.is_free_shipping) {
                        shippingAmount.innerText = 'Free';
                    } else {
                        shippingAmount.innerText = `RM ${price.toFixed(2)}`;
                    }
                    shippingRegionInput.value = data.region || '';
                    shippingCustomerPriceInput.value = price.toFixed(2);
                    // actual cost is unknown in UI; controller will fill based on region
                    updateTotal();
                })
                .catch(() => {
                    shippingAmount.innerText = 'RM 0.00';
                    shippingRegionInput.value = '';
                    shippingCustomerPriceInput.value = '0';
                    shippingActualCostInput.value = '0';
                    updateTotal();
                });
            }

            // initial
            if (shippingState.value) fetchPostage(shippingState.value);
            shippingState.addEventListener('change', function() {
                fetchPostage(this.value);
            });
        });
    </script>
@endsection
