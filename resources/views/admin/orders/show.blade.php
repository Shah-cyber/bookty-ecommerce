@extends('layouts.admin')

@section('header', 'Order Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="flex items-center text-bookty-purple-600 hover:text-bookty-purple-800">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Orders
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-serif font-semibold text-bookty-black">Order #{{ $order->id }}</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.orders.edit', $order) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                        Edit Order
                    </a>
                    @if($order->status === 'cancelled')
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200">
                                Delete Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-medium text-bookty-black mb-3">Order Information</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Order Date</p>
                                <p class="font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Order Status</p>
                                <p>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->getStatusBadgeClass() }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Payment Status</p>
                                <p>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->getPaymentStatusBadgeClass() }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Amount</p>
                                <p class="font-medium">RM {{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-bookty-black mb-3">Customer Information</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-medium">{{ $order->user->name }}</p>
                        <p class="text-gray-500">{{ $order->user->email }}</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.customers.show', $order->user->id) }}" class="text-bookty-purple-600 hover:text-bookty-purple-800 text-sm">
                                View Customer Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-medium text-bookty-black mb-3">Shipping Information</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                    <p class="mt-2"><span class="text-gray-500">Phone:</span> {{ $order->shipping_phone }}</p>
                </div>
            </div>

            @if($order->admin_notes)
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-bookty-black mb-3">Admin Notes</h3>
                    <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                        <p>{{ $order->admin_notes }}</p>
                    </div>
                </div>
            @endif

            <div>
                <h3 class="text-lg font-medium text-bookty-black mb-3">Order Items</h3>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-bookty-cream">
                                <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Book</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($item->book->cover_image)
                                                <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" class="h-16 w-12 object-cover mr-4">
                                            @else
                                                <div class="h-16 w-12 bg-gray-200 flex items-center justify-center mr-4">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium">{{ $item->book->title }}</p>
                                                <p class="text-sm text-gray-500">by {{ $item->book->author }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        RM {{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        RM {{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-medium">Total:</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">RM {{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
