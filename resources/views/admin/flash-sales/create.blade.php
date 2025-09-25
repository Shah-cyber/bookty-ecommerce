@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 dark:text-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Create New Flash Sale</h1>
        <a href="{{ route('admin.flash-sales.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Flash Sales
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800 dark:shadow-none">
        <form action="{{ route('admin.flash-sales.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4 dark:text-gray-100">Flash Sale Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Sale Name</label>
                        <input type="text" name="name" id="name" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="e.g., Weekend Flash Sale" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Description (Optional)</label>
                        <input type="text" name="description" id="description" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="e.g., Limited time offers on bestsellers" value="{{ old('description') }}">
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4 dark:text-gray-100">Discount Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Discount Type</label>
                        <div class="mt-2 space-y-4">
                            <div class="flex items-center">
                                <input id="discount_type_fixed" name="discount_type" type="radio" value="fixed" class="h-4 w-4 text-indigo-600 border-gray-300 rounded dark:border-gray-600" {{ old('discount_type', 'fixed') == 'fixed' ? 'checked' : '' }}>
                                <label for="discount_type_fixed" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Fixed Amount (RM)
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="discount_type_percentage" name="discount_type" type="radio" value="percentage" class="h-4 w-4 text-indigo-600 border-gray-300 rounded dark:border-gray-600" {{ old('discount_type') == 'percentage' ? 'checked' : '' }}>
                                <label for="discount_type_percentage" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Percentage (%)
                                </label>
                            </div>
                        </div>
                        @error('discount_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
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
                </div>
            </div>
            
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4 dark:text-gray-100">Sale Period</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Start Date & Time</label>
                        <input type="datetime-local" name="starts_at" id="starts_at" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" value="{{ old('starts_at', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('starts_at')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">End Date & Time</label>
                        <input type="datetime-local" name="ends_at" id="ends_at" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" value="{{ old('ends_at', now()->addDays(3)->format('Y-m-d\TH:i')) }}" required>
                        @error('ends_at')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4 dark:text-gray-100">Select Books</h2>
                
                <div class="mb-4">
                    <label for="genre_filter" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Filter by Genre</label>
                    <select id="genre_filter" class="form-select rounded-md shadow-sm mt-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }} ({{ $genre->books->count() }} books)</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Books</label>
                        <div>
                            <button type="button" id="selectAll" class="text-sm text-indigo-600 hover:text-indigo-900">Select All</button>
                            <span class="text-gray-400 mx-2">|</span>
                            <button type="button" id="deselectAll" class="text-sm text-indigo-600 hover:text-indigo-900">Deselect All</button>
                        </div>
                    </div>
                    
                    <div id="books_container" class="mt-2 border border-gray-300 rounded-md h-64 overflow-y-auto p-4 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($books as $book)
                                <div class="book-item" data-genre="{{ $book->genre_id }}">
                                    <div class="flex items-start space-x-2">
                                        <input type="checkbox" name="books[]" id="book_{{ $book->id }}" value="{{ $book->id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded mt-1 dark:border-gray-600" {{ in_array($book->id, old('books', [])) ? 'checked' : '' }}>
                                        <label for="book_{{ $book->id }}" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                            <span class="font-medium dark:text-gray-100">{{ $book->title }}</span>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">by {{ $book->author }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">RM {{ number_format($book->price, 2) }}</div>
                                        </label>
                                    </div>
                                    <div class="mt-2 ml-6">
                                        <label for="special_prices_{{ $book->id }}" class="block text-xs text-gray-500 dark:text-gray-400">Special Price (Optional)</label>
                                        <input type="number" name="special_prices[{{ $book->id }}]" id="special_prices_{{ $book->id }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md special-price-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Custom price" step="0.01" min="0" value="{{ old('special_prices.' . $book->id) }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('books')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                    Create Flash Sale
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
        
        function updateSymbol() {
            const isFixed = fixedRadio.checked;
            discountSymbol.textContent = isFixed ? 'RM' : '%';
            const discountInput = document.getElementById('discount_value');
            if (isFixed) {
                discountInput.removeAttribute('max');
                discountInput.setAttribute('step', '0.01');
            } else {
                discountInput.setAttribute('max', '100');
                discountInput.setAttribute('step', '0.01');
                // Reset value when switching to percentage
                discountInput.value = '0';
            }
        }
        
        fixedRadio.addEventListener('change', updateSymbol);
        percentageRadio.addEventListener('change', updateSymbol);
        
        // Initial setup
        updateSymbol();
        
        // Genre filter functionality
        const genreFilter = document.getElementById('genre_filter');
        const bookItems = document.querySelectorAll('.book-item');
        
        genreFilter.addEventListener('change', function() {
            const selectedGenre = this.value;
            
            bookItems.forEach(item => {
                if (!selectedGenre || item.dataset.genre === selectedGenre) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                    // Uncheck hidden items
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                }
            });
        });
        
        // Select/Deselect all functionality
        document.getElementById('selectAll').addEventListener('click', function() {
            bookItems.forEach(item => {
                if (item.style.display !== 'none') {
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        checkbox.checked = true;
                        const specialInput = item.querySelector('.special-price-input');
                        if (specialInput) specialInput.removeAttribute('disabled');
                    }
                }
            });
        });
        
        document.getElementById('deselectAll').addEventListener('click', function() {
            bookItems.forEach(item => {
                if (item.style.display !== 'none') {
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        checkbox.checked = false;
                        const specialInput = item.querySelector('.special-price-input');
                        if (specialInput) specialInput.setAttribute('disabled', 'disabled');
                    }
                }
            });
        });
        
        // Load books by genre via AJAX
        genreFilter.addEventListener('change', function() {
            const genreId = this.value;
            if (genreId) {
                fetch(`{{ route('admin.flash-sales.books-by-genre') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ genre_id: genreId })
                })
                .then(response => response.json())
                .then(data => {
                    // Process the response if needed
                    console.log('Books loaded:', data.books.length);
                })
                .catch(error => {
                    console.error('Error loading books:', error);
                });
            }
        });

        // Enable/disable special price inputs based on book selection
        document.querySelectorAll('.book-item').forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            const specialInput = item.querySelector('.special-price-input');
            if (checkbox && specialInput) {
                const sync = () => {
                    if (checkbox.checked) {
                        specialInput.removeAttribute('disabled');
                    } else {
                        specialInput.setAttribute('disabled', 'disabled');
                        specialInput.value = '';
                    }
                };
                sync();
                checkbox.addEventListener('change', sync);
            }
        });
    });
</script>
@endsection
