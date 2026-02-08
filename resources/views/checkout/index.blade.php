@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 bg-gray-50/50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Page Header --}}
        <div class="mb-8" data-aos="fade-up">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('cart.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm border border-gray-100 hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
                    <p class="text-sm text-gray-500">Complete your order</p>
                </div>
            </div>
        </div>

        {{-- Progress Steps --}}
        <div class="mb-8" data-aos="fade-up" data-aos-delay="50">
            <div class="flex items-center justify-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Cart</span>
                </div>
                <div class="w-12 h-px bg-gray-300"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <span class="text-sm font-medium text-gray-900">Checkout</span>
                </div>
                <div class="w-12 h-px bg-gray-200"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="text-sm font-medium text-gray-400">Payment</span>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl" role="alert" data-aos="fade-up">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Checkout Form --}}
            <div class="lg:col-span-2 order-2 lg:order-1" data-aos="fade-up" data-aos-delay="100">
                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    {{-- Shipping Information --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Shipping Information</h2>
                                    <p class="text-sm text-gray-500">Where should we deliver your order?</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-5">
                            {{-- Contact Info --}}
                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" readonly 
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-700 cursor-not-allowed">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" readonly 
                                        class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-700 cursor-not-allowed">
                                </div>
                            </div>

                            {{-- Address --}}
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                                <input type="text" name="shipping_address" id="shipping_address" 
                                    value="{{ old('shipping_address', auth()->user()->address_line1) }}" required 
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200" 
                                    placeholder="Street address, P.O. box">
                                @error('shipping_address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- City, State, Postal --}}
                            <div class="grid md:grid-cols-3 gap-5">
                                <div>
                                    <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                    <input type="text" name="shipping_city" id="shipping_city" 
                                        value="{{ old('shipping_city', auth()->user()->city) }}" required 
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200" 
                                        placeholder="City">
                                    @error('shipping_city')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                                    <select name="shipping_state" id="shipping_state" required 
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200">
                                        <option value="">Select State</option>
                                        @php($states = ['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Pulau Pinang','Selangor','Terengganu','Kuala Lumpur','Putrajaya','Sabah','Sarawak','Labuan'])
                                        @foreach($states as $st)
                                            <option value="{{ $st }}" @selected(old('shipping_state', auth()->user()->state) === $st)>{{ $st }}</option>
                                        @endforeach
                                    </select>
                                    @error('shipping_state')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                                    <input type="text" name="shipping_postal_code" id="shipping_postal_code" 
                                        value="{{ old('shipping_postal_code', auth()->user()->postal_code) }}" required 
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200" 
                                        placeholder="50000">
                                    @error('shipping_postal_code')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="text" name="shipping_phone" id="shipping_phone" 
                                    value="{{ old('shipping_phone', auth()->user()->phone_number) }}" required 
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200" 
                                    placeholder="0123456789">
                                <p class="mt-1 text-xs text-gray-500">For delivery updates</p>
                                @error('shipping_phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Payment Information --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Payment Method</h2>
                                    <p class="text-sm text-gray-500">Secure payment via FPX</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            {{-- FPX Info --}}
                            <div class="p-4 bg-blue-50 rounded-xl mb-5">
                                <div class="flex gap-3">
                                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-blue-900">Secure Online Banking</p>
                                        <p class="text-xs text-blue-700 mt-1">You'll be redirected to ToyyibPay for secure FPX payment</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Banks --}}
                            <p class="text-sm font-medium text-gray-700 mb-3">Supported Banks</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">Maybank2U</span>
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">CIMB Clicks</span>
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">Public Bank</span>
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">RHB</span>
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">Hong Leong</span>
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">AmBank</span>
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-medium rounded-lg">+ More</span>
                            </div>
                        </div>
                    </div>

                    {{-- Hidden Fields --}}
                    <input type="hidden" name="coupon_code" id="applied-coupon-code">
                    <input type="hidden" name="discount_amount" id="applied-discount-amount" value="0">
                    <input type="hidden" name="shipping_region" id="shipping_region" value="">
                    <input type="hidden" name="shipping_customer_price" id="shipping_customer_price" value="0">
                    <input type="hidden" name="shipping_actual_cost" id="shipping_actual_cost" value="0">

                    {{-- Submit Button (Mobile) --}}
                    <div class="lg:hidden">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Proceed to Payment
                        </button>
                    </div>
                </form>
            </div>

            {{-- Order Summary Sidebar --}}
            <div class="lg:col-span-1 order-1 lg:order-2" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>

                    {{-- Items --}}
                    <div class="space-y-4 pb-4 border-b border-gray-100 max-h-64 overflow-y-auto">
                        @foreach($cart->items as $item)
                            <div class="flex gap-3">
                                <div class="w-14 h-20 flex-shrink-0">
                                    @if($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-gray-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $item->book->title }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-1">RM {{ number_format($item->book->final_price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Coupon Code --}}
                    <div class="py-4 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-700 mb-2">Have a coupon?</p>
                        <div class="flex gap-2">
                            <input type="text" id="coupon-code" placeholder="Enter code" 
                                class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400">
                            <button type="button" id="apply-coupon" class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                                Apply
                            </button>
                        </div>
                        <div id="coupon-message" class="text-sm mt-2 hidden"></div>
                    </div>

                    {{-- Totals --}}
                    <div class="py-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900" id="subtotal">
                                RM {{ number_format($cart->items->sum(function($item) { return $item->book->final_price * $item->quantity; }), 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium text-gray-900" id="shipping-amount">RM 0.00</span>
                        </div>
                        <div id="discount-row" class="justify-between text-sm hidden">
                            <span class="text-gray-600">Discount</span>
                            <span class="font-medium text-green-600" id="discount-amount">-RM 0.00</span>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-semibold text-gray-900">Total</span>
                            <span class="text-xl font-bold text-gray-900" id="total">
                                RM {{ number_format($cart->items->sum(function($item) { return $item->book->final_price * $item->quantity; }), 2) }}
                            </span>
                        </div>
                    </div>

                    {{-- Submit Button (Desktop) --}}
                    <div class="mt-6 hidden lg:block">
                        <button type="submit" form="checkout-form" onclick="document.querySelector('form[action*=checkout]').submit()" 
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Proceed to Payment
                        </button>
                        <p class="text-xs text-gray-500 text-center mt-2">You'll be redirected to ToyyibPay</p>
                    </div>

                    {{-- Security Badge --}}
                    <div class="mt-4 flex items-center justify-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span class="text-xs">256-bit SSL encryption</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
            return parseFloat(text.replace('RM', '').replace('Free', '0').trim());
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
            
            applyCouponBtn.disabled = true;
            applyCouponBtn.innerText = 'Applying...';
            
            const subtotal = parseAmount(subtotalElement.innerText);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
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
                    showMessage(data.message, 'success');
                    discountRow.classList.remove('hidden');
                    discountRow.classList.add('flex');
                    discountAmount.innerText = `-RM ${data.discount_amount.toFixed(2)}`;
                    appliedCouponInput.value = couponCode;
                    appliedDiscountInput.value = data.discount_amount;
                    couponCodeInput.disabled = true;
                    applyCouponBtn.innerText = 'Applied';
                    applyCouponBtn.disabled = true;
                    applyCouponBtn.classList.remove('bg-gray-900', 'hover:bg-gray-800');
                    applyCouponBtn.classList.add('bg-green-600');
                    updateTotal();

                    try {
                        const stateEl = document.getElementById('shipping_state');
                        if (stateEl && stateEl.value) {
                            fetchPostage(stateEl.value);
                        }
                    } catch (e) {}
                } else {
                    showMessage(data.message, 'error');
                    appliedCouponInput.value = '';
                    appliedDiscountInput.value = '0';
                }
            })
            .catch(error => {
                applyCouponBtn.disabled = false;
                applyCouponBtn.innerText = 'Apply';
                showMessage('An error occurred. Please try again.', 'error');
            });
        });
        
        function showMessage(message, type) {
            couponMessage.innerText = message;
            couponMessage.classList.remove('hidden', 'text-red-600', 'text-green-600');
            couponMessage.classList.add(type === 'error' ? 'text-red-600' : 'text-green-600');
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
                    shippingAmount.innerHTML = '<span class="text-green-600 font-medium">Free</span>';
                } else {
                    shippingAmount.innerText = `RM ${price.toFixed(2)}`;
                }
                shippingRegionInput.value = data.region || '';
                shippingCustomerPriceInput.value = price.toFixed(2);
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

        if (shippingState.value) fetchPostage(shippingState.value);
        shippingState.addEventListener('change', function() {
            fetchPostage(this.value);
        });
    });
</script>
@endsection
