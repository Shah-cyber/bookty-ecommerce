@extends('layouts.admin')

@section('header', 'Manage Orders')

@section('content')
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <h2 class="text-2xl  font-medium-semibold text-bookty-black dark:text-white">Orders</h2>
            
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                <form id="orders-filter-form" action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-2">
                    <!-- Search -->
                    <div class="flex">
                        <input type="text" name="search" id="search-input" value="{{ request('search') }}" placeholder="Search orders..." 
                            class="rounded-l-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-bookty-purple-300 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50">
                        <button type="submit" class="px-4 py-2 bg-bookty-purple-600 text-white rounded-r-md hover:bg-bookty-purple-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Status Filter -->
                    <select name="status" id="status-filter" class="filter-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-bookty-purple-300 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50 transition-colors">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Payment Status Filter -->
                    <select name="payment_status" id="payment-status-filter" class="filter-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-bookty-purple-300 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50 transition-colors">
                        <option value="">All Payment Statuses</option>
                        @foreach($paymentStatuses as $status)
                            <option value="{{ $status }}" {{ request('payment_status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Sort Options -->
                    <select name="sort" id="sort-filter" class="filter-select rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-bookty-purple-300 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50 transition-colors">
                        <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="total_desc" {{ request('sort') == 'total_desc' ? 'selected' : '' }}>Highest Amount</option>
                        <option value="total_asc" {{ request('sort') == 'total_asc' ? 'selected' : '' }}>Lowest Amount</option>
                    </select>

                    @if(request('search') || request('status') || request('payment_status') || request('sort'))
                        <button type="button" id="clear-filters-btn" class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-100 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Clear Filters
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>


    <!-- Orders Table Container -->
    <div id="orders-table-container" class="transition-opacity duration-300">
        @include('admin.orders.partials.table')
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center h-full">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-bookty-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700 dark:text-gray-300">Loading orders...</span>
        </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('orders-table-container');
            const loadingOverlay = document.getElementById('loading-overlay');
            const filterForm = document.getElementById('orders-filter-form');
            let searchTimeout;
            
            // Function to load orders via AJAX
            function loadOrders(url) {
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
                    console.error('Error loading orders:', error);
                    loadingOverlay.classList.add('hidden');
                    container.style.opacity = '1';
                    alert('Error loading orders. Please try again.');
                });
            }
            
            // Handle filter form submission
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);
                const url = filterForm.action + '?' + params.toString();
                loadOrders(url);
            });
            
            // Handle filter select changes (auto-submit)
            document.querySelectorAll('.filter-select').forEach(select => {
                select.addEventListener('change', function() {
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData);
                    const url = filterForm.action + '?' + params.toString();
                    loadOrders(url);
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
                        loadOrders(url);
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
                    loadOrders(url);
                });
            }
            
            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                const link = e.target.closest('.pagination-link');
                if (!link) return;
                
                e.preventDefault();
                const url = link.getAttribute('href');
                if (!url) return;
                
                loadOrders(url);
            });
            
            // Handle browser back/forward buttons
            window.addEventListener('popstate', function() {
                location.reload();
            });
        });
    </script>

    <style>
        /* Fixed header styles */
        #orders-table-container table thead {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #F5F5DC; /* bookty-cream */
        }
        
        .dark #orders-table-container table thead {
            background-color: #374151; /* gray-700 */
        }
        
        /* Smooth transitions */
        #orders-table-container {
            transition: opacity 0.3s ease-in-out;
        }
        
        #orders-table-container table tbody tr {
            transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
        }
        
        #orders-table-container table tbody tr:hover {
            transform: translateX(2px);
        }
        
        /* Scrollbar styling */
        #orders-table-container .overflow-x-auto::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        #orders-table-container .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        #orders-table-container .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        #orders-table-container .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        .dark #orders-table-container .overflow-x-auto::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark #orders-table-container .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        .dark #orders-table-container .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
@endsection
