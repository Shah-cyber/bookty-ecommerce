@extends('layouts.app')

@section('content')
@php
    $statusConfig = match($order->status) {
        'pending' => [
            'label' => 'Order Placed',
            'bg' => 'bg-blue-50',
            'text' => 'text-blue-700',
            'border' => 'border-blue-200',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
            'step' => 1
        ],
        'processing' => [
            'label' => 'Processing',
            'bg' => 'bg-amber-50',
            'text' => 'text-amber-700',
            'border' => 'border-amber-200',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
            'step' => 2
        ],
        'shipped' => [
            'label' => 'Shipped',
            'bg' => 'bg-indigo-50',
            'text' => 'text-indigo-700',
            'border' => 'border-indigo-200',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
            'step' => 3
        ],
        'completed' => [
            'label' => 'Delivered',
            'bg' => 'bg-green-50',
            'text' => 'text-green-700',
            'border' => 'border-green-200',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'step' => 4
        ],
        'cancelled' => [
            'label' => 'Cancelled',
            'bg' => 'bg-red-50',
            'text' => 'text-red-700',
            'border' => 'border-red-200',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
            'step' => 0
        ],
        default => [
            'label' => 'Unknown',
            'bg' => 'bg-gray-50',
            'text' => 'text-gray-700',
            'border' => 'border-gray-200',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'step' => 0
        ]
    };
    $currentStep = $statusConfig['step'];
@endphp

<div class="min-h-screen bg-gray-50 py-6 sm:py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Back Button --}}
        <div class="mb-6" data-aos="fade-up">
            <a href="{{ route('profile.orders') }}" 
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Orders
            </a>
        </div>

        {{-- Order Header Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-6" data-aos="fade-up" data-aos-delay="100">
            <div class="p-5 sm:p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-14 h-14 {{ $statusConfig['bg'] }} rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 {{ $statusConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $statusConfig['icon'] !!}
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 flex-wrap">
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Order #{{ $order->public_id ?? $order->id }}</h1>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                    {{ $statusConfig['label'] }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                Placed on {{ $order->created_at->format('F d, Y') }} at {{ $order->created_at->format('g:i A') }}
                            </p>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total Amount</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">RM {{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- Progress Tracker --}}
            @if($order->status !== 'cancelled')
            <div class="px-5 sm:px-6 py-5 bg-gray-50">
                <div class="flex items-center justify-between">
                    {{-- Step 1: Order Placed --}}
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full {{ $currentStep >= 1 ? 'bg-gray-900 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center font-bold">
                            @if($currentStep >= 1)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                1
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 mt-2 text-center font-medium">Placed</span>
                    </div>
                    
                    <div class="flex-1 h-1 mx-2 rounded {{ $currentStep >= 2 ? 'bg-gray-900' : 'bg-gray-200' }}"></div>
                    
                    {{-- Step 2: Processing --}}
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full {{ $currentStep >= 2 ? 'bg-gray-900 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center font-bold">
                            @if($currentStep >= 2)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                2
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 mt-2 text-center font-medium">Processing</span>
                    </div>
                    
                    <div class="flex-1 h-1 mx-2 rounded {{ $currentStep >= 3 ? 'bg-gray-900' : 'bg-gray-200' }}"></div>
                    
                    {{-- Step 3: Shipped --}}
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full {{ $currentStep >= 3 ? 'bg-gray-900 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center font-bold">
                            @if($currentStep >= 3)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                3
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 mt-2 text-center font-medium">Shipped</span>
                    </div>
                    
                    <div class="flex-1 h-1 mx-2 rounded {{ $currentStep >= 4 ? 'bg-gray-900' : 'bg-gray-200' }}"></div>
                    
                    {{-- Step 4: Delivered --}}
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full {{ $currentStep >= 4 ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center font-bold">
                            @if($currentStep >= 4)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                4
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 mt-2 text-center font-medium">Delivered</span>
                    </div>
                </div>
            </div>
            @else
            <div class="px-5 sm:px-6 py-4 bg-red-50 border-t border-red-100">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm text-red-700 font-medium">This order has been cancelled.</p>
                </div>
            </div>
            @endif
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Left Column - Order Info --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Order Items --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Order Items</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <div class="p-5 sm:p-6 flex gap-4">
                            {{-- Book Cover --}}
                            <a href="{{ $item->book ? route('books.show', $item->book) : '#' }}" class="flex-shrink-0">
                                @if($item->book && $item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                        alt="{{ $item->book->title }}" 
                                        class="w-16 h-22 sm:w-20 sm:h-28 object-cover rounded-xl shadow-sm">
                                @else
                                    <div class="w-16 h-22 sm:w-20 sm:h-28 bg-gray-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            
                            {{-- Book Details --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-2">
                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-gray-900 line-clamp-2">{{ $item->book->title ?? 'Book Unavailable' }}</h3>
                                        <p class="text-sm text-gray-500 mt-0.5">{{ $item->book->author ?? 'Unknown Author' }}</p>
                                    </div>
                                    <div class="text-left sm:text-right flex-shrink-0">
                                        <p class="font-bold text-gray-900">RM {{ number_format($item->price * $item->quantity, 2) }}</p>
                                        <p class="text-sm text-gray-500">RM {{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tracking Information --}}
                @if($order->hasTrackingNumber())
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="250">
                    <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Package Tracking</h2>
                    </div>
                    <div class="p-5 sm:p-6">
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">J&T Express</p>
                                    <div class="flex items-center gap-2">
                                        <p class="font-mono text-lg font-bold text-gray-900">{{ $order->tracking_number }}</p>
                                        <button onclick="copyTrackingNumber('{{ $order->tracking_number }}')" 
                                            class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-100 rounded-lg transition-all"
                                            title="Copy tracking number">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="copyAndTrackPackage('{{ $order->tracking_number }}', '{{ $order->getJtTrackingUrl() }}')" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Track Package
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Payment Information --}}
                @if($order->hasToyyibPayPayment())
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Payment Details</h2>
                    </div>
                    <div class="p-5 sm:p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Gateway</p>
                                <p class="font-semibold text-gray-900">ToyyibPay FPX</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Status</p>
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            @if($order->toyyibpay_invoice_no)
                            <div class="bg-gray-50 rounded-xl p-4 col-span-2 sm:col-span-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Transaction ID</p>
                                <div class="flex items-center gap-2">
                                    <p class="font-mono text-sm font-semibold text-gray-900 truncate">{{ $order->toyyibpay_invoice_no }}</p>
                                    <button onclick="copyToClipboard('{{ $order->toyyibpay_invoice_no }}')" 
                                        class="p-1 text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endif
                            @if($order->toyyibpay_payment_date)
                            <div class="bg-gray-50 rounded-xl p-4 col-span-2 sm:col-span-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Payment Date</p>
                                <p class="font-semibold text-gray-900">
                                    @if($order->toyyibpay_payment_date instanceof \Carbon\Carbon)
                                        {{ $order->toyyibpay_payment_date->format('d M Y, h:i A') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($order->toyyibpay_payment_date)->format('d M Y, h:i A') }}
                                    @endif
                                </p>
                            </div>
                            @endif
                        </div>
                        
                        @if($order->toyyibpay_payment_url && $order->payment_status === 'pending')
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ $order->toyyibpay_payment_url }}" target="_blank" 
                                class="inline-flex items-center gap-2 px-5 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all w-full sm:w-auto justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Complete Payment
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- Right Column - Summary --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Order Summary --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Order Summary</h2>
                    </div>
                    <div class="p-5">
                        @php
                            $orderSubtotal = $order->items->sum(function($item) { return $item->price * $item->quantity; });
                            $shippingCost = $order->is_free_shipping ? 0 : ($order->shipping_customer_price ?? 0);
                            $discount = $order->discount_amount ?? 0;
                            $grandTotal = $orderSubtotal + $shippingCost - $discount;
                        @endphp
                        
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal ({{ $order->items->sum('quantity') }} items)</span>
                                <span class="font-medium text-gray-900">RM {{ number_format($orderSubtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium {{ $order->is_free_shipping ? 'text-green-600' : 'text-gray-900' }}">
                                    {{ $order->is_free_shipping ? 'Free' : 'RM ' . number_format($shippingCost, 2) }}
                                </span>
                            </div>
                            @if($discount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-medium text-green-600">-RM {{ number_format($discount, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between pt-3 border-t border-gray-100">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-gray-900">RM {{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="250">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Shipping Address</h2>
                    </div>
                    <div class="p-5">
                        <div class="space-y-2 text-sm">
                            <p class="font-semibold text-gray-900">{{ $order->shipping_name ?? Auth::user()->name }}</p>
                            <p class="text-gray-600">{{ $order->shipping_address }}</p>
                            <p class="text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                            <div class="flex items-center gap-2 pt-2 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $order->shipping_phone }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Invoice Actions --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Invoice</h2>
                    </div>
                    <div class="p-5 space-y-3">
                        <button type="button" onclick="openInvoiceModal()"
                            class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Invoice
                        </button>
                        <a href="{{ route('profile.orders.invoice.pdf', $order) }}" 
                            class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download PDF
                        </a>
                    </div>
                </div>

                {{-- Need Help? --}}
                <div class="bg-gray-50 rounded-2xl border border-gray-100 p-5" data-aos="fade-up" data-aos-delay="350">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Need Help?</h3>
                            <p class="text-sm text-gray-500 mt-1">Contact our support team for any questions about your order.</p>
                            <a href="{{ route('contact') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-gray-900 hover:text-gray-600 mt-2 transition-colors">
                                Contact Support
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Invoice Modal --}}
<div id="invoiceModal" class="fixed inset-0 z-[9999] hidden" aria-modal="true">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeInvoiceModal()"></div>
    
    {{-- Modal Content --}}
    <div class="fixed inset-4 sm:inset-8 lg:inset-16 bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden z-10">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Invoice #{{ $order->public_id ?? $order->id }}</h2>
                    <p class="text-sm text-gray-500">{{ $order->created_at->format('F d, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('profile.orders.invoice.pdf', $order) }}" 
                    class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
                <button onclick="closeInvoiceModal()" 
                    class="p-2.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Modal Body --}}
        <div class="flex-1 overflow-y-auto p-6 sm:p-8">
            <div class="max-w-4xl mx-auto">
                {{-- Invoice Header --}}
                <div class="flex flex-col sm:flex-row sm:justify-between gap-6 mb-8 pb-8 border-b border-gray-200">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">INVOICE</h1>
                        <div class="space-y-1 text-sm text-gray-600">
                            <p>Invoice No: <span class="font-semibold text-gray-900">INV-{{ $order->public_id ?? $order->id }}</span></p>
                            <p>Date: <span class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y') }}</span></p>
                            <p>Order Ref: <span class="font-semibold text-gray-900">#{{ $order->public_id ?? $order->id }}</span></p>
                        </div>
                    </div>
                    <div class="sm:text-right">
                        <h2 class="text-xl font-bold text-gray-900 mb-2">Bookty Enterprise</h2>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p>Kuala Lumpur, Malaysia</p>
                            <p>bookty@enterprise.com</p>
                            <p>+60 12-345 6789</p>
                        </div>
                    </div>
                </div>

                {{-- Bill To & Order Info --}}
                <div class="grid sm:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-xl p-5">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Bill To</h3>
                        <p class="font-semibold text-gray-900">{{ $order->user->name ?? Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->email ?? Auth::user()->email }}</p>
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
                                <span class="text-gray-600">Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Method</span>
                                <span class="font-semibold text-gray-900">{{ $order->hasToyyibPayPayment() ? 'FPX (ToyyibPay)' : 'N/A' }}</span>
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
                                        <p class="text-sm font-semibold text-gray-900">{{ $item->book->title ?? 'Book' }}</p>
                                        <p class="text-xs text-gray-500">by {{ $item->book->author ?? 'Unknown' }}</p>
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
                @php
                    $invoiceSubtotal = $order->items->sum(function($item) { return $item->price * $item->quantity; });
                    $invoiceShipping = $order->is_free_shipping ? 0 : ($order->shipping_customer_price ?? 0);
                    $invoiceDiscount = $order->discount_amount ?? 0;
                    $invoiceTotal = $invoiceSubtotal + $invoiceShipping - $invoiceDiscount;
                @endphp
                <div class="flex justify-end">
                    <div class="w-full sm:w-72">
                        <div class="bg-gray-50 rounded-xl p-5 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold text-gray-900">RM {{ number_format($invoiceSubtotal, 2) }}</span>
                            </div>
                            @if($invoiceDiscount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-semibold text-green-600">- RM {{ number_format($invoiceDiscount, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold {{ $order->is_free_shipping ? 'text-green-600' : 'text-gray-900' }}">
                                    {{ $order->is_free_shipping ? 'Free' : 'RM ' . number_format($invoiceShipping, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-gray-200">
                                <span class="font-bold text-gray-900">Grand Total</span>
                                <span class="text-xl font-bold text-gray-900">RM {{ number_format($invoiceTotal, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-xs text-gray-500">This invoice was generated electronically and is valid without signature.</p>
                    <p class="text-xs text-gray-400 mt-1">Thank you for shopping with Bookty Enterprise!</p>
                </div>
            </div>
        </div>

        {{-- Mobile Footer with Download Button --}}
        <div class="sm:hidden px-6 py-4 border-t border-gray-100 bg-gray-50">
            <a href="{{ route('profile.orders.invoice.pdf', $order) }}" 
                class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
function openInvoiceModal() {
    document.getElementById('invoiceModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeInvoiceModal() {
    document.getElementById('invoiceModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeInvoiceModal();
    }
});

function copyTrackingNumber(trackingNumber) {
    navigator.clipboard.writeText(trackingNumber).then(function() {
        if (window.showToast) {
            window.showToast('Tracking number copied!', 'success');
        }
    });
}

function copyAndTrackPackage(trackingNumber, trackingUrl) {
    navigator.clipboard.writeText(trackingNumber).then(function() {
        if (window.showToast) {
            window.showToast('Tracking number copied! Opening tracking page...', 'success');
        }
        setTimeout(() => {
            window.open(trackingUrl, '_blank');
        }, 500);
    });
}

window.copyToClipboard = async function(text) {
    try {
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(text);
            if (window.showToast) {
                window.showToast('Copied to clipboard!', 'success');
            }
        } else {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            if (window.showToast) {
                window.showToast('Copied to clipboard!', 'success');
            }
        }
    } catch (err) {
        console.error('Copy failed: ', err);
        if (window.showToast) {
            window.showToast('Could not copy to clipboard', 'error');
        }
    }
};
</script>
@endsection
