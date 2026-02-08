@extends('layouts.admin')

@section('header', 'Create Coupon')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.coupons.index') }}" 
           class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create New Coupon</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Add a promotional coupon code</p>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-700 dark:text-red-300">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Coupon Details --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Coupon Details</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Coupon Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" id="code" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors font-mono uppercase"
                               placeholder="e.g., SUMMER25" value="{{ old('code') }}" required>
                        @error('code')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <input type="text" name="description" id="description" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               placeholder="e.g., Summer Sale Discount" value="{{ old('description') }}">
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Discount Settings --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Discount Settings</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Discount Type <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50 dark:has-[:checked]:bg-purple-900/30">
                                <input type="radio" name="discount_type" value="fixed" class="text-purple-600 focus:ring-purple-500" {{ old('discount_type', 'fixed') == 'fixed' ? 'checked' : '' }}>
                                <span class="text-gray-700 dark:text-gray-300">Fixed (RM)</span>
                            </label>
                            <label class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50 dark:has-[:checked]:bg-purple-900/30">
                                <input type="radio" name="discount_type" value="percentage" class="text-purple-600 focus:ring-purple-500" {{ old('discount_type') == 'percentage' ? 'checked' : '' }}>
                                <span class="text-gray-700 dark:text-gray-300">Percentage (%)</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="discount_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Discount Value <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span id="discount_symbol" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">RM</span>
                            <input type="number" name="discount_value" id="discount_value" 
                                   class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                                   placeholder="0.00" step="0.01" min="0" value="{{ old('discount_value') }}" required>
                        </div>
                        @error('discount_value')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="min_purchase_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum Purchase Amount (RM)</label>
                    <input type="number" name="min_purchase_amount" id="min_purchase_amount" 
                           class="w-full md:w-1/2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                           placeholder="0.00" step="0.01" min="0" value="{{ old('min_purchase_amount', 0) }}">
                    @error('min_purchase_amount')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="free_shipping" value="0">
                        <div class="relative">
                            <input type="checkbox" name="free_shipping" value="1" class="sr-only peer" {{ old('free_shipping') ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300">Include Free Shipping</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Usage Limits --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Usage Limits</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="max_uses_total" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Maximum Total Uses</label>
                        <input type="number" name="max_uses_total" id="max_uses_total" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               placeholder="Leave empty for unlimited" min="1" value="{{ old('max_uses_total') }}">
                        @error('max_uses_total')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="max_uses_per_user" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Maximum Uses Per User</label>
                        <input type="number" name="max_uses_per_user" id="max_uses_per_user" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               placeholder="Leave empty for unlimited" min="1" value="{{ old('max_uses_per_user') }}">
                        @error('max_uses_per_user')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Validity Period --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Validity Period</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="starts_at" id="starts_at" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               value="{{ old('starts_at', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('starts_at')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Expiry Date <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="expires_at" id="expires_at" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               value="{{ old('expires_at', now()->addMonths(1)->format('Y-m-d\TH:i')) }}" required>
                        @error('expires_at')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.coupons.index') }}" 
               class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-purple-600 text-white font-medium rounded-xl hover:bg-purple-700 transition-colors shadow-sm">
                Create Coupon
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fixedRadio = document.querySelector('input[name="discount_type"][value="fixed"]');
    const percentageRadio = document.querySelector('input[name="discount_type"][value="percentage"]');
    const discountSymbol = document.getElementById('discount_symbol');
    const discountInput = document.getElementById('discount_value');
    
    function updateSymbol() {
        if (fixedRadio.checked) {
            discountSymbol.textContent = 'RM';
            discountInput.removeAttribute('max');
        } else {
            discountSymbol.textContent = '%';
            discountInput.setAttribute('max', '100');
        }
    }
    
    fixedRadio.addEventListener('change', updateSymbol);
    percentageRadio.addEventListener('change', updateSymbol);
    updateSymbol();
});
</script>
@endpush
@endsection
