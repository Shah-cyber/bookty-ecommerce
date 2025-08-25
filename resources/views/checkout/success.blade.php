@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-600 mb-6">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-2xl font-serif font-bold text-gray-900 mb-4">Thank You for Your Order!</h1>
                <p class="text-gray-600 mb-6">Your order has been placed successfully. We'll ship your books as soon as possible.</p>
                
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <div class="text-left mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Order Details</h2>
                        <p class="text-gray-600">Order #: {{ $order->id }}</p>
                        <p class="text-gray-600">Date: {{ $order->created_at->format('F j, Y') }}</p>
                        <p class="text-gray-600">Total: RM {{ number_format($order->total_amount, 2) }}</p>
                    </div>
                    
                    <div class="text-left mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Shipping Information</h2>
                        <p class="text-gray-600">{{ $order->shipping_address }}</p>
                        <p class="text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                        <p class="text-gray-600">Phone: {{ $order->shipping_phone }}</p>
                    </div>
                    
                    <div class="text-left">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Order Items</h2>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
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
                                            <p class="text-sm font-medium text-gray-900">RM {{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">Qty: {{ $item->quantity }} x RM {{ number_format($item->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('books.index') }}" class="px-6 py-3 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
