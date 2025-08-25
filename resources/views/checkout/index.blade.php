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

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Subtotal</span>
                            <span class="text-gray-900 font-medium">
                                RM {{ number_format($cart->items->sum(function($item) { return $item->book->price * $item->quantity; }), 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Shipping</span>
                            <span class="text-gray-900 font-medium">Free</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-4 mt-4">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-purple-600">
                                RM {{ number_format($cart->items->sum(function($item) { return $item->book->price * $item->quantity; }), 2) }}
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
                                <input type="text" name="shipping_state" id="shipping_state" value="{{ old('shipping_state', auth()->user()->state) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
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
@endsection
