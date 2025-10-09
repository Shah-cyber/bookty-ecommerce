@extends('layouts.app')

@section('content')
<div class="py-12 bg-bookty-cream">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-serif font-bold text-bookty-black">Your Orders</h1>
            <p class="text-bookty-purple-700 mt-2">View and track your order history</p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-bookty-pink-100">
                            <thead class="bg-bookty-pink-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                        Order ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                        Tracking
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-bookty-pink-100">
                                @foreach($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-bookty-black">
                                        {{ $order->public_id ?? $order->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-bookty-black">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-bookty-black">
                                        RM {{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = match($order->status) {
                                                'pending' => ['Order Placed', 'bg-blue-100 text-blue-800'],
                                                'processing' => ['Processing', 'bg-yellow-100 text-yellow-800'],
                                                'shipped' => ['Shipped', 'bg-indigo-100 text-indigo-800'],
                                                'completed' => ['Delivered', 'bg-green-100 text-green-800'],
                                                'cancelled' => ['Cancelled', 'bg-red-100 text-red-800'],
                                                default => ['Unknown', 'bg-gray-100 text-gray-800']
                                            };
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusConfig[1] }}">
                                            {{ $statusConfig[0] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($order->hasTrackingNumber())
                                            <div class="flex items-center space-x-1">
                                                <button onclick="copyAndTrackPackage('{{ $order->tracking_number }}', '{{ $order->getJtTrackingUrl() }}')" 
                                                        class="inline-flex items-center px-2 py-1 text-xs bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                    Copy & Track
                                                </button>
                                                <button onclick="copyTrackingNumber('{{ $order->tracking_number }}')" 
                                                        class="p-1 text-gray-500 hover:text-bookty-purple-600 transition-colors duration-200" 
                                                        title="Copy tracking number">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <span class="px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-md">
                                                Not shipped
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('profile.orders.show', $order->id) }}" class="text-bookty-purple-600 hover:text-bookty-purple-900">View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-bookty-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-xl font-medium text-bookty-black">No orders yet</h3>
                        <p class="mt-1 text-bookty-purple-700">Start shopping to see your orders here.</p>
                        <div class="mt-6">
                            <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-bookty-purple-600 hover:bg-bookty-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bookty-purple-500">
                                Browse Books
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
