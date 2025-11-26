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
            <h1 class="text-3xl  font-bold text-bookty-black">Order: {{ $order->public_id ?? $order->id }}</h1>
            <p class="text-bookty-purple-700 mt-2">Placed on {{ $order->created_at->format('F d, Y') }}</p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 border-b border-bookty-pink-100">
                <h2 class="text-xl font-serif font-medium text-bookty-black mb-4">Order Status</h2>
                
                <x-order-status-stepper :order="$order" />
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-bookty-black mb-2">Shipping Information</h3>
                        <p class="text-bookty-black">{{ $order->shipping_address }}</p>
                        <p class="text-bookty-black">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                        <p class="text-bookty-black">Phone: {{ $order->shipping_phone }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-bookty-black mb-2">Payment Information</h3>
                        <div class="space-y-3">
                            <p class="text-bookty-black">Payment Status: 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                            <p class="text-bookty-black">Payment Method: 
                                @if($order->hasToyyibPayPayment())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        FPX (ToyyibPay)
                                    </span>
                                @else
                                    <span class="text-gray-500">Not Available</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($order->hasTrackingNumber())
            <div class="p-6 border-b border-bookty-pink-100">
                <h2 class="text-xl font-serif font-medium text-bookty-black mb-4">
                    <svg class="inline w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Package Tracking
                </h2>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">J&T Express Tracking Number</p>
                            <div class="flex items-center space-x-2">
                                <p class="font-mono text-lg font-semibold text-blue-900">{{ $order->tracking_number }}</p>
                                <button onclick="copyTrackingNumber('{{ $order->tracking_number }}')" 
                                        class="p-1 text-gray-500 hover:text-blue-600 transition-colors duration-200" 
                                        title="Copy tracking number">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="copyAndTrackPackage('{{ $order->tracking_number }}', '{{ $order->getJtTrackingUrl() }}')" 
                                    class="inline-flex items-center justify-center px-4 py-2 bg-bookty-purple-600 text-white rounded-lg hover:bg-bookty-purple-700 transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Copy & Track
                            </button>
                            <a href="{{ $order->getJtTrackingUrl() }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Track Only
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-blue-200">
                        <p class="text-xs text-gray-600">
                            <span class="font-semibold">💡 Tip:</span> Click "Copy & Track" to copy your tracking number and automatically open the J&T tracking page, or use "Track Only" to just view the tracking status.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            @if($order->hasToyyibPayPayment())
            <div class="p-6 border-b border-bookty-pink-100">
                <h2 class="text-xl font-serif font-medium text-bookty-black mb-4">
                    <svg class="inline w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Payment Details
                </h2>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Payment Gateway</p>
                            <p class="font-semibold text-blue-900">ToyyibPay FPX</p>
                        </div>
                        
                        @if($order->toyyibpay_invoice_no)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Transaction ID</p>
                            <div class="flex items-center space-x-2">
                                <p class="font-mono text-sm font-semibold text-blue-900">{{ $order->toyyibpay_invoice_no }}</p>
                                <button onclick="copyToClipboard('{{ $order->toyyibpay_invoice_no }}')" 
                                        class="p-1 text-gray-500 hover:text-blue-600 transition-colors duration-200" 
                                        title="Copy transaction ID">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endif
                        
                        @if($order->toyyibpay_payment_date)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Payment Date</p>
                            <p class="font-semibold text-blue-900">
                                @if($order->toyyibpay_payment_date instanceof \Carbon\Carbon)
                                    {{ $order->toyyibpay_payment_date->format('d M Y, h:i A') }}
                                @else
                                    {{ \Carbon\Carbon::parse($order->toyyibpay_payment_date)->format('d M Y, h:i A') }}
                                @endif
                            </p>
                        </div>
                        @endif
                        
                        @if($order->toyyibpay_settlement_reference)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Settlement Reference</p>
                            <p class="font-mono text-sm font-semibold text-blue-900">{{ $order->toyyibpay_settlement_reference }}</p>
                        </div>
                        @endif
                    </div>
                    
                    @if($order->toyyibpay_payment_url && $order->payment_status === 'pending')
                    <div class="mt-4 pt-4 border-t border-blue-200">
                        <a href="{{ $order->toyyibpay_payment_url }}" target="_blank" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Complete Payment
                        </a>
                        <p class="text-xs text-gray-600 mt-2">
                            <span class="font-semibold">💡 Note:</span> Click to complete your payment via FPX online banking.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Invoice Section -->
            <div class="p-6 border-b border-bookty-pink-100">
                <h2 class="text-xl font-serif font-medium text-bookty-black mb-4">
                    <svg class="inline w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Invoice
                </h2>
                
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Order Invoice</p>
                            <p class="font-semibold text-green-900">Invoice #{{ $order->public_id ?? $order->id }}</p>
                            <p class="text-xs text-gray-500 mt-1">Generated on {{ $order->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('profile.orders.invoice', $order) }}" target="_blank" 
                               class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Invoice
                            </a>
                            <a href="{{ route('profile.orders.invoice.pdf', $order) }}" 
                               class="inline-flex items-center justify-center px-4 py-2 bg-bookty-purple-600 text-white rounded-lg hover:bg-bookty-purple-700 transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-green-200">
                        <p class="text-xs text-gray-600">
                            <span class="font-semibold"> Tip:</span> Click "View Invoice" to see a printable version in your browser, or "Download PDF" to save the invoice to your device.
                        </p>
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
                            @php
                                $orderSubtotal = $order->items->sum(function($item) { return $item->price * $item->quantity; });
                                $shippingCost = $order->is_free_shipping ? 0 : ($order->shipping_customer_price ?? 0);
                                $grandTotal = $orderSubtotal + $shippingCost;
                            @endphp
                            <div class="flex justify-between py-2 text-bookty-black">
                                <span>Subtotal</span>
                                <span>RM {{ number_format($orderSubtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2 text-bookty-black">
                                <span>Shipping</span>
                                <span>
                                    @if($order->is_free_shipping)
                                        Free
                                    @else
                                        RM {{ number_format($shippingCost, 2) }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-t border-bookty-pink-200 font-semibold text-bookty-black">
                                <span>Total</span>
                                <span>RM {{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.copyToClipboard = async function(text) {
    try {
        // Copy text to clipboard
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(text);
            showToast(`Transaction ID copied to clipboard!`, 'success');
        } else {
            // Fallback for browsers that don't support clipboard API
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                document.execCommand('copy');
                showToast(`Transaction ID copied to clipboard!`, 'success');
            } catch (err) {
                showToast('Could not copy transaction ID', 'error');
            }
            
            document.body.removeChild(textArea);
        }
    } catch (err) {
        console.error('Copy failed: ', err);
        showToast('Could not copy transaction ID', 'error');
    }
};
</script>
@endsection
