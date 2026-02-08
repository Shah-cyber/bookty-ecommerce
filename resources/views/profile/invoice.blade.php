@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 sm:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Back Button --}}
        <div class="mb-6 flex items-center justify-between" data-aos="fade-up">
            <a href="{{ route('profile.orders.show', $order) }}" 
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Order
            </a>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
                <a href="{{ route('profile.orders.invoice.pdf', $order) }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        {{-- Invoice Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden print:shadow-none print:border-0" data-aos="fade-up" data-aos-delay="100">
            <div class="p-6 sm:p-8 lg:p-10">
                
                {{-- Invoice Header --}}
                <div class="flex flex-col sm:flex-row sm:justify-between gap-6 mb-8 pb-8 border-b border-gray-200">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">INVOICE</h1>
                        <div class="space-y-1 text-sm text-gray-600">
                            <p>Invoice No: <span class="font-semibold text-gray-900">{{ $invoiceNumber }}</span></p>
                            <p>Date: <span class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y') }}</span></p>
                            <p>Order Ref: <span class="font-semibold text-gray-900">#{{ $order->public_id ?? $order->id }}</span></p>
                        </div>
                    </div>
                    <div class="sm:text-right">
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $seller['company'] }}</h2>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p>{{ $seller['address'] }}</p>
                            <p>Tax No: {{ $seller['tax_number'] }}</p>
                            <p>{{ $seller['email'] }}</p>
                            <p>{{ $seller['phone'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Bill To & Order Info --}}
                <div class="grid sm:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-xl p-5">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Bill To</h3>
                        <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                        <div class="mt-3 text-sm text-gray-600 space-y-1">
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                            <p>Phone: {{ $order->shipping_phone }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Payment Info</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Status</span>
                                <span class="font-semibold text-gray-900 capitalize">{{ $order->status }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Items Table --}}
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Order Items</h3>
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Item</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Price</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order->items as $idx => $item)
                                <tr>
                                    <td class="px-4 py-4 text-sm text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-4">
                                        <p class="text-sm font-semibold text-gray-900">{{ $item->book->title }}</p>
                                        <p class="text-xs text-gray-500">by {{ $item->book->author }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900 text-right">{{ $item->quantity }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-900 text-right">RM {{ number_format($item->price, 2) }}</td>
                                    <td class="px-4 py-4 text-sm font-semibold text-gray-900 text-right">RM {{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Totals --}}
                <div class="flex justify-end">
                    <div class="w-full sm:w-72">
                        <div class="bg-gray-50 rounded-xl p-5 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold text-gray-900">RM {{ number_format($subTotal, 2) }}</span>
                            </div>
                            @if($discount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-semibold text-green-600">- RM {{ number_format($discount, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold {{ $shippingCost == 0 ? 'text-green-600' : 'text-gray-900' }}">
                                    {{ $shippingCost == 0 ? 'Free' : 'RM ' . number_format($shippingCost, 2) }}
                                </span>
                            </div>
                            @if($taxAmount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax ({{ number_format($taxRate * 100, 2) }}%)</span>
                                <span class="font-semibold text-gray-900">RM {{ number_format($taxAmount, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between pt-3 border-t border-gray-200">
                                <span class="font-bold text-gray-900">Grand Total</span>
                                <span class="text-xl font-bold text-gray-900">RM {{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-xs text-gray-500">This invoice was generated electronically and is valid without signature.</p>
                    <p class="text-xs text-gray-400 mt-1">Thank you for shopping with {{ $seller['company'] }}!</p>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .bg-white.rounded-2xl, .bg-white.rounded-2xl * {
            visibility: visible;
        }
        .bg-white.rounded-2xl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        nav, footer, [data-aos] {
            display: none !important;
        }
    }
</style>
@endsection
