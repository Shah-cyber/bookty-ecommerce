@extends('layouts.admin')

@section('header', __('Postage Rate History'))

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.postage-rates.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">{{ strtoupper($region) }} Region History</h1>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Price change timeline for {{ __('regions.'.$region) }}</p>
        </div>
        <a href="{{ route('admin.postage-rates.all-history') }}" class="inline-flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            View All Regions
        </a>
    </div>

    {{-- Current Rate Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Current Active Rate</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ strtoupper($rate->region) }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-gray-900 dark:text-white">RM {{ number_format($rate->customer_price, 2) }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Cost: RM {{ number_format($rate->actual_cost, 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Timeline --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Price Change Timeline</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Complete audit trail of all price changes</p>
        </div>

        <div class="p-6">
            @forelse($timeline as $log)
                <div class="relative pl-8 pb-8 last:pb-0 border-l-2 {{ $log->isCurrent() ? 'border-green-400' : 'border-gray-200 dark:border-gray-700' }} last:border-transparent">
                    {{-- Timeline Dot --}}
                    <div class="absolute -left-2.5 top-0 w-5 h-5 rounded-full {{ $log->isCurrent() ? 'bg-green-500 ring-4 ring-green-100 dark:ring-green-900/50' : 'bg-gray-300 dark:bg-gray-600' }}">
                        @if($log->isCurrent())
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        @endif
                    </div>

                    {{-- Timeline Content --}}
                    <div class="ml-6">
                        {{-- Header --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $log->updater_name }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">updated pricing</span>
                                @if($log->isCurrent())
                                    <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full">Current</span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $log->created_at->format('d M Y, H:i') }}
                                <span class="text-gray-400 dark:text-gray-500">({{ $log->created_at->diffForHumans() }})</span>
                            </div>
                        </div>

                        {{-- Price Card --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Customer Price</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">RM {{ number_format($log->customer_price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Actual Cost</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">RM {{ number_format($log->actual_cost, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Profit Margin</p>
                                    @php $margin = $log->getProfitMargin(); @endphp
                                    <p class="text-lg font-bold {{ $margin >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ number_format($margin, 2) }}%</p>
                                </div>
                            </div>
                        </div>

                        {{-- Comment --}}
                        @if($log->comment)
                            <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 rounded-r-lg p-3 mb-3">
                                <p class="text-xs font-medium text-blue-700 dark:text-blue-300 mb-1">Note</p>
                                <p class="text-sm text-blue-800 dark:text-blue-200">{{ $log->comment }}</p>
                            </div>
                        @endif

                        {{-- Metadata --}}
                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                            <span>Valid from: {{ $log->valid_from->format('d M Y H:i') }}</span>
                            @if($log->valid_until)
                                <span>to {{ $log->valid_until->format('d M Y H:i') }}</span>
                                <span class="text-gray-400">({{ $log->getValidDuration() }})</span>
                            @endif
                            <a href="{{ route('admin.orders.index', ['postage_history' => $log->id]) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                {{ $log->orders->count() }} orders used this rate
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">No history records found</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
