@extends('layouts.admin')

@section('header', __('Postage Rate History: ') . strtoupper($region))

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.postage-rates.index') }}" class="text-bookty-purple-600 hover:text-bookty-purple-800 text-sm">&larr; {{ __('Back to Postage Rates') }}</a>
        <a href="{{ route('admin.postage-rates.all-history') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            📊 View All Regions History
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Current Rate</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Region: {{ strtoupper($rate->region) }}</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500 dark:text-gray-400">Customer Price</div>
                <div class="text-2xl font-bold text-bookty-purple-600">RM {{ number_format($rate->customer_price, 2) }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Cost: RM {{ number_format($rate->actual_cost, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                Price Change Timeline
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Complete audit trail of all price changes
            </p>
        </div>

        <div class="p-6">
            @forelse($timeline as $log)
            <div class="flex mb-6 pb-6 border-b last:border-0 border-gray-200 dark:border-gray-700">
                <!-- Timeline Icon -->
                <div class="flex-shrink-0 mr-4">
                    <div class="w-10 h-10 rounded-full {{ $log->isCurrent() ? 'bg-green-100 dark:bg-green-900' : 'bg-blue-100 dark:bg-blue-900' }} flex items-center justify-center">
                        <svg class="w-5 h-5 {{ $log->isCurrent() ? 'text-green-600 dark:text-green-400' : 'text-blue-600 dark:text-blue-400' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Timeline Content -->
                <div class="flex-grow">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $log->updater_name }}
                            </span>
                            <span class="text-gray-500 dark:text-gray-400">updated pricing</span>
                            
                            @if($log->isCurrent())
                            <span class="ml-2 px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 dark:bg-green-900/50 dark:text-green-300 rounded">
                                Current
                            </span>
                            @endif
                        </div>
                        
                        <div class="text-right">
                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $log->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price Information -->
                    <div class="grid grid-cols-2 gap-4 mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded">
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                Customer Price
                            </div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                RM {{ number_format($log->customer_price, 2) }}
                            </div>
                        </div>
                        
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                Actual Cost
                            </div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                RM {{ number_format($log->actual_cost, 2) }}
                            </div>
                        </div>
                        
                        <div class="col-span-2">
                            <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                Profit Margin
                            </div>
                            <div class="text-sm font-semibold text-green-600 dark:text-green-400">
                                {{ number_format($log->getProfitMargin(), 2) }}%
                            </div>
                        </div>
                    </div>
                    
                    <!-- Comment -->
                    @if($log->comment)
                    <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-400 rounded">
                        <div class="text-xs text-blue-800 dark:text-blue-300 font-semibold mb-1">
                            💬 Note:
                        </div>
                        <div class="text-sm text-blue-900 dark:text-blue-200">
                            {{ $log->comment }}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Metadata -->
                    <div class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                        Valid from: {{ $log->valid_from->format('d M Y H:i:s') }}
                        @if($log->valid_until)
                            to {{ $log->valid_until->format('d M Y H:i:s') }}
                            <span class="text-gray-500">({{ $log->getValidDuration() }})</span>
                        @endif
                    </div>
                    
                    <!-- Orders Count -->
                    <div class="mt-2">
                        <a href="{{ route('admin.orders.index', ['postage_history' => $log->id]) }}" 
                           class="text-xs text-blue-600 hover:underline dark:text-blue-400">
                            📦 View orders using this rate ({{ $log->orders->count() }})
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>No history records found</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection
