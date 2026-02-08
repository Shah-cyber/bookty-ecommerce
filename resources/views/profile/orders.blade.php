@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Page Header --}}
        <div class="mb-8" data-aos="fade-up">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Order History</h1>
                    <p class="text-gray-500 mt-1">Track and manage your orders</p>
                </div>
                <a href="{{ route('books.index') }}" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all duration-200 self-start sm:self-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    New Order
                </a>
            </div>
        </div>

        @if($orders->count() > 0)
            {{-- Order Statistics --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8" data-aos="fade-up" data-aos-delay="100">
                @php
                    $totalOrders = $orders->total();
                    $pendingOrders = $orders->where('status', 'pending')->count() + $orders->where('status', 'processing')->count();
                    $shippedOrders = $orders->where('status', 'shipped')->count();
                    $completedOrders = $orders->where('status', 'completed')->count();
                @endphp
                
                <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
                            <p class="text-xs text-gray-500">Total Orders</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders }}</p>
                            <p class="text-xs text-gray-500">In Progress</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $shippedOrders }}</p>
                            <p class="text-xs text-gray-500">Shipped</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $completedOrders }}</p>
                            <p class="text-xs text-gray-500">Delivered</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Orders List --}}
            <div class="space-y-4" data-aos="fade-up" data-aos-delay="200">
                @foreach($orders as $order)
                    @php
                        $statusConfig = match($order->status) {
                            'pending' => [
                                'label' => 'Order Placed',
                                'bg' => 'bg-blue-50',
                                'text' => 'text-blue-700',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
                                'step' => 1
                            ],
                            'processing' => [
                                'label' => 'Processing',
                                'bg' => 'bg-amber-50',
                                'text' => 'text-amber-700',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
                                'step' => 2
                            ],
                            'shipped' => [
                                'label' => 'Shipped',
                                'bg' => 'bg-indigo-50',
                                'text' => 'text-indigo-700',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
                                'step' => 3
                            ],
                            'completed' => [
                                'label' => 'Delivered',
                                'bg' => 'bg-green-50',
                                'text' => 'text-green-700',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                'step' => 4
                            ],
                            'cancelled' => [
                                'label' => 'Cancelled',
                                'bg' => 'bg-red-50',
                                'text' => 'text-red-700',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
                                'step' => 0
                            ],
                            default => [
                                'label' => 'Unknown',
                                'bg' => 'bg-gray-50',
                                'text' => 'text-gray-700',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                'step' => 0
                            ]
                        };
                    @endphp
                    
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                        {{-- Order Header --}}
                        <div class="p-4 sm:p-6 border-b border-gray-100">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-start sm:items-center gap-4">
                                    {{-- Status Icon --}}
                                    <div class="w-12 h-12 {{ $statusConfig['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 {{ $statusConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $statusConfig['icon'] !!}
                                        </svg>
                                    </div>
                                    
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="font-bold text-gray-900">Order #{{ $order->public_id ?? $order->id }}</h3>
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                                {{ $statusConfig['label'] }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Placed on {{ $order->created_at->format('F d, Y') }} at {{ $order->created_at->format('g:i A') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">Total Amount</p>
                                        <p class="text-xl font-bold text-gray-900">RM {{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Progress Bar (for non-cancelled orders) --}}
                        @if($order->status !== 'cancelled')
                            <div class="px-4 sm:px-6 py-4 bg-gray-50">
                                <div class="flex items-center justify-between mb-2">
                                    @php $currentStep = $statusConfig['step']; @endphp
                                    
                                    {{-- Step 1: Order Placed --}}
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-8 h-8 rounded-full {{ $currentStep >= 1 ? 'bg-gray-900 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-xs font-bold">
                                            @if($currentStep >= 1)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                1
                                            @endif
                                        </div>
                                        <span class="text-[10px] sm:text-xs text-gray-500 mt-1 text-center">Placed</span>
                                    </div>
                                    
                                    {{-- Connector --}}
                                    <div class="flex-1 h-1 mx-1 sm:mx-2 rounded {{ $currentStep >= 2 ? 'bg-gray-900' : 'bg-gray-200' }}"></div>
                                    
                                    {{-- Step 2: Processing --}}
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-8 h-8 rounded-full {{ $currentStep >= 2 ? 'bg-gray-900 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-xs font-bold">
                                            @if($currentStep >= 2)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                2
                                            @endif
                                        </div>
                                        <span class="text-[10px] sm:text-xs text-gray-500 mt-1 text-center">Processing</span>
                                    </div>
                                    
                                    {{-- Connector --}}
                                    <div class="flex-1 h-1 mx-1 sm:mx-2 rounded {{ $currentStep >= 3 ? 'bg-gray-900' : 'bg-gray-200' }}"></div>
                                    
                                    {{-- Step 3: Shipped --}}
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-8 h-8 rounded-full {{ $currentStep >= 3 ? 'bg-gray-900 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-xs font-bold">
                                            @if($currentStep >= 3)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                3
                                            @endif
                                        </div>
                                        <span class="text-[10px] sm:text-xs text-gray-500 mt-1 text-center">Shipped</span>
                                    </div>
                                    
                                    {{-- Connector --}}
                                    <div class="flex-1 h-1 mx-1 sm:mx-2 rounded {{ $currentStep >= 4 ? 'bg-gray-900' : 'bg-gray-200' }}"></div>
                                    
                                    {{-- Step 4: Delivered --}}
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-8 h-8 rounded-full {{ $currentStep >= 4 ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400' }} flex items-center justify-center text-xs font-bold">
                                            @if($currentStep >= 4)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            @else
                                                4
                                            @endif
                                        </div>
                                        <span class="text-[10px] sm:text-xs text-gray-500 mt-1 text-center">Delivered</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Order Items Preview & Actions --}}
                        <div class="p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                {{-- Items Preview --}}
                                <div class="flex items-center gap-3">
                                    @if($order->items->count() > 0)
                                        <div class="flex -space-x-3">
                                            @foreach($order->items->take(3) as $item)
                                                @if($item->book && $item->book->cover_image)
                                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                                        alt="{{ $item->book->title }}" 
                                                        class="w-12 h-16 object-cover rounded-lg border-2 border-white shadow-sm">
                                                @else
                                                    <div class="w-12 h-16 bg-gray-100 rounded-lg border-2 border-white shadow-sm flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if($order->items->count() > 3)
                                                <div class="w-12 h-16 bg-gray-100 rounded-lg border-2 border-white shadow-sm flex items-center justify-center">
                                                    <span class="text-xs font-bold text-gray-500">+{{ $order->items->count() - 3 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $order->items->sum('quantity') }} {{ Str::plural('item', $order->items->sum('quantity')) }}</p>
                                            <p class="text-xs text-gray-500">
                                                @if($order->items->first() && $order->items->first()->book)
                                                    {{ Str::limit($order->items->first()->book->title, 25) }}
                                                    @if($order->items->count() > 1)
                                                        & more
                                                    @endif
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($order->hasTrackingNumber())
                                        <button onclick="copyAndTrackPackage('{{ $order->tracking_number }}', '{{ $order->getJtTrackingUrl() }}')" 
                                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Track Package
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('profile.orders.show', $order->id) }}" 
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                                        View Details
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="mt-8" data-aos="fade-up">
                    {{ $orders->links() }}
                </div>
            @endif

        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-8 sm:p-12 text-center" data-aos="fade-up">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">No orders yet</h2>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">Start exploring our book collection and place your first order!</p>
                <a href="{{ route('books.index') }}" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Browse Books
                </a>
            </div>
        @endif

    </div>
</div>

{{-- Tracking Script --}}
<script>
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
</script>
@endsection
