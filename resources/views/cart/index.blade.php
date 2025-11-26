@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-serif font-bold text-gray-900 mb-6">Your Shopping Cart</h1>

        {{-- @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif --}}

        @if($cart->items->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="text-gray-500 mb-4">Your cart is empty.</p>
                <a href="{{ route('books.index') }}" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    Browse Books
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cart->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
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
                                            <div class="ml-4">
                                                <a href="{{ route('books.show', $item->book) }}" class="text-sm font-medium text-gray-900 hover:text-purple-600">{{ $item->book->title }}</a>
                                                <div class="text-sm text-gray-500">{{ $item->book->author }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">RM {{ $item->book->price }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->book->stock <= 0)
                                            <div class="text-sm text-red-600 font-medium">Out of stock</div>
                                        @else
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->book->stock }}" class="w-16 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                                <button type="submit" class="ml-2 text-sm text-purple-600 hover:text-purple-900">
                                                    Update
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">RM {{ number_format($item->book->price * $item->quantity, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Shipping Information Section -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 mb-1">Shipping Information</h3>
                        <p class="text-sm text-blue-700 mb-2">Shipping costs are calculated based on your delivery address.</p>
                        <div class="text-xs text-blue-600">
                            <p class="mb-1">• <strong>Peninsular Malaysia:</strong> RM 8.00 - RM 12.00</p>
                            <p class="mb-1">• <strong>East Malaysia:</strong> RM 15.00 - RM 20.00</p>
                            {{-- <p>• <strong>Free shipping</strong> on orders over RM 100</p> --}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                
                <div class="flex justify-between mb-2">
                    <span class="text-gray-700">Subtotal</span>
                    <span class="text-gray-900 font-medium">
                        RM {{ number_format($cart->items->sum(function($item) { return $item->book->price * $item->quantity; }), 2) }}
                    </span>
                </div>
                
                <div class="flex justify-between mb-2">
                    <span class="text-gray-700">Shipping</span>
                    <span class="text-gray-500 text-sm">Calculated at checkout</span>
                </div>
                
                <div class="flex justify-between border-t border-gray-200 pt-4 mt-4">
                    <span class="text-lg font-bold text-gray-900">Estimated Total</span>
                    <span class="text-lg font-bold text-purple-600">
                        RM {{ number_format($cart->items->sum(function($item) { return $item->book->price * $item->quantity; }), 2) }}+
                    </span>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('checkout.index') }}" class="block w-full px-4 py-3 bg-purple-600 text-white text-center font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Proceed to Checkout
                    </a>
                    <p class="text-xs text-gray-500 text-center mt-2">
                        Enter your address to see exact shipping costs
                    </p>
                </div>
            </div>

            <!-- Cross-sell Recommendations -->
            @auth
                <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        You Might Also Like
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">Based on your cart, here are some books you might enjoy:</p>
                    
                    <div id="cart-recommendations-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        <!-- Loading state -->
                        <div class="col-span-full flex justify-center items-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                        </div>
                    </div>
                </div>
            @endauth

            <div class="mt-8 text-center">
                <a href="{{ route('books.index') }}" class="text-purple-600 hover:text-purple-700">
                    &larr; Continue Shopping
                </a>
            </div>
        @endif
    </div>

    @auth
        <script>
            // Load personalized recommendations for cart page
            document.addEventListener('DOMContentLoaded', function() {
                if (window.RecommendationManager) {
                    window.RecommendationManager.loadRecommendations('cart-recommendations-grid', 8);
                }
            });
        </script>
    @endauth
@endsection
