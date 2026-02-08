@extends('layouts.admin')

@section('header', 'Customers')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Customers</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Manage and view all registered customers</p>
        </div>
        
        {{-- Stats Summary --}}
        <div class="flex items-center gap-4">
            <div class="bg-purple-50 dark:bg-purple-900/20 px-4 py-2 rounded-lg">
                <p class="text-xs text-purple-600 dark:text-purple-400">Total Customers</p>
                <p class="text-lg font-bold text-purple-700 dark:text-purple-300">{{ $customers->total() }}</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
            {{-- Search --}}
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Search</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, phone..." class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                </div>
            </div>

            {{-- Has Orders Filter --}}
            <div class="w-full lg:w-40">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Orders</label>
                <select name="has_orders" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    <option value="">All</option>
                    <option value="yes" {{ request('has_orders') === 'yes' ? 'selected' : '' }}>With Orders</option>
                    <option value="no" {{ request('has_orders') === 'no' ? 'selected' : '' }}>No Orders</option>
                </select>
            </div>

            {{-- Sort --}}
            <div class="w-full lg:w-40">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Sort By</label>
                <select name="sort" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                </select>
            </div>

            {{-- Date Range --}}
            <div class="w-full lg:w-auto">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
            </div>

            <div class="w-full lg:w-auto">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
            </div>

            {{-- Actions --}}
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-medium rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                    Filter
                </button>
                @if(request('search') || request('has_orders') || request('sort') || request('date_from') || request('date_to'))
                    <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Customers Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Orders</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Registered</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white text-sm font-semibold">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $customer->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">ID: #{{ $customer->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900 dark:text-white">{{ $customer->email }}</p>
                                @if($customer->phone_number)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->phone_number }}</p>
                                @else
                                    <p class="text-xs text-gray-400 dark:text-gray-500 italic">No phone</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($customer->city && $customer->state)
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $customer->city }}, {{ $customer->state }}</p>
                                    @if($customer->country)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->country }}</p>
                                    @endif
                                @else
                                    <p class="text-sm text-gray-400 dark:text-gray-500 italic">No address</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($customer->orders_count > 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        {{ $customer->orders_count }} {{ Str::plural('order', $customer->orders_count) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                        No orders
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900 dark:text-white">{{ $customer->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end">
                                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/30 rounded-lg transition-colors">
                                        View Details
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400 mb-1">No customers found</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500">Try adjusting your search or filter criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($customers->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Showing <span class="font-medium">{{ $customers->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $customers->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $customers->total() }}</span> customers
                    </p>
                    <div>
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
