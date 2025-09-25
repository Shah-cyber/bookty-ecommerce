@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 dark:text-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create New Discount</h1>
        <a href="{{ route('admin.discounts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Discounts
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 dark:bg-red-900 dark:border-red-400 dark:text-red-200" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800 dark:shadow-none">
        <form action="{{ route('admin.discounts.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="book_id" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Book</label>
                <select id="book_id" name="book_id" class="form-select rounded-md shadow-sm mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" required>
                    <option value="">Select a book</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} by {{ $book->author }} (RM {{ number_format($book->price, 2) }})
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Discount Type</label>
                <div class="mt-2 space-y-4">
                    <div class="flex items-center">
                        <input id="discount_type_amount" name="discount_type" type="radio" value="amount" class="h-4 w-4 text-indigo-600 border-gray-300 rounded dark:border-gray-600" {{ old('discount_type', 'amount') == 'amount' ? 'checked' : '' }}>
                        <label for="discount_type_amount" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Fixed Amount (RM)
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="discount_type_percent" name="discount_type" type="radio" value="percent" class="h-4 w-4 text-indigo-600 border-gray-300 rounded dark:border-gray-600" {{ old('discount_type') == 'percent' ? 'checked' : '' }}>
                        <label for="discount_type_percent" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
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
                        RM
                    </span>
                    <input type="number" name="discount_value" id="discount_value" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="0.00" step="0.01" min="0" value="{{ old('discount_value') }}" required>
                </div>
                @error('discount_value')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Start Date (Optional)</label>
                    <input type="datetime-local" name="starts_at" id="starts_at" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" value="{{ old('starts_at') }}">
                    @error('starts_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="ends_at" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">End Date (Optional)</label>
                    <input type="datetime-local" name="ends_at" id="ends_at" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" value="{{ old('ends_at') }}">
                    @error('ends_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Description (Optional)</label>
                <input type="text" name="description" id="description" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="E.g., Summer Sale, New Release Discount" value="{{ old('description') }}">
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                    Create Discount
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle between RM and % symbols based on discount type
    document.addEventListener('DOMContentLoaded', function() {
        const amountRadio = document.getElementById('discount_type_amount');
        const percentRadio = document.getElementById('discount_type_percent');
        const discountSymbol = document.getElementById('discount_symbol');
        const discountInput = document.getElementById('discount_value');
        let currentType = amountRadio.checked ? 'amount' : 'percent';
        let lastAmountValue = currentType === 'amount' ? discountInput.value : '';
        let lastPercentValue = currentType === 'percent' ? discountInput.value : '';
        
        function applyTypeAttributes(type) {
            if (type === 'amount') {
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
            if (currentType === 'amount') {
                lastAmountValue = discountInput.value;
            } else {
                lastPercentValue = discountInput.value;
            }
            
            discountInput.value = newType === 'amount' ? (lastAmountValue || '0') : (lastPercentValue || '0');
            applyTypeAttributes(newType);
            currentType = newType;
        }
        
        discountInput.addEventListener('input', function() {
            if (currentType === 'amount') {
                lastAmountValue = discountInput.value;
            } else {
                lastPercentValue = discountInput.value;
            }
        });
        
        amountRadio.addEventListener('change', function() { switchType('amount'); });
        percentRadio.addEventListener('change', function() { switchType('percent'); });
        
        // Initial setup
        applyTypeAttributes(currentType);
    });
</script>
@endsection
