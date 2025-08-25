@extends('layouts.app')

@section('content')
<div class="py-12 bg-bookty-cream">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('profile.orders') }}" class="text-bookty-purple-600 hover:text-bookty-purple-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Orders
            </a>
        </div>

        <div class="mb-6">
            <h1 class="text-3xl font-serif font-bold text-bookty-black">Order #{{ $order->id }}</h1>
            <p class="text-bookty-purple-700 mt-2">Placed on {{ $order->created_at->format('F d, Y') }}</p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 border-b border-bookty-pink-100">
                <h2 class="text-xl font-serif font-medium text-bookty-black mb-4">Order Status</h2>
                
                <div class="flex items-center">
                    <div class="relative w-full">
                        <div class="h-2 bg-bookty-pink-100 rounded-full">
                            <div class="h-2 bg-bookty-purple-600 rounded-full" style="width: {{ $order->status === 'pending' ? '33%' : ($order->status === 'shipped' ? '66%' : '100%') }}"></div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <div class="text-center">
                                <div class="w-6 h-6 rounded-full {{ $order->status ? 'bg-bookty-purple-600' : 'bg-bookty-pink-200' }} mx-auto"></div>
                                <span class="text-xs text-bookty-purple-700 mt-1 block">Order Placed</span>
                            </div>
                            <div class="text-center">
                                <div class="w-6 h-6 rounded-full {{ $order->status === 'shipped' || $order->status === 'completed' ? 'bg-bookty-purple-600' : 'bg-bookty-pink-200' }} mx-auto"></div>
                                <span class="text-xs text-bookty-purple-700 mt-1 block">Shipped</span>
                            </div>
                            <div class="text-center">
                                <div class="w-6 h-6 rounded-full {{ $order->status === 'completed' ? 'bg-bookty-purple-600' : 'bg-bookty-pink-200' }} mx-auto"></div>
                                <span class="text-xs text-bookty-purple-700 mt-1 block">Delivered</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-bookty-black mb-2">Shipping Information</h3>
                        <p class="text-bookty-black">{{ $order->shipping_address }}</p>
                        <p class="text-bookty-black">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                        <p class="text-bookty-black">Phone: {{ $order->shipping_phone }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-bookty-black mb-2">Payment Information</h3>
                        <p class="text-bookty-black">Payment Status: 
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                        <p class="text-bookty-black">Payment Method: Credit Card</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <h2 class="text-xl font-serif font-medium text-bookty-black mb-4">Order Items</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-bookty-pink-100">
                        <thead class="bg-bookty-pink-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Book
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Subtotal
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-bookty-pink-100">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-12 bg-bookty-pink-50 flex items-center justify-center">
                                            @if($item->book->cover_image)
                                                <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" class="h-full object-cover">
                                            @else
                                                <svg class="h-8 w-8 text-bookty-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-bookty-black">{{ $item->book->title }}</div>
                                            <div class="text-sm text-bookty-purple-700">{{ $item->book->author }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-bookty-black">
                                    RM {{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-bookty-black">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-bookty-black">
                                    RM {{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-8 flex justify-end">
                    <div class="w-full md:w-1/3">
                        <div class="bg-bookty-pink-50 p-4 rounded-md">
                            <div class="flex justify-between py-2 text-bookty-black">
                                <span>Subtotal</span>
                                <span>RM {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2 text-bookty-black">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <div class="flex justify-between py-2 border-t border-bookty-pink-200 font-semibold text-bookty-black">
                                <span>Total</span>
                                <span>RM {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
