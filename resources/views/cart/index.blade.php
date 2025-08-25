@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-serif font-bold text-gray-900 mb-6">Your Shopping Cart</h1>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

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
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->book->stock }}" class="w-16 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                            <button type="submit" class="ml-2 text-sm text-purple-600 hover:text-purple-900">
                                                Update
                                            </button>
                                        </form>
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

            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
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
                <div class="mt-6">
                    <a href="{{ route('checkout.index') }}" class="block w-full px-4 py-3 bg-purple-600 text-white text-center font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Proceed to Checkout
                    </a>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('books.index') }}" class="text-purple-600 hover:text-purple-700">
                    &larr; Continue Shopping
                </a>
            </div>
        @endif
    </div>
@endsection
