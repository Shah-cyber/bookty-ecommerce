@extends('layouts.admin')

@section('header', 'Invoice')

@section('content')
    <div class="mb-4 flex justify-between">
        <a href="{{ url()->previous() }}" class="px-4 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">← Back</a>
        {{-- <div class="space-x-2">
            <a href="{{ route('admin.orders.invoice.pdf', $order) }}" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">Download PDF</a>
            <button onclick="window.print()" class="px-4 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">Print</button>
        </div> --}}
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Invoice</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Invoice No: <span class="font-medium">{{ $invoiceNumber }}</span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Invoice Date: <span class="font-medium">{{ $order->created_at->format('d M Y') }}</span></p>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $seller['company'] }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $seller['address'] }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Tax No: {{ $seller['tax_number'] }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $seller['email'] }} · {{ $seller['phone'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Bill To</h3>
                    <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $order->user->name }}</p>
                    <p class="text-gray-600 dark:text-gray-300">{{ $order->user->email }}</p>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        <p>{{ $order->shipping_address }}</p>
                        <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                        <p>Phone: {{ $order->shipping_phone }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Order Details</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Order Ref: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $order->public_id ?? $order->id }}</span></p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Payment Status: <span class="font-medium capitalize">{{ $order->payment_status }}</span></p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Order Status: <span class="font-medium capitalize">{{ $order->status }}</span></p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-bookty-cream dark:bg-gray-700">
                            <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black dark:text-gray-200 uppercase tracking-wider">No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black dark:text-gray-200 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-bookty-black dark:text-gray-200 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-bookty-black dark:text-gray-200 uppercase tracking-wider">Unit Price</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-bookty-black dark:text-gray-200 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($order->items as $idx => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $idx + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    <div class="font-medium">{{ $item->book->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-300">by {{ $item->book->author }}</div>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-gray-900 dark:text-gray-100">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-right text-sm text-gray-900 dark:text-gray-100">RM {{ number_format($item->price, 2) }}</td>
                                <td class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-gray-100">RM {{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-right text-sm text-gray-600 dark:text-gray-300">Subtotal</td>
                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900 dark:text-gray-100">RM {{ number_format($subTotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-right text-sm text-gray-600 dark:text-gray-300">Discount</td>
                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900 dark:text-gray-100">- RM {{ number_format($discount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-right text-sm text-gray-600 dark:text-gray-300">Tax ({{ number_format($taxRate * 100, 2) }}%)</td>
                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900 dark:text-gray-100">RM {{ number_format($taxAmount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-right text-base font-semibold text-gray-900 dark:text-gray-100">Grand Total</td>
                            <td class="px-6 py-3 text-right text-base font-bold text-gray-900 dark:text-gray-100">RM {{ number_format($grandTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <p class="text-xs text-gray-500 dark:text-gray-300">This invoice was generated electronically and is valid without signature.</p>
                <div class="space-x-2">
                    <a href="{{ route('admin.orders.invoice.pdf', $order) }}" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">Download PDF</a>
                    {{-- <button onclick="window.print()" class="px-4 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">Print</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
