@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 sm:py-8">
    {{-- Ambient Background --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-72 h-72 bg-green-200/20 dark:bg-green-900/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-purple-200/20 dark:bg-purple-900/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-3xl mx-auto px-4 sm:px-6">
        {{-- Success Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden" data-aos="fade-up">
            {{-- Success Header --}}
            <div class="relative bg-gradient-to-r from-green-500 to-emerald-600 px-5 py-8 sm:px-8 text-center overflow-hidden">
                {{-- Decorative circles --}}
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
                <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/10 rounded-full -ml-10 -mb-10"></div>
                
                {{-- Animated Checkmark --}}
                <div class="relative inline-flex items-center justify-center mb-4">
                    <div class="absolute inset-0 w-16 h-16 bg-white/20 rounded-full animate-ping"></div>
                    <div class="relative w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                
                <h1 class="text-xl sm:text-2xl font-bold text-white mb-1">Thank You for Your Order!</h1>
                <p class="text-green-100 text-sm">Your order has been placed successfully</p>
                
                {{-- Order ID Badge --}}
                <div class="mt-4 inline-flex items-center gap-1.5 bg-white/20 backdrop-blur-sm rounded-full px-4 py-1.5 text-sm">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-white font-medium">Order #{{ $order->public_id ?? $order->id }}</span>
                </div>
            </div>

            {{-- Order Content --}}
            <div class="p-5 sm:p-6">
                {{-- Status Timeline --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between relative">
                        {{-- Progress Line --}}
                        <div class="absolute left-0 right-0 top-4 h-0.5 bg-gray-200 dark:bg-gray-700"></div>
                        <div class="absolute left-0 top-4 h-0.5 bg-green-500 transition-all duration-500" style="width: 33%"></div>
                        
                        {{-- Step 1: Order Placed --}}
                        <div class="relative flex flex-col items-center z-10">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center shadow-md shadow-green-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="mt-1.5 text-[10px] font-medium text-green-600 dark:text-green-400">Order Placed</span>
                        </div>
                        
                        {{-- Step 2: Processing --}}
                        <div class="relative flex flex-col items-center z-10">
                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                            </div>
                            <span class="mt-1.5 text-[10px] font-medium text-gray-400">Processing</span>
                        </div>
                        
                        {{-- Step 3: Shipped --}}
                        <div class="relative flex flex-col items-center z-10">
                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                            </div>
                            <span class="mt-1.5 text-[10px] font-medium text-gray-400">Shipped</span>
                        </div>
                        
                        {{-- Step 4: Delivered --}}
                        <div class="relative flex flex-col items-center z-10">
                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <span class="mt-1.5 text-[10px] font-medium text-gray-400">Delivered</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">
                    {{-- Left Column: Order Details & Items --}}
                    <div class="lg:col-span-3 space-y-4">
                        {{-- Order Summary Card --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-1.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Order Summary</h2>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                                    <p class="text-[10px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">Order Date</p>
                                    <p class="text-xs font-semibold text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400">{{ $order->created_at->format('h:i A') }}</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                                    <p class="text-[10px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">Total Amount</p>
                                    <p class="text-base font-bold text-green-600 dark:text-green-400">RM {{ number_format($order->total_amount, 2) }}</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                                    <p class="text-[10px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">Payment Method</p>
                                    @if($order->hasToyyibPayPayment())
                                        <div class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs font-medium">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                            FPX (ToyyibPay)
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-600 dark:text-gray-300">Cash on Delivery</span>
                                    @endif
                                </div>
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                                    <p class="text-[10px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-0.5">Payment Status</p>
                                    @if($order->payment_status === 'paid')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded text-xs font-medium">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Paid
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded text-xs font-medium">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Order Items --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-1.5 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Order Items ({{ $order->items->count() }})</h2>
                            </div>
                            
                            <div class="space-y-2">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-3 bg-white dark:bg-gray-800 rounded-lg p-3">
                                        {{-- Book Cover --}}
                                        <div class="flex-shrink-0">
                                            @if($item->book->cover_image)
                                                <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                                     alt="{{ $item->book->title }}" 
                                                     class="w-10 h-14 object-cover rounded shadow">
                                            @else
                                                <div class="w-10 h-14 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        {{-- Book Details --}}
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ $item->book->title }}</h3>
                                            <p class="text-[10px] text-gray-500 dark:text-gray-400">{{ $item->book->author }}</p>
                                            <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">Qty: {{ $item->quantity }} × RM {{ number_format($item->price, 2) }}</p>
                                        </div>
                                        
                                        {{-- Price --}}
                                        <div class="text-right">
                                            <p class="text-xs font-bold text-gray-900 dark:text-white">RM {{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Order Totals --}}
                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                <div class="space-y-1 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                                        <span class="text-gray-700 dark:text-gray-300">RM {{ number_format($order->items->sum(fn($item) => $item->price * $item->quantity), 2) }}</span>
                                    </div>
                                    @if($order->shipping_customer_price > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500 dark:text-gray-400">Shipping</span>
                                            <span class="text-gray-700 dark:text-gray-300">RM {{ number_format($order->shipping_customer_price, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($order->discount_amount > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500 dark:text-gray-400">Discount</span>
                                            <span class="text-green-600 dark:text-green-400">-RM {{ number_format($order->discount_amount, 2) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-600">
                                        <span class="font-semibold text-gray-900 dark:text-white">Total</span>
                                        <span class="font-bold text-green-600 dark:text-green-400">RM {{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Shipping & Actions --}}
                    <div class="lg:col-span-2 space-y-4">
                        {{-- Shipping Information --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="p-1.5 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Shipping To</h2>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                                <p class="text-xs font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-[11px] text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}
                                </p>
                                <div class="flex items-center gap-1.5 mt-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="text-[11px] text-gray-600 dark:text-gray-400">{{ $order->shipping_phone }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- What's Next --}}
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl p-4 border border-purple-100 dark:border-purple-800/30">
                            <h3 class="text-xs font-bold text-gray-900 dark:text-white mb-2">What's Next?</h3>
                            <div class="space-y-2">
                                <div class="flex items-start gap-2">
                                    <div class="w-5 h-5 rounded-full bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center flex-shrink-0">
                                        <span class="text-[10px] font-bold text-purple-600 dark:text-purple-400">1</span>
                                    </div>
                                    <p class="text-[11px] text-gray-600 dark:text-gray-400">Confirmation email sent</p>
                                </div>
                                <div class="flex items-start gap-2">
                                    <div class="w-5 h-5 rounded-full bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center flex-shrink-0">
                                        <span class="text-[10px] font-bold text-purple-600 dark:text-purple-400">2</span>
                                    </div>
                                    <p class="text-[11px] text-gray-600 dark:text-gray-400">We'll prepare your books</p>
                                </div>
                                <div class="flex items-start gap-2">
                                    <div class="w-5 h-5 rounded-full bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center flex-shrink-0">
                                        <span class="text-[10px] font-bold text-purple-600 dark:text-purple-400">3</span>
                                    </div>
                                    <p class="text-[11px] text-gray-600 dark:text-gray-400">Track in your account</p>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="space-y-2">
                            <a href="{{ route('profile.orders') }}" 
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors shadow-md shadow-purple-500/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                View My Orders
                            </a>
                            
                            <a href="{{ route('books.index') }}" 
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-lg transition-colors border border-gray-200 dark:border-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Continue Shopping
                            </a>
                        </div>

                        {{-- Help Link --}}
                        <div class="text-center">
                            <a href="{{ route('contact') }}" class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Need help? Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Confetti Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.createElement('div');
    container.style.cssText = 'position:fixed;inset:0;pointer-events:none;z-index:50;overflow:hidden;';
    document.body.appendChild(container);
    
    const colors = ['#10b981', '#8b5cf6', '#ec4899', '#f59e0b', '#3b82f6'];
    
    for (let i = 0; i < 30; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.style.cssText = `
                position: fixed;
                width: 8px;
                height: 8px;
                background: ${colors[Math.floor(Math.random() * colors.length)]};
                left: ${Math.random() * 100}%;
                top: -10px;
                border-radius: ${Math.random() > 0.5 ? '50%' : '0'};
                animation: confetti-fall ${2 + Math.random() * 2}s linear forwards;
                opacity: ${0.6 + Math.random() * 0.4};
            `;
            container.appendChild(confetti);
            setTimeout(() => confetti.remove(), 4000);
        }, i * 40);
    }
    
    setTimeout(() => container.remove(), 5000);
});
</script>

<style>
@keyframes confetti-fall {
    to {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
    }
}
</style>
@endsection
