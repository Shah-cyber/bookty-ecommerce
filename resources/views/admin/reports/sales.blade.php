@extends('layouts.admin')

@section('header', 'Sales Reports')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Sales Reports</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Revenue trends, bestsellers, and sales analytics</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Reports
        </a>
    </div>

    {{-- Summary Cards --}}
    @php
        $totalRevenue = ($revenueData ?? collect())->sum('revenue') ?? 0;
        $totalOrders = ($revenueData ?? collect())->sum('orders_count') ?? 0;
        $avgOrderValue = $totalOrders > 0 ? ($totalRevenue / $totalOrders) : 0;
        $topGenre = ($salesByGenre ?? collect())->first();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-900/30 px-2 py-0.5 rounded-full">Revenue</span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">RM {{ number_format($totalRevenue, 2) }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ $totalOrders }} orders this period</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 px-2 py-0.5 rounded-full">Orders</span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Orders</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalOrders) }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Completed transactions</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">AOV</span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Avg Order Value</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">RM {{ number_format($avgOrderValue, 2) }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Per transaction average</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-pink-600 dark:text-pink-400 bg-pink-100 dark:bg-pink-900/30 px-2 py-0.5 rounded-full">Top</span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Best Genre</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white mt-1 truncate" title="{{ $topGenre->name ?? 'N/A' }}">{{ $topGenre->name ?? 'N/A' }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">RM {{ number_format($topGenre->total_revenue ?? 0, 2) }} revenue</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">Period</label>
                <select name="period" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                    <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">Start Date</label>
                <input type="date" name="start_date" value="{{ is_string($startDate) ? substr($startDate, 0, 10) : ($startDate ? $startDate->format('Y-m-d') : '') }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">End Date</label>
                <input type="date" name="end_date" value="{{ is_string($endDate) ? substr($endDate, 0, 10) : ($endDate ? $endDate->format('Y-m-d') : '') }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gray-900 dark:bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-gray-800 dark:hover:bg-blue-700 transition-colors font-medium">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    {{-- Revenue Chart --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Revenue Over Time</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Track sales performance trends</p>
                </div>
            </div>
            <a href="{{ route('admin.reports.export.sales', ['type' => 'bestsellers', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </a>
        </div>
        <div class="p-5">
            <div id="revenue-line-chart" class="w-full" style="height: 400px;"></div>
        </div>
    </div>

    {{-- Bestsellers Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Bestsellers by Revenue --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Top Revenue</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Highest earning books</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-12">Rank</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Book</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($bestsellersByRevenue ?? [] as $index => $book)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold {{ $index < 3 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if($book->cover_image)
                                            <img class="h-9 w-7 object-cover rounded shadow-sm" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                        @else
                                            <div class="h-9 w-7 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]" title="{{ $book->title }}">{{ $book->title }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $book->author }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right">
                                    <span class="text-sm font-bold text-green-600 dark:text-green-400">RM {{ number_format($book->total_revenue, 2) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bestsellers by Units --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Top Units Sold</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Most popular by quantity</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-12">Rank</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Book</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Units</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($bestsellersByUnits ?? [] as $index => $book)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold {{ $index < 3 ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if($book->cover_image)
                                            <img class="h-9 w-7 object-cover rounded shadow-sm" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                        @else
                                            <div class="h-9 w-7 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-[150px]" title="{{ $book->title }}">{{ $book->title }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $book->author }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $book->total_units }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">units</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Sales by Genre --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Sales by Genre</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Revenue distribution across categories</p>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 relative">
                    <div id="genre-sales-pie-chart" class="w-full" style="height: 300px;"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Total</p>
                        @php $totalGenreRevenue = ($salesByGenre ?? collect())->sum('total_revenue'); @endphp
                        <p class="text-xl font-bold text-gray-900 dark:text-white">RM {{ number_format($totalGenreRevenue, 0) }}</p>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-4">Genre Breakdown</h4>
                    <div class="space-y-3 max-h-[280px] overflow-y-auto pr-2">
                        @forelse($salesByGenre ?? [] as $index => $genre)
                            @php
                                $total = ($salesByGenre ?? collect())->sum('total_revenue');
                                $percentage = $total > 0 ? ($genre->total_revenue / $total * 100) : 0;
                                $colors = ['#ec4899', '#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1', '#14b8a6'];
                                $color = $colors[$index % count($colors)];
                            @endphp
                            <div class="group">
                                <div class="flex items-center justify-between mb-1.5">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $color }}"></span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $genre->name }}</span>
                                        <span class="text-xs text-gray-400">({{ $genre->books_count ?? 0 }} books)</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">RM {{ number_format($genre->total_revenue, 2) }}</span>
                                        <span class="text-xs text-gray-500 ml-1">{{ number_format($percentage, 1) }}%</span>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-1.5 rounded-full transition-all" style="width: {{ $percentage }}%; background-color: {{ $color }}"></div>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <p class="text-sm">No genre data available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    var revCategories = @json(($revenueData ?? collect())->pluck('period'));
    var revSeries = @json(($revenueData ?? collect())->pluck('revenue'));
    var revOrders = @json(($revenueData ?? collect())->pluck('orders_count'));

    if (Array.isArray(revCategories) && revCategories.length > 0 && typeof ApexCharts !== 'undefined') {
        function formatCurrencyShort(val) {
            var n = parseFloat(val || 0);
            if (n >= 1000000) return 'RM ' + (n / 1000000).toFixed(1) + 'M';
            if (n >= 1000) return 'RM ' + (n / 1000).toFixed(1) + 'K';
            return 'RM ' + n.toFixed(0);
        }

        function formatPeriodLabel(p) {
            if (typeof p !== 'string') return p;
            if (/^\d{4}-\d{2}-\d{2}$/.test(p)) {
                var d = new Date(p + 'T00:00:00');
                if (!isNaN(d)) return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            } else if (/^\d{4}-\d{2}$/.test(p)) {
                var parts = p.split('-');
                var d2 = new Date(parts[0], parseInt(parts[1], 10) - 1, 1);
                if (!isNaN(d2)) return d2.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            }
            return p;
        }

        var displayCategories = revCategories.map(formatPeriodLabel);

        var revenueOptions = {
            chart: {
                height: 400,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                zoom: { enabled: false }
            },
            colors: ['#8b5cf6'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
            },
            stroke: { width: 3, curve: 'smooth' },
            dataLabels: { enabled: false },
            grid: {
                show: true,
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
                padding: { left: 20, right: 20, top: 20, bottom: 20 }
            },
            series: [{ name: 'Revenue', data: revSeries }],
            xaxis: {
                categories: displayCategories,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { fontSize: '12px', colors: '#9ca3af' } }
            },
            yaxis: {
                labels: {
                    formatter: function(val) { return formatCurrencyShort(val); },
                    style: { fontSize: '12px', colors: '#9ca3af' }
                }
            },
            tooltip: {
                theme: 'light',
                custom: function({ series, seriesIndex, dataPointIndex, w }) {
                    var dateLabel = w.globals.labels[dataPointIndex] || '';
                    var revenue = series[seriesIndex][dataPointIndex] || 0;
                    var orders = revOrders[dataPointIndex] || 0;
                    return '<div class="px-4 py-3 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700">'
                        + '<div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">' + dateLabel + '</div>'
                        + '<div class="flex items-center justify-between gap-4"><span class="text-sm text-gray-600 dark:text-gray-300">Revenue</span><span class="text-sm font-bold text-purple-600">RM ' + parseFloat(revenue).toLocaleString('en-US', {minimumFractionDigits: 2}) + '</span></div>'
                        + '<div class="flex items-center justify-between gap-4 mt-1"><span class="text-sm text-gray-600 dark:text-gray-300">Orders</span><span class="text-sm font-semibold text-gray-900 dark:text-white">' + orders + '</span></div>'
                        + '</div>';
                }
            },
            markers: { size: 0, hover: { size: 5 } }
        };

        new ApexCharts(document.getElementById('revenue-line-chart'), revenueOptions).render();
    } else {
        document.getElementById('revenue-line-chart').innerHTML = '<div class="h-96 flex flex-col items-center justify-center text-gray-400"><svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg><p class="text-sm">No revenue data found for this period</p></div>';
    }

    // Genre Pie Chart
    var genreData = @json($salesByGenre ?? collect());
    if (Array.isArray(genreData) && genreData.length > 0 && typeof ApexCharts !== 'undefined') {
        var labels = genreData.map(function(item) { return item.name || 'Unknown'; });
        var series = genreData.map(function(item) { return parseFloat(item.total_revenue || 0); });
        var colors = ['#ec4899', '#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1', '#14b8a6'];
        var chartColors = labels.map(function(_, i) { return colors[i % colors.length]; });
        var totalRevenue = series.reduce(function(a, b) { return a + b; }, 0);

        var genreOptions = {
            chart: { type: 'donut', height: 300, fontFamily: 'Inter, sans-serif', toolbar: { show: false } },
            series: series,
            labels: labels,
            colors: chartColors,
            dataLabels: { enabled: false },
            legend: { show: false },
            stroke: { show: false },
            tooltip: {
                enabled: true,
                theme: 'light',
                custom: function({ series, seriesIndex, w }) {
                    var label = w.globals.labels[seriesIndex];
                    var value = series[seriesIndex];
                    var percentage = ((value / totalRevenue) * 100).toFixed(1);
                    var color = w.globals.colors[seriesIndex];
                    return '<div class="px-3 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700">'
                        + '<div class="flex items-center mb-1"><div class="w-2 h-2 rounded-full mr-2" style="background-color:' + color + '"></div><span class="text-xs font-semibold text-gray-700 dark:text-gray-300">' + label + '</span></div>'
                        + '<div class="text-sm font-bold text-gray-900 dark:text-white">RM ' + parseFloat(value).toLocaleString('en-US', {minimumFractionDigits: 2}) + '</div>'
                        + '<div class="text-xs text-gray-500 dark:text-gray-400">' + percentage + '% of total</div>'
                        + '</div>';
                }
            },
            plotOptions: {
                pie: { donut: { size: '70%', labels: { show: false } } }
            }
        };

        new ApexCharts(document.getElementById('genre-sales-pie-chart'), genreOptions).render();
    }
});
</script>
@endsection
