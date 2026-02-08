{{-- Orders Table Partial for AJAX --}}
<div class="overflow-x-auto">
    <table class="w-full" id="orders-table">
        <thead>
            <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                        Order
                    </div>
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Date</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Total</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Payment</th>
                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50" id="orders-tbody">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors duration-150 order-row" data-order-id="{{ $order->id }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <span class="text-white text-xs font-bold">{{ substr($order->public_id ?? $order->id, 0, 2) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    #{{ $order->public_id ?? $order->id }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $order->items->count() }} item{{ $order->items->count() > 1 ? 's' : '' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                <span class="text-gray-600 dark:text-gray-300 text-xs font-medium">{{ strtoupper(substr($order->user->name, 0, 1)) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('h:i A') }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">RM {{ number_format($order->total_amount, 2) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <select 
                            class="status-select text-xs font-medium rounded-full px-3 py-1.5 border-0 cursor-pointer focus:ring-2 focus:ring-purple-500 focus:ring-offset-1 transition-all {{ $order->getStatusBadgeClass() }}"
                            data-order-id="{{ $order->id }}"
                            data-field="status"
                        >
                            @foreach(['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-6 py-4">
                        <select 
                            class="payment-select text-xs font-medium rounded-full px-3 py-1.5 border-0 cursor-pointer focus:ring-2 focus:ring-purple-500 focus:ring-offset-1 transition-all {{ $order->getPaymentStatusBadgeClass() }}"
                            data-order-id="{{ $order->id }}"
                            data-field="payment_status"
                        >
                            @foreach(['pending', 'paid', 'failed', 'refunded'] as $status)
                                <option value="{{ $status }}" {{ $order->payment_status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="p-2 text-gray-500 hover:text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition-colors"
                               title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.orders.edit', $order) }}" 
                               class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                               title="Edit Order">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.orders.invoice', $order) }}" 
                               class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors"
                               title="View Invoice">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </a>
                            @if($order->status === 'cancelled')
                                <button 
                                    type="button"
                                    class="delete-order-btn p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                    data-order-id="{{ $order->id }}"
                                    data-order-public-id="{{ $order->public_id ?? $order->id }}"
                                    title="Delete Order">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No orders found</p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Try adjusting your search or filters</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($orders->hasPages())
<div class="bg-white dark:bg-gray-800 px-6 py-4 border-t border-gray-100 dark:border-gray-700">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-600 dark:text-gray-400">
            Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $orders->firstItem() ?? 0 }}</span>
            to <span class="font-semibold text-gray-900 dark:text-white">{{ $orders->lastItem() ?? 0 }}</span>
            of <span class="font-semibold text-gray-900 dark:text-white">{{ $orders->total() }}</span> orders
        </div>
        <div class="flex items-center gap-2">
            {{-- Previous --}}
            <button 
                type="button"
                class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors {{ $orders->onFirstPage() ? 'text-gray-400 dark:text-gray-500 border-gray-200 dark:border-gray-700 cursor-not-allowed' : 'text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' }}"
                data-page="{{ $orders->currentPage() - 1 }}"
                {{ $orders->onFirstPage() ? 'disabled' : '' }}
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            {{-- Page Numbers --}}
            @php
                $currentPage = $orders->currentPage();
                $lastPage = $orders->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp
            
            @if($start > 1)
                <button type="button" class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" data-page="1">1</button>
                @if($start > 2)
                    <span class="px-2 text-gray-400">...</span>
                @endif
            @endif
            
            @for($i = $start; $i <= $end; $i++)
                <button 
                    type="button"
                    class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors {{ $i === $currentPage ? 'bg-purple-600 text-white border-purple-600' : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}"
                    data-page="{{ $i }}"
                >{{ $i }}</button>
            @endfor
            
            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span class="px-2 text-gray-400">...</span>
                @endif
                <button type="button" class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" data-page="{{ $lastPage }}">{{ $lastPage }}</button>
            @endif
            
            {{-- Next --}}
            <button 
                type="button"
                class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors {{ $orders->hasMorePages() ? 'text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' : 'text-gray-400 dark:text-gray-500 border-gray-200 dark:border-gray-700 cursor-not-allowed' }}"
                data-page="{{ $orders->currentPage() + 1 }}"
                {{ !$orders->hasMorePages() ? 'disabled' : '' }}
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif
