@extends('layouts.app')

@section('content')
<div class="py-12 bg-bookty-cream">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('profile.orders.show', $order) }}" class="text-bookty-purple-600 hover:text-bookty-purple-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Order Details
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-serif font-bold text-bookty-black">Invoice</h1>
                        <p class="text-sm text-gray-500">Invoice No: <span class="font-medium">{{ $invoiceNumber }}</span></p>
                        <p class="text-sm text-gray-500">Invoice Date: <span class="font-medium">{{ $order->created_at->format('d M Y') }}</span></p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-serif font-bold text-bookty-black">{{ $seller['company'] }}</h2>
                        <p class="text-sm text-gray-600">{{ $seller['address'] }}</p>
                        <p class="text-sm text-gray-600">Tax No: {{ $seller['tax_number'] }}</p>
                        <p class="text-sm text-gray-600">{{ $seller['email'] }} · {{ $seller['phone'] }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-bookty-pink-50 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-bookty-purple-700 mb-2">Bill To</h3>
                        <p class="text-bookty-black font-medium">{{ $order->user->name }}</p>
                        <p class="text-gray-600">{{ $order->user->email }}</p>
                        <div class="mt-2 text-sm text-gray-600">
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                            <p>Phone: {{ $order->shipping_phone }}</p>
                        </div>
                    </div>
                    <div class="bg-bookty-pink-50 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-bookty-purple-700 mb-2">Order Details</h3>
                        <p class="text-sm text-gray-600">Order Ref: <span class="font-medium text-bookty-black">{{ $order->public_id ?? $order->id }}</span></p>
                        <p class="text-sm text-gray-600">Payment Status: <span class="font-medium capitalize">{{ $order->payment_status }}</span></p>
                        <p class="text-sm text-gray-600">Order Status: <span class="font-medium capitalize">{{ $order->status }}</span></p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-bookty-pink-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">Item</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">Unit Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-bookty-pink-100">
                            @foreach($order->items as $idx => $item)
                                <tr class="hover:bg-bookty-pink-25">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-bookty-black">
                                        <div class="font-medium">{{ $item->book->title }}</div>
                                        <div class="text-xs text-gray-500">by {{ $item->book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm text-bookty-black">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right text-sm text-bookty-black">RM {{ number_format($item->price, 2) }}</td>
                                    <td class="px-6 py-4 text-right text-sm font-medium text-bookty-black">RM {{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-bookty-pink-50">
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-right text-sm text-gray-600">Subtotal</td>
                                <td class="px-6 py-3 text-right text-sm font-medium text-bookty-black">RM {{ number_format($subTotal, 2) }}</td>
                            </tr>
                            @if($discount > 0)
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-right text-sm text-gray-600">Discount</td>
                                <td class="px-6 py-3 text-right text-sm font-medium text-green-600">- RM {{ number_format($discount, 2) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-right text-sm text-gray-600">Shipping</td>
                                <td class="px-6 py-3 text-right text-sm font-medium text-bookty-black">
                                    @if($shippingCost == 0)
                                        Free
                                    @else
                                        RM {{ number_format($shippingCost, 2) }}
                                    @endif
                                </td>
                            </tr>
                            @if($taxAmount > 0)
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-right text-sm text-gray-600">Tax ({{ number_format($taxRate * 100, 2) }}%)</td>
                                <td class="px-6 py-3 text-right text-sm font-medium text-bookty-black">RM {{ number_format($taxAmount, 2) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-right text-base font-semibold text-bookty-black">Grand Total</td>
                                <td class="px-6 py-3 text-right text-base font-bold text-bookty-purple-600">RM {{ number_format($grandTotal, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <p class="text-xs text-gray-500">This invoice was generated electronically and is valid without signature.</p>
                    <div class="space-x-2">
                        <a href="{{ route('profile.orders.invoice.pdf', $order) }}" class="px-4 py-2 text-sm bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700">Download PDF</a>
                        <button onclick="window.print()" class="px-4 py-2 text-sm bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
