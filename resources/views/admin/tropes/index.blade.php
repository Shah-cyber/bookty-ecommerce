@extends('layouts.admin')

@section('header', 'Tropes')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Tropes</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage book tropes and story themes</p>
        </div>
        <a href="{{ route('admin.tropes.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Trope
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100" id="stat-total">{{ $tropes->total() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Tropes</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $tropes->sum('books_count') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Books Tagged</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $tropes->where('books_count', '>', 0)->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Active Tropes</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $tropes->where('books_count', 0)->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Unused Tropes</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex flex-col lg:flex-row gap-4">
            {{-- Search --}}
            <div class="flex-1">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           id="search-input"
                           placeholder="Search tropes..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
            
            {{-- Sort --}}
            <div class="w-full lg:w-48">
                <select id="sort-select" 
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="latest">Latest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="name_asc">Name A-Z</option>
                    <option value="name_desc">Name Z-A</option>
                    <option value="books_desc">Most Books</option>
                    <option value="books_asc">Least Books</option>
                </select>
            </div>
            
            {{-- Per Page --}}
            <div class="w-full lg:w-32">
                <select id="per-page-select" 
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            
            {{-- Clear Filters --}}
            <button type="button" 
                    id="clear-filters-btn"
                    class="hidden px-4 py-2.5 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden relative">
        {{-- Loading Overlay --}}
        <div id="loading-overlay" class="hidden absolute inset-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm z-10 flex items-center justify-center">
            <div class="flex items-center gap-3 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                <svg class="animate-spin w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-600 dark:text-gray-400 font-medium">Loading...</span>
            </div>
        </div>
        
        {{-- Table Container --}}
        <div id="tropes-container">
            @include('admin.tropes._table', ['tropes' => $tropes])
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-900/75 transition-opacity" id="modal-backdrop"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full mx-auto shadow-xl transform transition-all">
            <div class="p-6">
                <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Delete Trope</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-1">Are you sure you want to delete <span id="delete-trope-name" class="font-semibold text-gray-900 dark:text-gray-100"></span>?</p>
                <p id="delete-warning" class="text-amber-500 dark:text-amber-400 text-sm mb-6"></p>
                
                <div class="flex gap-3">
                    <button type="button" 
                            id="cancel-delete-btn"
                            class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <button type="button" 
                            id="confirm-delete-btn"
                            class="flex-1 px-4 py-2.5 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const searchInput = document.getElementById('search-input');
    const sortSelect = document.getElementById('sort-select');
    const perPageSelect = document.getElementById('per-page-select');
    const clearFiltersBtn = document.getElementById('clear-filters-btn');
    const tropesContainer = document.getElementById('tropes-container');
    const loadingOverlay = document.getElementById('loading-overlay');
    const deleteModal = document.getElementById('delete-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const deleteTropeName = document.getElementById('delete-trope-name');
    const deleteWarning = document.getElementById('delete-warning');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    
    let currentPage = 1;
    let searchTimeout = null;
    let tropeToDelete = null;
    
    // Fetch tropes
    function fetchTropes() {
        showLoading();
        
        const params = new URLSearchParams({
            page: currentPage,
            search: searchInput.value,
            sort: sortSelect.value,
            per_page: perPageSelect.value
        });
        
        fetch(`{{ route('admin.tropes.index') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                tropesContainer.innerHTML = data.html;
                bindTableEvents();
                updateClearFiltersVisibility();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to fetch tropes', 'error');
        })
        .finally(() => {
            hideLoading();
        });
    }
    
    // Bind table events
    function bindTableEvents() {
        // Delete buttons
        document.querySelectorAll('.delete-trope-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const tropeId = this.dataset.tropeId;
                const tropeName = this.dataset.tropeName;
                const booksCount = parseInt(this.dataset.booksCount);
                
                tropeToDelete = tropeId;
                deleteTropeName.textContent = tropeName;
                
                if (booksCount > 0) {
                    deleteWarning.textContent = `This trope is used by ${booksCount} book(s). It will be removed from all associated books.`;
                } else {
                    deleteWarning.textContent = 'This action cannot be undone.';
                }
                
                showModal();
            });
        });
        
        // Pagination buttons
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.disabled) {
                    currentPage = parseInt(this.dataset.page);
                    fetchTropes();
                }
            });
        });
    }
    
    // Show/hide loading
    function showLoading() {
        loadingOverlay.classList.remove('hidden');
    }
    
    function hideLoading() {
        loadingOverlay.classList.add('hidden');
    }
    
    // Show/hide modal
    function showModal() {
        deleteModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function hideModal() {
        deleteModal.classList.add('hidden');
        document.body.style.overflow = '';
        tropeToDelete = null;
    }
    
    // Update clear filters button visibility
    function updateClearFiltersVisibility() {
        const hasFilters = searchInput.value || sortSelect.value !== 'latest' || perPageSelect.value !== '10';
        clearFiltersBtn.classList.toggle('hidden', !hasFilters);
    }
    
    // Delete trope
    function deleteTrope() {
        if (!tropeToDelete) return;
        
        hideModal();
        showLoading();
        
        fetch(`{{ url('admin/tropes') }}/${tropeToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                fetchTropes();
            } else {
                showToast(data.message || 'Failed to delete trope', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to delete trope', 'error');
        })
        .finally(() => {
            hideLoading();
        });
    }
    
    // Toast notification
    function showToast(message, type = 'success') {
        if (typeof window.showToast === 'function') {
            window.showToast(message, type);
        }
    }
    
    // Event listeners
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 1;
            fetchTropes();
        }, 300);
    });
    
    sortSelect.addEventListener('change', function() {
        currentPage = 1;
        fetchTropes();
    });
    
    perPageSelect.addEventListener('change', function() {
        currentPage = 1;
        fetchTropes();
    });
    
    clearFiltersBtn.addEventListener('click', function() {
        searchInput.value = '';
        sortSelect.value = 'latest';
        perPageSelect.value = '10';
        currentPage = 1;
        fetchTropes();
    });
    
    cancelDeleteBtn.addEventListener('click', hideModal);
    modalBackdrop.addEventListener('click', hideModal);
    confirmDeleteBtn.addEventListener('click', deleteTrope);
    
    // Initial bind
    bindTableEvents();
});
</script>
@endpush

@push('styles')
<style>
    #tropes-container tr {
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush
