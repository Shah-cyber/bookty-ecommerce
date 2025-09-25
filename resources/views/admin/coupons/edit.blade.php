@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 dark:text-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Coupon</h1>
        <a href="{{ route('admin.coupons.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Coupons
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800 dark:shadow-none">
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Coupon Code</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="code" id="code" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="e.g., SUMMER25" value="{{ old('code', $coupon->code) }}" required>
                        </div>
                        @error('code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Description (Optional)</label>
                        <input type="text" name="description" id="description" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="e.g., Summer Sale Discount" value="{{ old('description', $coupon->description) }}">
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Discount Type</label>
                        <div class="mt-2 space-y-4">
                            <div class="flex items-center">
                                <input id="discount_type_fixed" name="discount_type" type="radio" value="fixed" class="h-4 w-4 text-indigo-600 border-gray-300 rounded dark:border-gray-600" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'checked' : '' }}>
                                <label for="discount_type_fixed" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Fixed Amount (RM)
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="discount_type_percentage" name="discount_type" type="radio" value="percentage" class="h-4 w-4 text-indigo-600 border-gray-300 rounded dark:border-gray-600" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'checked' : '' }}>
                                <label for="discount_type_percentage" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Percentage (%)
                                </label>
                            </div>
                        </div>
                        @error('discount_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Discount Value</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" id="discount_symbol">
                                {{ $coupon->discount_type == 'fixed' ? 'RM' : '%' }}
                            </span>
                            <input type="number" name="discount_value" id="discount_value" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="0.00" step="0.01" min="0" value="{{ old('discount_value', $coupon->discount_value) }}" required>
                        </div>
                        @error('discount_value')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <div class="mb-4">
                        <label for="min_purchase_amount" class="block text sm font-medium text-gray-700 mb-2 dark:text-gray-300">Minimum Purchase Amount (RM)</label>
                        <input type="number" name="min_purchase_amount" id="min_purchase_amount" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="0.00" step="0.01" min="0" value="{{ old('min_purchase_amount', $coupon->min_purchase_amount) }}">
                        @error('min_purchase_amount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="max_uses_total" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Maximum Total Uses (leave empty for unlimited)</label>
                        <input type="number" name="max_uses_total" id="max_uses_total" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="e.g., 100" min="1" value="{{ old('max_uses_total', $coupon->max_uses_total) }}">
                        @error('max_uses_total')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="max_uses_per_user" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Maximum Uses Per User (leave empty for unlimited)</label>
                        <input type="number" name="max_uses_per_user" id="max_uses_per_user" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="e.g., 1" min="1" value="{{ old('max_uses_per_user', $coupon->max_uses_per_user) }}">
                        @error('max_uses_per_user')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div>
                    <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Start Date</label>
                    <input type="datetime-local" name="starts_at" id="starts_at" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" value="{{ old('starts_at', $coupon->starts_at->format('Y-m-d\TH:i')) }}" required>
                    @error('starts_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Expiry Date</label>
                    <input type="datetime-local" name="expires_at" id="expires_at" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" value="{{ old('expires_at', $coupon->expires_at->format('Y-m-d\TH:i')) }}" required>
                    @error('expires_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6">
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input id="is_active" name="is_active" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded dark:border-gray-600" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">
                        Active
                    </label>
                </div>
                @error('is_active')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                    Update Coupon
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle between RM and % symbols based on discount type
        const fixedRadio = document.getElementById('discount_type_fixed');
        const percentageRadio = document.getElementById('discount_type_percentage');
        const discountSymbol = document.getElementById('discount_symbol');
        const discountInput = document.getElementById('discount_value');
        let currentType = fixedRadio.checked ? 'fixed' : 'percentage';
        let lastFixedValue = currentType === 'fixed' ? discountInput.value : '';
        let lastPercentageValue = currentType === 'percentage' ? discountInput.value : '';
        
        function applyTypeAttributes(type) {
            if (type === 'fixed') {
                discountSymbol.textContent = 'RM';
                discountInput.removeAttribute('max');
                discountInput.setAttribute('step', '0.01');
            } else {
                discountSymbol.textContent = '%';
                discountInput.setAttribute('max', '100');
                discountInput.setAttribute('step', '0.01');
            }
        }
        function switchType(newType) {
            if (currentType === 'fixed') { lastFixedValue = discountInput.value; } else { lastPercentageValue = discountInput.value; }
            discountInput.value = newType === 'fixed' ? (lastFixedValue || '0') : (lastPercentageValue || '0');
            applyTypeAttributes(newType);
            currentType = newType;
        }
        discountInput.addEventListener('input', function(){ if (currentType === 'fixed') { lastFixedValue = discountInput.value; } else { lastPercentageValue = discountInput.value; } });
        fixedRadio.addEventListener('change', function(){ switchType('fixed'); });
        percentageRadio.addEventListener('change', function(){ switchType('percentage'); });
        applyTypeAttributes(currentType);
        
        // No auto-generate; admin will input code manually
    });
</script>
@endsection
