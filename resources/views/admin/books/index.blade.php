@extends('layouts.admin')

@section('header', 'Books')

@push('styles')
<style>
    .condition-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.2em 1.2em;
        padding-right: 2rem;
    }
    
    .stock-input::-webkit-outer-spin-button,
    .stock-input::-webkit-inner-spin-button,
    .price-input::-webkit-outer-spin-button,
    .price-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    .stock-input[type=number],
    .price-input[type=number] {
        -moz-appearance: textfield;
    }
    
    #loading-overlay {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(4px);
    }
    
    .dark #loading-overlay {
        background: rgba(31, 41, 55, 0.8);
    }
    
    .book-row {
        transition: all 0.2s ease;
    }
    
    .book-row.updating {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .book-row.highlight {
        animation: highlightRow 1s ease-out;
    }
    
    @keyframes highlightRow {
        0% { background-color: rgba(147, 51, 234, 0.1); }
        100% { background-color: transparent; }
    }
</style>
@endpush

@section('content')
    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Books Management</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your book inventory, pricing, and stock levels</p>
            </div>
            <a href="{{ route('admin.books.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-purple-600 rounded-xl hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-900 shadow-lg shadow-purple-200 dark:shadow-none transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Book
            </a>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total Books</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white" id="stat-total">{{ \App\Models\Book::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">In Stock</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white" id="stat-instock">{{ \App\Models\Book::where('stock', '>', 10)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Low Stock</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white" id="stat-lowstock">{{ \App\Models\Book::whereBetween('stock', [1, 10])->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Out of Stock</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-white" id="stat-outstock">{{ \App\Models\Book::where('stock', 0)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm mb-6">
        <div class="p-4">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                {{-- Search --}}
                <div class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input 
                            type="text" 
                            id="search-input" 
                            placeholder="Search by title, author, or slug..." 
                            class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                        >
                    </div>
                </div>
                
                {{-- Filters --}}
                <div class="flex flex-wrap items-center gap-3">
                    {{-- Genre Filter --}}
                    <select id="filter-genre" class="text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                    
                    {{-- Condition Filter --}}
                    <select id="filter-condition" class="text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Conditions</option>
                        <option value="new">New</option>
                        <option value="preloved">Preloved</option>
                    </select>
                    
                    {{-- Stock Status Filter --}}
                    <select id="filter-stock" class="text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Stock</option>
                        <option value="in_stock">In Stock (>10)</option>
                        <option value="low_stock">Low Stock (1-10)</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                    
                    {{-- Sort --}}
                    <select id="filter-sort" class="text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="latest">Latest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="title_asc">Title A-Z</option>
                        <option value="title_desc">Title Z-A</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="stock_asc">Stock: Low to High</option>
                        <option value="stock_desc">Stock: High to Low</option>
                    </select>
                    
                    {{-- Per Page --}}
                    <select id="filter-perpage" class="text-sm border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-3 py-2.5 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                    
                    {{-- Clear Filters --}}
                    <button 
                        id="clear-filters-btn" 
                        class="hidden text-sm px-3 py-2.5 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Books Table Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden relative">
        {{-- Loading Overlay --}}
        <div id="loading-overlay" class="absolute inset-0 z-10 flex items-center justify-center hidden">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-8 w-8 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="mt-2 text-sm text-gray-500 dark:text-gray-400">Loading...</span>
            </div>
        </div>
        
        {{-- Table Container --}}
        <div id="books-container">
            @include('admin.books._table', ['books' => $books])
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="delete-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-900/75" id="modal-backdrop"></div>
            <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-2xl shadow-xl sm:my-8 sm:max-w-lg sm:w-full sm:p-6 sm:align-middle">
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Book</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Are you sure you want to delete "<span id="delete-book-title" class="font-medium text-gray-900 dark:text-white"></span>"? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-3">
                    <button type="button" id="confirm-delete-btn" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto">
                        Delete Book
                    </button>
                    <button type="button" id="cancel-delete-btn" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div id="toast" class="fixed bottom-4 right-4 z-50 hidden transform transition-all duration-300 translate-y-full opacity-0">
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border" id="toast-content">
            <div id="toast-icon"></div>
            <p id="toast-message" class="text-sm font-medium"></p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const searchInput = document.getElementById('search-input');
    const filterGenre = document.getElementById('filter-genre');
    const filterCondition = document.getElementById('filter-condition');
    const filterStock = document.getElementById('filter-stock');
    const filterSort = document.getElementById('filter-sort');
    const filterPerPage = document.getElementById('filter-perpage');
    const clearFiltersBtn = document.getElementById('clear-filters-btn');
    const booksContainer = document.getElementById('books-container');
    const loadingOverlay = document.getElementById('loading-overlay');
    
    // State
    let searchTimeout;
    let currentPage = 1;
    let deleteBookId = null;
    
    // Debounce search
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 1;
            fetchBooks();
        }, 300);
    });
    
    // Filter change handlers
    [filterGenre, filterCondition, filterStock, filterSort, filterPerPage].forEach(el => {
        el.addEventListener('change', function() {
            currentPage = 1;
            fetchBooks();
        });
    });
    
    // Clear filters
    clearFiltersBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterGenre.value = '';
        filterCondition.value = '';
        filterStock.value = '';
        filterSort.value = 'latest';
        filterPerPage.value = '10';
        currentPage = 1;
        fetchBooks();
    });
    
    // Fetch books via AJAX
    function fetchBooks() {
        loadingOverlay.classList.remove('hidden');
        updateClearFiltersVisibility();
        
        const params = new URLSearchParams({
            page: currentPage,
            search: searchInput.value,
            genre: filterGenre.value,
            condition: filterCondition.value,
            stock_status: filterStock.value,
            sort: filterSort.value,
            per_page: filterPerPage.value,
        });
        
        fetch(`{{ route('admin.books.index') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                booksContainer.innerHTML = data.html;
                bindTableEvents();
            }
        })
        .catch(error => {
            console.error('Error fetching books:', error);
            showToast('Failed to load books', 'error');
        })
        .finally(() => {
            loadingOverlay.classList.add('hidden');
        });
    }
    
    // Update clear filters button visibility
    function updateClearFiltersVisibility() {
        const hasFilters = searchInput.value || filterGenre.value || filterCondition.value || 
                          filterStock.value || filterSort.value !== 'latest' || filterPerPage.value !== '10';
        clearFiltersBtn.classList.toggle('hidden', !hasFilters);
    }
    
    // Bind events to dynamically loaded table elements
    function bindTableEvents() {
        // Pagination
        document.querySelectorAll('.pagination-btn:not([disabled])').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPage = parseInt(this.dataset.page);
                fetchBooks();
            });
        });
        
        // Stock input
        document.querySelectorAll('.stock-input').forEach(input => {
            input.addEventListener('change', function() {
                const bookId = this.dataset.bookId;
                const newStock = parseInt(this.value);
                const originalStock = parseInt(this.dataset.original);
                
                if (newStock !== originalStock && !isNaN(newStock) && newStock >= 0) {
                    quickUpdate(bookId, { stock: newStock }, this);
                }
            });
        });
        
        // Price input
        document.querySelectorAll('.price-input').forEach(input => {
            input.addEventListener('change', function() {
                const bookId = this.dataset.bookId;
                const newPrice = parseFloat(this.value);
                const originalPrice = parseFloat(this.dataset.original);
                
                if (newPrice !== originalPrice && !isNaN(newPrice) && newPrice >= 0) {
                    quickUpdate(bookId, { price: newPrice }, this);
                }
            });
        });
        
        // Condition select
        document.querySelectorAll('.condition-select').forEach(select => {
            select.addEventListener('change', function() {
                const bookId = this.dataset.bookId;
                quickUpdate(bookId, { condition: this.value }, this);
            });
        });
        
        // Delete buttons
        document.querySelectorAll('.delete-book-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteBookId = this.dataset.bookId;
                document.getElementById('delete-book-title').textContent = this.dataset.bookTitle;
                showModal('delete-modal');
            });
        });
    }
    
    // Quick update via AJAX
    function quickUpdate(bookId, data, element) {
        const row = element.closest('.book-row');
        row.classList.add('updating');
        
        fetch(`{{ url('admin/books') }}/${bookId}/quick-update`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Update original values
                if (data.stock !== undefined) {
                    element.dataset.original = data.stock;
                    updateStockInputStyle(element, data.stock);
                }
                if (data.price !== undefined) {
                    element.dataset.original = data.price;
                }
                if (data.condition !== undefined) {
                    updateConditionSelectStyle(element, data.condition);
                }
                
                row.classList.add('highlight');
                setTimeout(() => row.classList.remove('highlight'), 1000);
                showToast(result.message, 'success');
            } else {
                showToast(result.message || 'Update failed', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating book:', error);
            showToast('Failed to update book', 'error');
        })
        .finally(() => {
            row.classList.remove('updating');
        });
    }
    
    // Update stock input styling based on value
    function updateStockInputStyle(input, stock) {
        input.classList.remove('bg-green-50', 'border-green-200', 'text-green-700', 
                               'bg-amber-50', 'border-amber-200', 'text-amber-700',
                               'bg-red-50', 'border-red-200', 'text-red-700',
                               'dark:bg-green-900/30', 'dark:border-green-700', 'dark:text-green-300',
                               'dark:bg-amber-900/30', 'dark:border-amber-700', 'dark:text-amber-300',
                               'dark:bg-red-900/30', 'dark:border-red-700', 'dark:text-red-300');
        
        if (stock > 10) {
            input.classList.add('bg-green-50', 'border-green-200', 'text-green-700', 
                               'dark:bg-green-900/30', 'dark:border-green-700', 'dark:text-green-300');
        } else if (stock > 0) {
            input.classList.add('bg-amber-50', 'border-amber-200', 'text-amber-700',
                               'dark:bg-amber-900/30', 'dark:border-amber-700', 'dark:text-amber-300');
        } else {
            input.classList.add('bg-red-50', 'border-red-200', 'text-red-700',
                               'dark:bg-red-900/30', 'dark:border-red-700', 'dark:text-red-300');
        }
    }
    
    // Update condition select styling
    function updateConditionSelectStyle(select, condition) {
        select.classList.remove('bg-green-100', 'text-green-800', 'dark:bg-green-900/40', 'dark:text-green-300',
                               'bg-amber-100', 'text-amber-800', 'dark:bg-amber-900/40', 'dark:text-amber-300');
        
        if (condition === 'new') {
            select.classList.add('bg-green-100', 'text-green-800', 'dark:bg-green-900/40', 'dark:text-green-300');
        } else {
            select.classList.add('bg-amber-100', 'text-amber-800', 'dark:bg-amber-900/40', 'dark:text-amber-300');
        }
    }
    
    // Delete book
    document.getElementById('confirm-delete-btn').addEventListener('click', function() {
        if (!deleteBookId) return;
        
        this.disabled = true;
        this.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Deleting...';
        
        fetch(`{{ url('admin/books') }}/${deleteBookId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                hideModal('delete-modal');
                showToast(result.message, 'success');
                fetchBooks();
            } else {
                showToast(result.message || 'Failed to delete book', 'error');
            }
        })
        .catch(error => {
            console.error('Error deleting book:', error);
            showToast('Failed to delete book', 'error');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = 'Delete Book';
            deleteBookId = null;
        });
    });
    
    // Cancel delete
    document.getElementById('cancel-delete-btn').addEventListener('click', function() {
        hideModal('delete-modal');
        deleteBookId = null;
    });
    
    document.getElementById('modal-backdrop').addEventListener('click', function() {
        hideModal('delete-modal');
        deleteBookId = null;
    });
    
    // Modal functions
    function showModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function hideModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Toast notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastContent = document.getElementById('toast-content');
        const toastIcon = document.getElementById('toast-icon');
        const toastMessage = document.getElementById('toast-message');
        
        // Reset classes
        toastContent.className = 'flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border';
        
        if (type === 'success') {
            toastContent.classList.add('bg-green-50', 'dark:bg-green-900/50', 'border-green-200', 'dark:border-green-800');
            toastIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            toastMessage.className = 'text-sm font-medium text-green-800 dark:text-green-200';
        } else {
            toastContent.classList.add('bg-red-50', 'dark:bg-red-900/50', 'border-red-200', 'dark:border-red-800');
            toastIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            toastMessage.className = 'text-sm font-medium text-red-800 dark:text-red-200';
        }
        
        toastMessage.textContent = message;
        toast.classList.remove('hidden', 'translate-y-full', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        
        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-full', 'opacity-0');
            setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3000);
    }
    
    // Initial binding
    bindTableEvents();
    updateClearFiltersVisibility();
});
</script>
@endpush
