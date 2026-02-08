@extends('layouts.admin')

@section('header', 'Manage Orders')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                Orders Management
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage and track all customer orders</p>
        </div>
        
        {{-- Quick Stats --}}
        <div class="flex flex-wrap gap-3">
            <div class="bg-white dark:bg-gray-800 rounded-xl px-4 py-3 border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white" id="pending-count">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl px-4 py-3 border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Processing</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white" id="processing-count">{{ \App\Models\Order::where('status', 'processing')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl px-4 py-3 border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Shipped</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white" id="shipped-count">{{ \App\Models\Order::where('status', 'shipped')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
        <div class="flex flex-col lg:flex-row lg:items-center gap-4">
            {{-- Search --}}
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    id="search-input"
                    value="{{ request('search') }}" 
                    placeholder="Search by order ID, customer name or email..." 
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-0 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:bg-white dark:focus:bg-gray-700 transition-all"
                >
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap items-center gap-3">
                {{-- Status Filter --}}
                <select id="status-filter" class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-0 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all cursor-pointer">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                {{-- Payment Status Filter --}}
                <select id="payment-filter" class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-0 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all cursor-pointer">
                    <option value="">All Payments</option>
                    @foreach($paymentStatuses as $status)
                        <option value="{{ $status }}" {{ request('payment_status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                {{-- Sort --}}
                <select id="sort-filter" class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-0 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all cursor-pointer">
                    <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="total_desc" {{ request('sort') == 'total_desc' ? 'selected' : '' }}>Highest Amount</option>
                    <option value="total_asc" {{ request('sort') == 'total_asc' ? 'selected' : '' }}>Lowest Amount</option>
                </select>

                {{-- Per Page --}}
                <select id="per-page-filter" class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-0 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 transition-all cursor-pointer">
                    <option value="10" {{ (request('per_page') ?? 10) == 10 ? 'selected' : '' }}>10 per page</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                </select>

                {{-- Clear Filters --}}
                <button 
                    type="button" 
                    id="clear-filters-btn"
                    class="px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors hidden"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Orders Table Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        {{-- Loading Overlay --}}
        <div id="loading-overlay" class="hidden absolute inset-0 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm z-10 flex items-center justify-center">
            <div class="flex flex-col items-center gap-3">
                <svg class="animate-spin w-8 h-8 text-purple-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm text-gray-500 dark:text-gray-400">Loading orders...</span>
            </div>
        </div>

        {{-- Table Container --}}
        <div id="orders-container" class="relative">
            @include('admin.orders._table')
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" id="delete-modal-backdrop"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full p-6 relative">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Order</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">This action cannot be undone</p>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Are you sure you want to delete order <span id="delete-order-id" class="font-semibold text-gray-900 dark:text-white">#</span>? All order items will be permanently removed.
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" id="cancel-delete-btn" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Cancel
                </button>
                <button type="button" id="confirm-delete-btn" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4 hidden animate-spin" id="delete-spinner" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Delete Order
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Toast Notification --}}
<div id="toast" class="fixed bottom-4 right-4 z-50 transform translate-y-full opacity-0 transition-all duration-300">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-4 flex items-center gap-3 max-w-sm">
        <div id="toast-icon" class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"></div>
        <p id="toast-message" class="text-sm text-gray-900 dark:text-white font-medium"></p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ordersContainer = document.getElementById('orders-container');
    const loadingOverlay = document.getElementById('loading-overlay');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const paymentFilter = document.getElementById('payment-filter');
    const sortFilter = document.getElementById('sort-filter');
    const perPageFilter = document.getElementById('per-page-filter');
    const clearFiltersBtn = document.getElementById('clear-filters-btn');
    
    let searchTimeout;
    let currentPage = 1;

    // Show/hide clear filters button
    function updateClearButton() {
        const hasFilters = searchInput.value || statusFilter.value || paymentFilter.value || sortFilter.value !== 'latest';
        clearFiltersBtn.classList.toggle('hidden', !hasFilters);
    }

    // Fetch orders via AJAX
    async function fetchOrders(page = 1) {
        loadingOverlay.classList.remove('hidden');
        
        const params = new URLSearchParams({
            page: page,
            search: searchInput.value,
            status: statusFilter.value,
            payment_status: paymentFilter.value,
            sort: sortFilter.value,
            per_page: perPageFilter.value
        });

        try {
            const response = await fetch(`{{ route('admin.orders.index') }}?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                ordersContainer.innerHTML = data.html;
                currentPage = data.pagination.current_page;
                attachEventListeners();
                updateClearButton();
                
                // Update URL without reload
                const url = new URL(window.location);
                url.searchParams.set('page', page);
                if (searchInput.value) url.searchParams.set('search', searchInput.value);
                else url.searchParams.delete('search');
                if (statusFilter.value) url.searchParams.set('status', statusFilter.value);
                else url.searchParams.delete('status');
                if (paymentFilter.value) url.searchParams.set('payment_status', paymentFilter.value);
                else url.searchParams.delete('payment_status');
                if (sortFilter.value !== 'latest') url.searchParams.set('sort', sortFilter.value);
                else url.searchParams.delete('sort');
                window.history.pushState({}, '', url);
            }
        } catch (error) {
            console.error('Error fetching orders:', error);
            showToast('Failed to load orders', 'error');
        } finally {
            loadingOverlay.classList.add('hidden');
        }
    }

    // Quick update order status
    async function quickUpdate(orderId, field, value) {
        try {
            const response = await fetch(`/admin/orders/${orderId}/quick-update`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ [field]: value })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showToast(`Order #${data.order.public_id || data.order.id} updated successfully`, 'success');
                
                // Update the select styling
                const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
                if (row) {
                    const select = row.querySelector(`select[data-field="${field}"]`);
                    if (select) {
                        // Remove all status classes and add new one
                        select.className = select.className.replace(/bg-\w+-\d+|text-\w+-\d+/g, '');
                        select.classList.add(...data.order[field === 'status' ? 'status_badge' : 'payment_badge'].split(' '));
                    }
                }
                
                // Update quick stats
                updateQuickStats();
            } else {
                showToast(data.message || 'Failed to update order', 'error');
            }
        } catch (error) {
            console.error('Error updating order:', error);
            showToast('Failed to update order', 'error');
        }
    }

    // Delete order
    async function deleteOrder(orderId) {
        const deleteSpinner = document.getElementById('delete-spinner');
        const confirmBtn = document.getElementById('confirm-delete-btn');
        
        deleteSpinner.classList.remove('hidden');
        confirmBtn.disabled = true;
        
        try {
            const response = await fetch(`/admin/orders/${orderId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                showToast(data.message, 'success');
                closeDeleteModal();
                
                // Remove row with animation
                const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
                if (row) {
                    row.style.transition = 'all 0.3s ease-out';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        row.remove();
                        // If no more rows, refresh to show empty state
                        if (!document.querySelector('#orders-tbody tr')) {
                            fetchOrders(currentPage);
                        }
                    }, 300);
                }
                
                updateQuickStats();
            } else {
                showToast(data.message || 'Failed to delete order', 'error');
            }
        } catch (error) {
            console.error('Error deleting order:', error);
            showToast('Failed to delete order', 'error');
        } finally {
            deleteSpinner.classList.add('hidden');
            confirmBtn.disabled = false;
        }
    }

    // Update quick stats
    async function updateQuickStats() {
        try {
            const response = await fetch('{{ route("admin.orders.index") }}?stats_only=1', {
                headers: { 'Accept': 'application/json' }
            });
            // Stats are updated on page reload for now
        } catch (error) {
            console.error('Error updating stats:', error);
        }
    }

    // Show toast notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastIcon = document.getElementById('toast-icon');
        const toastMessage = document.getElementById('toast-message');
        
        toastMessage.textContent = message;
        
        if (type === 'success') {
            toastIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
            toastIcon.className = 'flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center bg-green-100 dark:bg-green-900/30';
        } else {
            toastIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
            toastIcon.className = 'flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center bg-red-100 dark:bg-red-900/30';
        }
        
        toast.classList.remove('translate-y-full', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        
        setTimeout(() => {
            toast.classList.add('translate-y-full', 'opacity-0');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }

    // Delete modal functions
    let orderToDelete = null;
    
    function openDeleteModal(orderId, publicId) {
        orderToDelete = orderId;
        document.getElementById('delete-order-id').textContent = '#' + publicId;
        document.getElementById('delete-modal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        orderToDelete = null;
    }

    // Attach event listeners to dynamic elements
    function attachEventListeners() {
        // Status selects
        document.querySelectorAll('.status-select, .payment-select').forEach(select => {
            select.addEventListener('change', function() {
                const orderId = this.dataset.orderId;
                const field = this.dataset.field;
                const value = this.value;
                quickUpdate(orderId, field, value);
            });
        });
        
        // Delete buttons
        document.querySelectorAll('.delete-order-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const orderId = this.dataset.orderId;
                const publicId = this.dataset.orderPublicId;
                openDeleteModal(orderId, publicId);
            });
        });
        
        // Pagination buttons
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.disabled) {
                    fetchOrders(this.dataset.page);
                }
            });
        });
    }

    // Search with debounce
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetchOrders(1);
        }, 500);
    });

    // Filter changes
    statusFilter.addEventListener('change', () => fetchOrders(1));
    paymentFilter.addEventListener('change', () => fetchOrders(1));
    sortFilter.addEventListener('change', () => fetchOrders(1));
    perPageFilter.addEventListener('change', () => fetchOrders(1));

    // Clear filters
    clearFiltersBtn.addEventListener('click', function() {
        searchInput.value = '';
        statusFilter.value = '';
        paymentFilter.value = '';
        sortFilter.value = 'latest';
        perPageFilter.value = '10';
        fetchOrders(1);
    });

    // Delete modal events
    document.getElementById('delete-modal-backdrop').addEventListener('click', closeDeleteModal);
    document.getElementById('cancel-delete-btn').addEventListener('click', closeDeleteModal);
    document.getElementById('confirm-delete-btn').addEventListener('click', () => {
        if (orderToDelete) {
            deleteOrder(orderToDelete);
        }
    });

    // Initial setup
    attachEventListeners();
    updateClearButton();
});
</script>
@endpush

@push('styles')
<style>
    /* Status badge colors for selects */
    .status-select option,
    .payment-select option {
        background: white;
        color: #374151;
    }
    
    .dark .status-select option,
    .dark .payment-select option {
        background: #1f2937;
        color: #e5e7eb;
    }
    
    /* Smooth row transitions */
    .order-row {
        transition: all 0.2s ease;
    }
    
    /* Loading overlay positioning */
    #orders-container {
        position: relative;
        min-height: 200px;
    }
    
    #loading-overlay {
        position: absolute;
        inset: 0;
        z-index: 10;
    }
</style>
@endpush
