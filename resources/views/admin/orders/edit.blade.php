@extends('layouts.admin')

@section('header', 'Edit Order')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center text-bookty-purple-600 hover:text-bookty-purple-800">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Order Details
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-serif font-semibold text-bookty-black mb-6">Edit Order #{{ $order->id }}</h2>

            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-bookty-black mb-4">Order Status</h3>
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 focus:border-bookty-purple-300 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="w-full rounded-md border-gray-300 focus:border-bookty-purple-300 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50">
                                @foreach($paymentStatuses as $status)
                                    <option value="{{ $status }}" {{ $order->payment_status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-bookty-black mb-4">Shipping & Notes</h3>
                        
                        <div class="mb-4">
                            <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-1">
                                <svg class="inline w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                J&T Express Tracking Number
                            </label>
                            <input type="text" name="tracking_number" id="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="e.g., JT12345678901" class="w-full rounded-md border-gray-300 focus:border-bookty-purple-300 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50">
                            @error('tracking_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if($order->tracking_number)
                                <div class="mt-2 flex items-center space-x-2">
                                    <button type="button" onclick="copyAndTrackPackage('{{ $order->tracking_number }}', '{{ $order->getJtTrackingUrl() }}')" 
                                            class="inline-flex items-center px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        Copy & Track
                                    </button>
                                    <a href="{{ $order->getJtTrackingUrl() }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs underline">
                                        View tracking status →
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Admin Notes (Internal Only)</label>
                            <textarea name="admin_notes" id="admin_notes" rows="4" class="w-full rounded-md border-gray-300 focus:border-bookty-purple-300 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                            @error('admin_notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-bookty-black mb-4">Order Summary</h3>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Customer</p>
                                <p class="font-medium">{{ $order->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Order Date</p>
                                <p class="font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Shipping Address</p>
                                <p>{{ $order->shipping_address }}</p>
                                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Contact Phone</p>
                                <p>{{ $order->shipping_phone }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-bookty-cream">
                                    <th class="px-4 py-2 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Book</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Price</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Quantity</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                @if($item->book->cover_image)
                                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" class="h-12 w-8 object-cover mr-3">
                                                @else
                                                    <div class="h-12 w-8 bg-gray-200 flex items-center justify-center mr-3">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="font-medium text-sm">{{ $item->book->title }}</p>
                                                    <p class="text-xs text-gray-500">by {{ $item->book->author }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            RM {{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                            RM {{ number_format($item->price * $item->quantity, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right font-medium">Total:</td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900">RM {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.orders.show', $order) }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700 transition-colors duration-200">
                        Update Order
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
