@extends('layouts.admin')

@section('header', __('Add Postage Rate'))

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    {{-- Page Header --}}
    <div>
        <div class="flex items-center gap-3 mb-1">
            <a href="{{ route('admin.postage-rates.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Add Postage Rate</h1>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Create a new shipping rate for a region</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <form action="{{ route('admin.postage-rates.store') }}" method="POST">
            @csrf
            
            <div class="p-6 space-y-6">
                {{-- Region --}}
                <div>
                    <label for="region" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Region</label>
                    <select name="region" id="region" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-colors">
                        <option value="">Select region</option>
                        @foreach($regions as $region)
                            <option value="{{ $region }}" @selected(old('region') === $region)>{{ __('regions.'.$region) }}</option>
                        @endforeach
                    </select>
                    @error('region')
                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prices --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer Price (RM)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 text-sm">RM</span>
                            <input type="number" step="0.01" min="0" name="customer_price" id="customer_price" value="{{ old('customer_price') }}" required class="w-full pl-12 pr-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-colors" placeholder="0.00">
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Price charged to customer</p>
                        @error('customer_price')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="actual_cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Actual Cost (RM)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 text-sm">RM</span>
                            <input type="number" step="0.01" min="0" name="actual_cost" id="actual_cost" value="{{ old('actual_cost') }}" required class="w-full pl-12 pr-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-colors" placeholder="0.00">
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Your shipping cost</p>
                        @error('actual_cost')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Profit Preview --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Estimated Profit Margin</span>
                        <span id="profit-preview" class="text-lg font-bold text-gray-900 dark:text-white">0%</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/30 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end gap-3">
                <a href="{{ route('admin.postage-rates.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-medium rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                    Create Rate
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerPrice = document.getElementById('customer_price');
        const actualCost = document.getElementById('actual_cost');
        const profitPreview = document.getElementById('profit-preview');

        function updateProfit() {
            const cp = parseFloat(customerPrice.value) || 0;
            const ac = parseFloat(actualCost.value) || 0;
            
            if (ac > 0) {
                const margin = ((cp - ac) / ac) * 100;
                profitPreview.textContent = margin.toFixed(1) + '%';
                profitPreview.className = margin >= 0 
                    ? 'text-lg font-bold text-green-600 dark:text-green-400' 
                    : 'text-lg font-bold text-red-600 dark:text-red-400';
            } else {
                profitPreview.textContent = '0%';
                profitPreview.className = 'text-lg font-bold text-gray-900 dark:text-white';
            }
        }

        customerPrice.addEventListener('input', updateProfit);
        actualCost.addEventListener('input', updateProfit);
    });
</script>
@endsection
