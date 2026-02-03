@extends('layouts.admin')

@section('header', 'Customers')

@section('content')
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">All Customers</h2>
            
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                <form id="customers-filter-form" action="{{ route('admin.customers.index') }}" method="GET" class="flex flex-wrap gap-2">
                    <!-- Search -->
                    <div class="flex">
                        <input type="text" name="search" id="search-input" value="{{ request('search') }}" placeholder="Search customers..." 
                            class="rounded-l-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Has Orders Filter -->
                    <select name="has_orders" id="has-orders-filter" class="filter-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 transition-colors">
                        <option value="">All Customers</option>
                        <option value="yes" {{ request('has_orders') === 'yes' ? 'selected' : '' }}>With Orders</option>
                        <option value="no" {{ request('has_orders') === 'no' ? 'selected' : '' }}>Without Orders</option>
                    </select>

                    <!-- Sort Options -->
                    <select name="sort" id="sort-filter" class="filter-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 transition-colors">
                        <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                    </select>

                    <!-- Date From -->
                    <input type="date" name="date_from" id="date-from-filter" value="{{ request('date_from') }}" 
                        placeholder="From Date" class="filter-date rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 transition-colors">

                    <!-- Date To -->
                    <input type="date" name="date_to" id="date-to-filter" value="{{ request('date_to') }}" 
                        placeholder="To Date" class="filter-date rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 transition-colors">

                    @if(request('search') || request('has_orders') || request('sort') || request('date_from') || request('date_to'))
                        <button type="button" id="clear-filters-btn" class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-100 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Clear Filters
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>


    <!-- Customers Table Container -->
    <div id="customers-table-container" class="transition-opacity duration-300">
        @include('admin.customers.partials.table')
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center space-x-3">
                <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 dark:text-gray-300">Loading customers...</span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('customers-table-container');
            const loadingOverlay = document.getElementById('loading-overlay');
            const filterForm = document.getElementById('customers-filter-form');
            let searchTimeout;
            
            // Function to load customers via AJAX
            function loadCustomers(url) {
                // Show loading
                loadingOverlay.classList.remove('hidden');
                container.style.opacity = '0.5';
                
                // Fetch new page
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Update container with fade transition
                    container.style.opacity = '0';
                    setTimeout(() => {
                        container.innerHTML = html;
                        container.style.opacity = '1';
                        loadingOverlay.classList.add('hidden');
                        
                        // Update URL without reload
                        window.history.pushState({}, '', url);
                        
                        // Scroll to top of table
                        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 150);
                })
                .catch(error => {
                    console.error('Error loading customers:', error);
                    loadingOverlay.classList.add('hidden');
                    container.style.opacity = '1';
                    alert('Error loading customers. Please try again.');
                });
            }
            
            // Handle filter form submission
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);
                const url = filterForm.action + '?' + params.toString();
                loadCustomers(url);
            });
            
            // Handle filter select changes (auto-submit)
            document.querySelectorAll('.filter-select').forEach(select => {
                select.addEventListener('change', function() {
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData);
                    const url = filterForm.action + '?' + params.toString();
                    loadCustomers(url);
                });
            });
            
            // Handle date filter changes (auto-submit)
            document.querySelectorAll('.filter-date').forEach(input => {
                input.addEventListener('change', function() {
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData);
                    const url = filterForm.action + '?' + params.toString();
                    loadCustomers(url);
                });
            });
            
            // Handle search input with debounce (wait 500ms after user stops typing)
            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        const formData = new FormData(filterForm);
                        const params = new URLSearchParams(formData);
                        const url = filterForm.action + '?' + params.toString();
                        loadCustomers(url);
                    }, 500);
                });
            }
            
            // Handle clear filters button
            const clearFiltersBtn = document.getElementById('clear-filters-btn');
            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener('click', function() {
                    // Reset form
                    filterForm.reset();
                    // Load without filters
                    const url = filterForm.action;
                    loadCustomers(url);
                });
            }
            
            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                const link = e.target.closest('.pagination-link');
                if (!link) return;
                
                e.preventDefault();
                const url = link.getAttribute('href');
                if (!url) return;
                
                loadCustomers(url);
            });
            
            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                location.reload();
            });
        });
    </script>

    <style>
        /* Fixed header styles */
        #customers-table-container table thead {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f9fafb; /* gray-50 */
        }
        
        .dark #customers-table-container table thead {
            background-color: #374151; /* gray-700 */
        }
        
        /* Smooth transitions */
        #customers-table-container {
            transition: opacity 0.3s ease-in-out;
        }
        
        #customers-table-container table tbody tr {
            transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
        }
        
        #customers-table-container table tbody tr:hover {
            transform: translateX(2px);
        }
        
        /* Scrollbar styling */
        #customers-table-container .overflow-x-auto::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        #customers-table-container .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        #customers-table-container .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        #customers-table-container .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        .dark #customers-table-container .overflow-x-auto::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark #customers-table-container .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        .dark #customers-table-container .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
@endsection
