@extends('layouts.admin')

@section('header', 'Shipping Reports')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Shipping Reports</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Track order fulfillment and delivery performance</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Reports
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gray-900 dark:bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-gray-800 dark:hover:bg-blue-700 transition-colors font-medium">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    {{-- Orders by Status --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Orders by Status</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Current order distribution</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </button>
                <button class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel
                </button>
            </div>
        </div>
        @if(isset($ordersByStatus) && count($ordersByStatus) > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                @foreach($ordersByStatus as $status)
                    @php
                        $statusColors = [
                            'pending' => ['bg' => 'bg-amber-50 dark:bg-amber-900/20', 'border' => 'border-amber-100 dark:border-amber-900/30', 'text' => 'text-amber-600 dark:text-amber-400'],
                            'processing' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-100 dark:border-blue-900/30', 'text' => 'text-blue-600 dark:text-blue-400'],
                            'shipped' => ['bg' => 'bg-purple-50 dark:bg-purple-900/20', 'border' => 'border-purple-100 dark:border-purple-900/30', 'text' => 'text-purple-600 dark:text-purple-400'],
                            'delivered' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-green-100 dark:border-green-900/30', 'text' => 'text-green-600 dark:text-green-400'],
                            'cancelled' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'border' => 'border-red-100 dark:border-red-900/30', 'text' => 'text-red-600 dark:text-red-400'],
                        ];
                        $colors = $statusColors[strtolower($status->status)] ?? ['bg' => 'bg-gray-50 dark:bg-gray-700', 'border' => 'border-gray-100 dark:border-gray-600', 'text' => 'text-gray-600 dark:text-gray-400'];
                    @endphp
                    <div class="{{ $colors['bg'] }} rounded-xl p-4 text-center border {{ $colors['border'] }}">
                        <p class="text-2xl font-bold {{ $colors['text'] }}">{{ $status->count }}</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize mt-1">{{ $status->status }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">No order data available</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Try adjusting the date range</p>
            </div>
        @endif
    </div>

    {{-- Average Shipping Time --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Average Shipping Time</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Delivery performance metrics</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </button>
                <button class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5 text-center border border-blue-100 dark:border-blue-900/30">
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $avgShippingTime['avg_days'] ?? 0 }} days</p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">Average Time</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Order to delivery</p>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-5 text-center border border-green-100 dark:border-green-900/30">
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $avgShippingTime['fastest'] ?? 0 }} day</p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">Fastest Delivery</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Best performance</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-5 text-center border border-red-100 dark:border-red-900/30">
                <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $avgShippingTime['slowest'] ?? 0 }} days</p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">Slowest Delivery</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Needs improvement</p>
            </div>
        </div>
    </div>

    {{-- Refunds & Cancellations --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Refunds & Cancellations Rate</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Monitor order issues</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </button>
                <button class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5 text-center border border-blue-100 dark:border-blue-900/30">
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $refundCancellationStats['total_orders'] ?? 0 }}</p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">Total Orders</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">In selected period</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-5 text-center border border-red-100 dark:border-red-900/30">
                <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $refundCancellationStats['cancelled_orders'] ?? 0 }}</p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">Cancelled Orders</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Orders cancelled</p>
            </div>
            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-5 text-center border border-amber-100 dark:border-amber-900/30">
                <p class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $refundCancellationStats['cancellation_rate'] ?? 0 }}%</p>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">Cancellation Rate</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Keep below 5%</p>
            </div>
        </div>
    </div>
</div>
@endsection
