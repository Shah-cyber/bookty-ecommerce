@extends('layouts.admin')

@section('header', 'Edit Discount')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.discounts.index') }}" 
               class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Discount</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Update discount for: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $discount->book->title }}</span></p>
            </div>
        </div>
        
        <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this discount?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-medium rounded-xl hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete
            </button>
        </form>
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

    {{-- Stats Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex flex-wrap items-center gap-6">
            <div class="flex items-center gap-3">
                @if($discount->book->cover_image)
                    <img class="w-12 h-16 rounded-lg object-cover" src="{{ asset('storage/' . $discount->book->cover_image) }}" alt="{{ $discount->book->title }}">
                @else
                    <div class="w-12 h-16 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @endif
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Book</p>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ Str::limit($discount->book->title, 30) }}</p>
                </div>
            </div>
            <div class="h-8 w-px bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Original Price</p>
                <p class="font-bold text-gray-900 dark:text-gray-100">RM {{ number_format($discount->book->price, 2) }}</p>
            </div>
            <div class="h-8 w-px bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                @if($discount->is_active)
                    <span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400 font-medium">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                        Active
                    </span>
                @else
                    <span class="text-gray-500 dark:text-gray-400 font-medium">Inactive</span>
                @endif
            </div>
            <div class="h-8 w-px bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Created</p>
                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $discount->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.discounts.update', $discount->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        {{-- Book Selection --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Select Book</h2>
            </div>
            <div class="p-6">
                <label for="book_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Book <span class="text-red-500">*</span></label>
                <select id="book_id" name="book_id" 
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors" required>
                    <option value="">Select a book</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id', $discount->book_id) == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} by {{ $book->author }} (RM {{ number_format($book->price, 2) }})
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
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
                                <input type="radio" name="discount_type" value="amount" class="text-purple-600 focus:ring-purple-500" {{ old('discount_type', $discount->discount_amount ? 'amount' : 'percent') == 'amount' ? 'checked' : '' }}>
                                <span class="text-gray-700 dark:text-gray-300">Fixed (RM)</span>
                            </label>
                            <label class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50 dark:has-[:checked]:bg-purple-900/30">
                                <input type="radio" name="discount_type" value="percent" class="text-purple-600 focus:ring-purple-500" {{ old('discount_type', $discount->discount_percent ? 'percent' : 'amount') == 'percent' ? 'checked' : '' }}>
                                <span class="text-gray-700 dark:text-gray-300">Percentage (%)</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="discount_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Discount Value <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span id="discount_symbol" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">{{ $discount->discount_amount ? 'RM' : '%' }}</span>
                            <input type="number" name="discount_value" id="discount_value" 
                                   class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                                   placeholder="0.00" step="0.01" min="0" value="{{ old('discount_value', $discount->discount_amount ?? $discount->discount_percent) }}" required>
                        </div>
                        @error('discount_value')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <input type="text" name="description" id="description" 
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                           placeholder="e.g., Summer Sale, New Release Discount" value="{{ old('description', $discount->description) }}">
                </div>
                
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="free_shipping" value="0">
                        <div class="relative">
                            <input type="checkbox" name="free_shipping" value="1" class="sr-only peer" {{ old('free_shipping', $discount->free_shipping) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300">Include Free Shipping</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Validity Period --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Validity Period</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Optional - leave empty for no time restriction</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date</label>
                        <input type="datetime-local" name="starts_at" id="starts_at" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               value="{{ old('starts_at', $discount->starts_at ? $discount->starts_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                    
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date</label>
                        <input type="datetime-local" name="ends_at" id="ends_at" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               value="{{ old('ends_at', $discount->ends_at ? $discount->ends_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <div class="relative">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $discount->is_active) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                </div>
                <div>
                    <span class="font-medium text-gray-900 dark:text-gray-100">Active</span>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Enable or disable this discount</p>
                </div>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.discounts.index') }}" 
               class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-purple-600 text-white font-medium rounded-xl hover:bg-purple-700 transition-colors shadow-sm">
                Update Discount
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountRadio = document.querySelector('input[name="discount_type"][value="amount"]');
    const percentRadio = document.querySelector('input[name="discount_type"][value="percent"]');
    const discountSymbol = document.getElementById('discount_symbol');
    const discountInput = document.getElementById('discount_value');
    
    function updateSymbol() {
        if (amountRadio.checked) {
            discountSymbol.textContent = 'RM';
            discountInput.removeAttribute('max');
        } else {
            discountSymbol.textContent = '%';
            discountInput.setAttribute('max', '100');
        }
    }
    
    amountRadio.addEventListener('change', updateSymbol);
    percentRadio.addEventListener('change', updateSymbol);
    updateSymbol();
});
</script>
@endpush
@endsection
