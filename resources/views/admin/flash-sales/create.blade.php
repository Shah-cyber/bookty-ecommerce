@extends('layouts.admin')

@section('header', 'Create Flash Sale')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.flash-sales.index') }}" 
           class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create Flash Sale</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Set up a time-limited promotional event</p>
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

    <form action="{{ route('admin.flash-sales.store') }}" method="POST" class="space-y-6" id="flash-sale-form">
        @csrf
        
        {{-- Sale Details --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Flash Sale Details</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sale Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               placeholder="e.g., Weekend Flash Sale" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <input type="text" name="description" id="description" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"
                               placeholder="e.g., Limited time offers on bestsellers" value="{{ old('description') }}">
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
                            <label class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-900/30">
                                <input type="radio" name="discount_type" value="fixed" class="text-rose-600 focus:ring-rose-500" {{ old('discount_type', 'fixed') == 'fixed' ? 'checked' : '' }}>
                                <span class="text-gray-700 dark:text-gray-300">Fixed (RM)</span>
                            </label>
                            <label class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-900/30">
                                <input type="radio" name="discount_type" value="percentage" class="text-rose-600 focus:ring-rose-500" {{ old('discount_type') == 'percentage' ? 'checked' : '' }}>
                                <span class="text-gray-700 dark:text-gray-300">Percentage (%)</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="discount_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Discount Value <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span id="discount_symbol" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">RM</span>
                            <input type="number" name="discount_value" id="discount_value" 
                                   class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors"
                                   placeholder="0.00" step="0.01" min="0" value="{{ old('discount_value') }}" required>
                        </div>
                        @error('discount_value')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="free_shipping" value="0">
                        <div class="relative">
                            <input type="checkbox" name="free_shipping" value="1" class="sr-only peer" {{ old('free_shipping') ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-600"></div>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300">Include Free Shipping</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Sale Period --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Sale Period</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date & Time <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="starts_at" id="starts_at" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors"
                               value="{{ old('starts_at', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('starts_at')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date & Time <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="ends_at" id="ends_at" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors"
                               value="{{ old('ends_at', now()->addDays(3)->format('Y-m-d\TH:i')) }}" required>
                        @error('ends_at')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Book Selection --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Select Books</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Choose books to include in this flash sale</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" id="selectAll" class="text-sm text-rose-600 hover:text-rose-700 dark:text-rose-400 font-medium">Select All</button>
                        <span class="text-gray-300 dark:text-gray-600">|</span>
                        <button type="button" id="deselectAll" class="text-sm text-gray-600 hover:text-gray-700 dark:text-gray-400 font-medium">Deselect All</button>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                {{-- Genre Filter --}}
                <div>
                    <label for="genre_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Genre</label>
                    <select id="genre_filter" 
                            class="w-full md:w-64 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }} ({{ $genre->books->count() }} books)</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Books Grid --}}
                <div id="books_container" class="border border-gray-200 dark:border-gray-700 rounded-xl max-h-96 overflow-y-auto p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($books as $book)
                            <div class="book-item p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-rose-300 dark:hover:border-rose-700 transition-colors" data-genre="{{ $book->genre_id }}">
                                <div class="flex items-start gap-3">
                                    <input type="checkbox" name="books[]" id="book_{{ $book->id }}" value="{{ $book->id }}" 
                                           class="h-4 w-4 mt-1 text-rose-600 border-gray-300 rounded focus:ring-rose-500 dark:border-gray-600 book-checkbox" 
                                           {{ in_array($book->id, old('books', [])) ? 'checked' : '' }}>
                                    <label for="book_{{ $book->id }}" class="flex-1 cursor-pointer">
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ Str::limit($book->title, 30) }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $book->author }}</p>
                                        <p class="text-sm font-medium text-rose-600 dark:text-rose-400 mt-1">RM {{ number_format($book->price, 2) }}</p>
                                    </label>
                                </div>
                                <div class="mt-3">
                                    <label for="special_prices_{{ $book->id }}" class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Special Price (Optional)</label>
                                    <input type="number" name="special_prices[{{ $book->id }}]" id="special_prices_{{ $book->id }}" 
                                           class="w-full px-3 py-1.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-rose-500 focus:border-transparent special-price-input disabled:opacity-50 disabled:cursor-not-allowed" 
                                           placeholder="Custom price" step="0.01" min="0" 
                                           value="{{ old('special_prices.' . $book->id) }}" disabled>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                @error('books')
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                
                <p id="validation-error" class="text-sm text-red-600 dark:text-red-400 hidden">Please select at least one book for the flash sale.</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.flash-sales.index') }}" 
               class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-rose-600 text-white font-medium rounded-xl hover:bg-rose-700 transition-colors shadow-sm">
                Create Flash Sale
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Discount type toggle
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
    
    // Genre filter
    const genreFilter = document.getElementById('genre_filter');
    const bookItems = document.querySelectorAll('.book-item');
    
    genreFilter.addEventListener('change', function() {
        const selectedGenre = this.value;
        
        bookItems.forEach(item => {
            if (!selectedGenre || item.dataset.genre === selectedGenre) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
    
    // Select/Deselect all
    document.getElementById('selectAll').addEventListener('click', function() {
        bookItems.forEach(item => {
            if (item.style.display !== 'none') {
                const checkbox = item.querySelector('input[type="checkbox"]');
                const specialInput = item.querySelector('.special-price-input');
                if (checkbox) {
                    checkbox.checked = true;
                    if (specialInput) specialInput.disabled = false;
                }
            }
        });
    });
    
    document.getElementById('deselectAll').addEventListener('click', function() {
        bookItems.forEach(item => {
            if (item.style.display !== 'none') {
                const checkbox = item.querySelector('input[type="checkbox"]');
                const specialInput = item.querySelector('.special-price-input');
                if (checkbox) {
                    checkbox.checked = false;
                    if (specialInput) {
                        specialInput.disabled = true;
                        specialInput.value = '';
                    }
                }
            }
        });
    });
    
    // Enable/disable special price inputs
    bookItems.forEach(item => {
        const checkbox = item.querySelector('input[type="checkbox"]');
        const specialInput = item.querySelector('.special-price-input');
        if (checkbox && specialInput) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    specialInput.disabled = false;
                } else {
                    specialInput.disabled = true;
                    specialInput.value = '';
                }
            });
        }
    });
    
    // Form validation
    const form = document.getElementById('flash-sale-form');
    const validationError = document.getElementById('validation-error');
    const bookCheckboxes = document.querySelectorAll('.book-checkbox');
    
    form.addEventListener('submit', function(e) {
        const checkedBooks = Array.from(bookCheckboxes).filter(cb => cb.checked);
        
        if (checkedBooks.length === 0) {
            e.preventDefault();
            validationError.classList.remove('hidden');
            validationError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            validationError.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection
