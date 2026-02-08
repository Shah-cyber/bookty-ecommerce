@extends('layouts.admin')

@section('header', 'Edit Flash Sale')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.flash-sales.index') }}" 
               class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Flash Sale</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Update: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $flashSale->name }}</span></p>
            </div>
        </div>
        
        <form action="{{ route('admin.flash-sales.destroy', $flashSale->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this flash sale?');">
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

    @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Stats Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex flex-wrap items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sale</p>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $flashSale->name }}</p>
                </div>
            </div>
            <div class="h-8 w-px bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Books</p>
                <p class="font-bold text-gray-900 dark:text-gray-100">{{ $flashSale->books->count() }}</p>
            </div>
            <div class="h-8 w-px bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                @if($flashSale->isActive())
                    <span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400 font-medium">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        Live
                    </span>
                @elseif($flashSale->is_active && $flashSale->starts_at > now())
                    <span class="text-yellow-600 dark:text-yellow-400 font-medium">Scheduled</span>
                @elseif($flashSale->ends_at < now())
                    <span class="text-gray-500 dark:text-gray-400 font-medium">Ended</span>
                @else
                    <span class="text-red-500 dark:text-red-400 font-medium">Inactive</span>
                @endif
            </div>
            <div class="h-8 w-px bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Created</p>
                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $flashSale->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.flash-sales.update', $flashSale->id) }}" method="POST" class="space-y-6" id="flash-sale-form">
        @csrf
        @method('PUT')
        
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
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors"
                               placeholder="e.g., Weekend Flash Sale" value="{{ old('name', $flashSale->name) }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <input type="text" name="description" id="description" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors"
                               placeholder="e.g., Limited time offers on bestsellers" value="{{ old('description', $flashSale->description) }}">
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
                                <input type="radio" name="discount_type" value="fixed" class="text-rose-600 focus:ring-rose-500" {{ old('discount_type', $flashSale->discount_type) == 'fixed' ? 'checked' : '' }}>
                                <span class="text-gray-700 dark:text-gray-300">Fixed (RM)</span>
                            </label>
                            <label class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-900/30">
                                <input type="radio" name="discount_type" value="percentage" class="text-rose-600 focus:ring-rose-500" {{ old('discount_type', $flashSale->discount_type) == 'percentage' ? 'checked' : '' }}>
                                <span class="text-gray-700 dark:text-gray-300">Percentage (%)</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="discount_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Discount Value <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span id="discount_symbol" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">{{ $flashSale->discount_type == 'fixed' ? 'RM' : '%' }}</span>
                            <input type="number" name="discount_value" id="discount_value" 
                                   class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors"
                                   placeholder="0.00" step="0.01" min="0" value="{{ old('discount_value', $flashSale->discount_value) }}" required>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="free_shipping" value="0">
                        <div class="relative">
                            <input type="checkbox" name="free_shipping" value="1" class="sr-only peer" {{ old('free_shipping', $flashSale->free_shipping) ? 'checked' : '' }}>
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
                               value="{{ old('starts_at', $flashSale->starts_at->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date & Time <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="ends_at" id="ends_at" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors"
                               value="{{ old('ends_at', $flashSale->ends_at->format('Y-m-d\TH:i')) }}" required>
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
                            @php
                                $isSelected = in_array($book->id, old('books', $flashSale->books->pluck('id')->toArray()));
                                $specialPrice = old('special_prices.' . $book->id, isset($specialPrices[$book->id]) ? $specialPrices[$book->id] : '');
                            @endphp
                            <div class="book-item p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-rose-300 dark:hover:border-rose-700 transition-colors {{ $isSelected ? 'border-rose-300 bg-rose-50/50 dark:border-rose-700 dark:bg-rose-900/20' : '' }}" data-genre="{{ $book->genre_id }}">
                                <div class="flex items-start gap-3">
                                    <input type="checkbox" name="books[]" id="book_{{ $book->id }}" value="{{ $book->id }}" 
                                           class="h-4 w-4 mt-1 text-rose-600 border-gray-300 rounded focus:ring-rose-500 dark:border-gray-600 book-checkbox" 
                                           {{ $isSelected ? 'checked' : '' }}>
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
                                           value="{{ $specialPrice }}" {{ !$isSelected ? 'disabled' : '' }}>
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

        {{-- Status --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <div class="relative">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $flashSale->is_active) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                </div>
                <div>
                    <span class="font-medium text-gray-900 dark:text-gray-100">Active</span>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Enable or disable this flash sale</p>
                </div>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.flash-sales.index') }}" 
               class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-rose-600 text-white font-medium rounded-xl hover:bg-rose-700 transition-colors shadow-sm">
                Update Flash Sale
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
