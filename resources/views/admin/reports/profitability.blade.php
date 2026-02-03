@extends('layouts.admin')

@section('header', 'Profitability Reports')

@section('content')
<div class="space-y-8">
    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Report Filters</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Overall Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">RM {{ number_format($overallSummary['total_revenue'], 2) }}</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Cost</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">RM {{ number_format($overallSummary['total_cost'], 2) }}</p>
                </div>
                <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Profit</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">RM {{ number_format($overallSummary['total_profit'], 2) }}</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Profit Margin</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($overallSummary['profit_margin'], 2) }}%</p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Financial Trends (Time-Series) -->
        <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Financial Trends</h3>
            <div id="financial-trends-chart" class="w-full"></div>
        </div>

        <!-- Top 10 Most Profitable Books -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Top 5 Books by Profit</h3>
            <div id="top-books-chart" class="w-full"></div>
        </div>

        <!-- Revenue Source Breakdown -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Revenue Composition</h3>
            <div id="revenue-composition-chart" class="w-full flex justify-center"></div>
        </div>
    </div>

    <!-- Profit Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Book Sales Profit</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Revenue from Books</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">RM {{ number_format($overallSummary['book_revenue'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Profit from Books</span>
                    <span class="text-sm font-semibold text-green-600">RM {{ number_format($overallSummary['book_profit'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Orders</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($overallSummary['order_count']) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Shipping Profit/Loss</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Shipping Revenue</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">RM {{ number_format($overallSummary['shipping_revenue'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Shipping Profit/Loss</span>
                    <span class="text-sm font-semibold {{ $overallSummary['shipping_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        RM {{ number_format($overallSummary['shipping_profit'], 2) }}
                    </span>
                </div>
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $overallSummary['shipping_profit'] >= 0 ? '✓ Shipping is profitable' : '⚠ Shipping is losing money' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profit Margin by Book -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Top 10 Profitable Books</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.reports.export.profitability', ['type' => 'books', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cost</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Profit</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Margin %</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($profitMarginByBook as $book)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                    @if($book->cover_image)
                                                <img class="h-10 w-8 object-cover rounded" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                        @else
                                        <div class="h-10 w-8 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                            <svg class="h-6 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $book->title }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $book->author }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">RM {{ number_format($book->total_revenue, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">RM {{ number_format($book->total_cost, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-green-600">RM {{ number_format($book->total_profit, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-blue-600">{{ number_format($book->profit_margin, 2) }}%</td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">No book profitability data available for the selected period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Profit Margin by Genre -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Profit by Genre</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.reports.export.profitability', ['type' => 'genres', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Genre</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cost</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Profit</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Margin %</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($profitMarginByGenre as $genre)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $genre->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">RM {{ number_format($genre->total_revenue, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">RM {{ number_format($genre->total_cost, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-green-600">RM {{ number_format($genre->total_profit, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-blue-600">{{ number_format($genre->profit_margin, 2) }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">No genre profitability data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
                </div>
            </div>

    <!-- Profit Margin by Trope -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Top 10 Profitable Tropes</h3>
                            </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Trope</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Orders</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cost</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Profit</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Margin %</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($profitMarginByTrope as $trope)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $trope->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">{{ number_format($trope->order_count) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">RM {{ number_format($trope->total_revenue, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">RM {{ number_format($trope->total_cost, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-green-600">RM {{ number_format($trope->total_profit, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-blue-600">{{ number_format($trope->profit_margin, 2) }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">No trope profitability data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Postage Rate Profitability -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Shipping Profitability by Region</h3>
        </div>
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Collected</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">RM {{ number_format($postageProfitability['total_metrics']->total_customer_paid ?? 0, 2) }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Cost</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">RM {{ number_format($postageProfitability['total_metrics']->total_actual_cost ?? 0, 2) }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Net Profit/Loss</p>
                <p class="text-xl font-bold {{ ($postageProfitability['total_metrics']->total_profit_loss ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    RM {{ number_format($postageProfitability['total_metrics']->total_profit_loss ?? 0, 2) }}
                </p>
            </div>
        </div>

        <!-- By Region Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Region</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Orders</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer Paid</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actual Cost</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Profit/Loss</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Avg Customer</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Avg Cost</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($postageProfitability['by_region'] as $region)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ strtoupper($region->shipping_region) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">{{ number_format($region->order_count) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">RM {{ number_format($region->customer_paid, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">RM {{ number_format($region->actual_cost, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold {{ $region->profit_loss >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                RM {{ number_format($region->profit_loss, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">RM {{ number_format($region->avg_customer_price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-300">RM {{ number_format($region->avg_actual_cost, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">No shipping data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>

        <!-- Free Shipping Impact -->
        @if($postageProfitability['free_shipping_impact'] && $postageProfitability['free_shipping_impact']->free_shipping_count > 0)
        <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Free Shipping Impact</h4>
                    <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-400">
                        <strong>{{ number_format($postageProfitability['free_shipping_impact']->free_shipping_count) }}</strong> orders with free shipping resulted in 
                        <strong>RM {{ number_format($postageProfitability['free_shipping_impact']->lost_revenue, 2) }}</strong> in absorbed shipping costs.
                    </p>
                </div>
            </div>
        </div>
        @endif
        </div>

        @php
        // Prepare Data for Charts
        
        // 1. Financial Trends
        $chartMonths = collect($monthlyProfitExpenses ?? [])->pluck('month')->map(function($m) {
            return \Carbon\Carbon::parse($m . '-01')->format('M Y');
        })->toArray();
        $chartRevenue = collect($monthlyProfitExpenses ?? [])->pluck('revenue')->map(fn($v) => (float) $v)->toArray();
        $chartCost = collect($monthlyProfitExpenses ?? [])->pluck('cost')->map(fn($v) => (float) $v)->toArray();
        $chartProfit = collect($monthlyProfitExpenses ?? [])->pluck('profit')->map(fn($v) => (float) $v)->toArray();

        // 2. Top Books (Top 5 for Chart)
        $topBooks = collect($profitMarginByBook ?? [])->take(5);
        $bookTitles = $topBooks->pluck('title')->map(fn($t) => \Illuminate\Support\Str::limit($t, 25))->toArray();
        $bookProfits = $topBooks->pluck('total_profit')->map(fn($v) => (float) $v)->toArray();

        // 3. Revenue Composition
        $bookRev = (float) ($overallSummary['book_revenue'] ?? 0);
        $shipRev = (float) ($overallSummary['shipping_revenue'] ?? 0);
        @endphp

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if ApexCharts is loaded
            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not loaded. Please include ApexCharts library.');
                return;
            }

            // Common chart options
            const commonOptions = {
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
            };

            // 1. Financial Trends Chart
            const financialTrendsEl = document.querySelector("#financial-trends-chart");
            if (financialTrendsEl) {
                // Check if data exists
                const chartRevenue = @json($chartRevenue ?? []);
                const chartCost = @json($chartCost ?? []);
                const chartProfit = @json($chartProfit ?? []);
                const chartMonths = @json($chartMonths ?? []);
                
                if (chartMonths.length > 0 && chartRevenue.length > 0) {
                    const trendsOptions = {
                    ...commonOptions,
                    series: [
                        { name: "Revenue", data: chartRevenue },
                        { name: "Cost", data: chartCost },
                        { name: "Net Profit", data: chartProfit }
                    ],
                    chart: {
                        type: 'line',
                        height: 350,
                        zoom: { enabled: false },
                        toolbar: { show: true }
                    },
                    colors: ['#31C48D', '#F05252', '#3B82F6'], // Green, Red, Blue
                    stroke: {
                        width: [3, 3, 4],
                        curve: 'smooth',
                        dashArray: [0, 0, 0]
                    },
                    markers: {
                        size: [5, 5, 6],
                        hover: { size: 8 }
                    },
                    dataLabels: { 
                        enabled: true,
                        formatter: function (val) {
                            return "RM " + val.toFixed(0);
                        },
                        style: {
                            fontSize: '11px',
                            fontWeight: 600,
                            colors: ['#31C48D', '#F05252', '#3B82F6']
                        },
                        offsetY: -10
                    },
                    xaxis: {
                        categories: chartMonths,
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        labels: {
                            style: {
                                fontSize: '12px',
                                colors: '#6B7280'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function (value) {
                                if (value === undefined || value === null || isNaN(value)) {
                                    return "RM 0";
                                }
                                return "RM " + value.toFixed(0);
                            },
                            style: {
                                fontSize: '12px',
                                colors: '#6B7280'
                            }
                        }
                    },
                    legend: { 
                        position: 'top',
                        horizontalAlign: 'left',
                        fontSize: '14px',
                        fontWeight: 600,
                        markers: {
                            width: 12,
                            height: 12,
                            radius: 6
                        },
                        itemMargin: {
                            horizontal: 20,
                            vertical: 5
                        },
                        formatter: function(seriesName, opts) {
                            const value = opts.w.globals.series[opts.seriesIndex]?.[opts.dataPointIndex];
                            if (value === undefined || value === null || isNaN(value)) {
                                return seriesName + ": <strong>RM 0.00</strong>";
                            }
                            return seriesName + ": <strong>RM " + value.toFixed(2) + "</strong>";
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        followCursor: true,
                        y: {
                            formatter: function (val, { seriesIndex }) {
                                if (val === undefined || val === null || isNaN(val)) {
                                    return "N/A: RM 0.00";
                                }
                                const labels = ['Revenue', 'Cost', 'Net Profit'];
                                return labels[seriesIndex] + ": RM " + val.toFixed(2);
                            }
                        },
                        custom: function({series, seriesIndex, dataPointIndex, w}) {
                            try {
                                const month = w.globals.categoryLabels[dataPointIndex] || 'Unknown';
                                const revenue = series[0]?.[dataPointIndex] || 0;
                                const cost = series[1]?.[dataPointIndex] || 0;
                                const profit = series[2]?.[dataPointIndex] || 0;
                                const margin = revenue > 0 ? ((profit / revenue) * 100).toFixed(2) : 0;
                                
                                return '<div style="padding: 12px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">' +
                                    '<div style="font-weight: 600; margin-bottom: 8px; color: #111827;">' + month + '</div>' +
                                    '<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">' +
                                    '<div style="display: flex; align-items: center;"><span style="width: 12px; height: 12px; border-radius: 50%; background: #31C48D; margin-right: 8px;"></span><span style="color: #6b7280;">Revenue:</span></div>' +
                                    '<span style="font-weight: 700; color: #10b981;">RM ' + revenue.toFixed(2) + '</span></div>' +
                                    '<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">' +
                                    '<div style="display: flex; align-items: center;"><span style="width: 12px; height: 12px; border-radius: 50%; background: #F05252; margin-right: 8px;"></span><span style="color: #6b7280;">Cost:</span></div>' +
                                    '<span style="font-weight: 700; color: #ef4444;">RM ' + cost.toFixed(2) + '</span></div>' +
                                    '<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">' +
                                    '<div style="display: flex; align-items: center;"><span style="width: 12px; height: 12px; border-radius: 50%; background: #3B82F6; margin-right: 8px;"></span><span style="color: #6b7280;">Net Profit:</span></div>' +
                                    '<span style="font-weight: 700; color: #3b82f6;">RM ' + profit.toFixed(2) + '</span></div>' +
                                    '<div style="padding-top: 8px; margin-top: 8px; border-top: 1px solid #e5e7eb;">' +
                                    '<div style="display: flex; align-items: center; justify-content: space-between;">' +
                                    '<span style="font-size: 12px; color: #9ca3af;">Profit Margin:</span>' +
                                    '<span style="font-size: 12px; font-weight: 700; color: ' + (margin >= 0 ? '#10b981' : '#ef4444') + ';">' + margin + '%</span></div></div></div>';
                            } catch (e) {
                                console.error('Tooltip error:', e);
                                return '';
                            }
                        }
                    },
                    grid: {
                        borderColor: '#f1f1f1',
                        strokeDashArray: 4,
                        xaxis: { lines: { show: false } },
                        yaxis: { lines: { show: true } }
                    }
                };
                try {
                    new ApexCharts(financialTrendsEl, trendsOptions).render();
                } catch (error) {
                    console.error('Error rendering Financial Trends chart:', error);
                    financialTrendsEl.innerHTML = '<p class="text-center text-gray-500 py-8">Error loading chart. Please refresh the page.</p>';
                }
                } else {
                    financialTrendsEl.innerHTML = '<p class="text-center text-gray-500 py-8">No data available for the selected period.</p>';
                }
            } else {
                console.error('Financial Trends chart element not found');
            }

            // 2. Top Books Bar Chart
            const topBooksEl = document.querySelector("#top-books-chart");
            if (topBooksEl) {
                const bookTitles = @json($bookTitles ?? []);
                const bookProfits = @json($bookProfits ?? []);
                
                if (bookTitles.length > 0 && bookProfits.length > 0) {
                    const booksOptions = {
                    ...commonOptions,
                    series: [{
                        name: 'Profit',
                        data: bookProfits
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: { show: true }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: true,
                            barHeight: '70%',
                            distributed: true,
                            dataLabels: {
                                position: 'center'
                            }
                        }
                    },
                    colors: ['#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE', '#DBEAFE'],
                    dataLabels: {
                        enabled: true,
                        textAnchor: 'middle',
                        style: {
                            colors: ['#fff'],
                            fontSize: '12px',
                            fontWeight: 600
                        },
                        formatter: function (val, opt) {
                            if (val === undefined || val === null || isNaN(val)) {
                                return "RM 0";
                            }
                            return "RM " + val.toFixed(0);
                        },
                        offsetX: 0,
                    },
                    xaxis: {
                        categories: bookTitles,
                        labels: {
                            formatter: function (val) {
                                return "RM " + val;
                            },
                            style: {
                                fontSize: '12px',
                                colors: '#6B7280'
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '12px',
                                colors: '#6B7280'
                            }
                        }
                    },
                    legend: { 
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right',
                        fontSize: '14px',
                        fontWeight: 600,
                        markers: {
                            width: 12,
                            height: 12,
                            radius: 6
                        },
                        formatter: function(seriesName) {
                            return seriesName + " (Top 5 Books)";
                        }
                    },
                    tooltip: {
                        shared: false,
                        intersect: true,
                        followCursor: true,
                        custom: function({series, seriesIndex, dataPointIndex, w}) {
                            const bookTitle = w.globals.categoryLabels[dataPointIndex] || 'Unknown';
                            const profit = series[seriesIndex]?.[dataPointIndex] || 0;
                            const fullTitle = @json($topBooks->pluck('title')->toArray())[dataPointIndex] || bookTitle;
                            const bookData = @json($topBooks->values()->toArray())[dataPointIndex] || null;
                            
                            return `
                                <div class="p-3 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white mb-2">${fullTitle}</div>
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Profit:</span>
                                            <span class="text-sm font-bold text-blue-600">RM ${profit.toFixed(2)}</span>
                                        </div>
                                        ${bookData ? `
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Revenue:</span>
                                            <span class="text-sm font-semibold text-green-600">RM ${parseFloat(bookData.total_revenue || 0).toFixed(2)}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Cost:</span>
                                            <span class="text-sm font-semibold text-red-600">RM ${parseFloat(bookData.total_cost || 0).toFixed(2)}</span>
                                        </div>
                                        <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Profit Margin:</span>
                                                <span class="text-xs font-bold text-purple-600">${parseFloat(bookData.profit_margin || 0).toFixed(2)}%</span>
                                            </div>
    </div>
                                        ` : ''}
            </div>
        </div>
                            `;
                        }
                    },
                    grid: {
                        borderColor: '#f1f1f1',
                        strokeDashArray: 4,
                        xaxis: { lines: { show: true } },
                        yaxis: { lines: { show: false } }
                    }
                };
                try {
                    new ApexCharts(topBooksEl, booksOptions).render();
                } catch (error) {
                    console.error('Error rendering Top Books chart:', error);
                    topBooksEl.innerHTML = '<p class="text-center text-gray-500 py-8">Error loading chart. Please refresh the page.</p>';
                }
                } else {
                    topBooksEl.innerHTML = '<p class="text-center text-gray-500 py-8">No book data available.</p>';
                }
            } else {
                console.error('Top Books chart element not found');
            }

            // 3. Revenue Composition Donut Chart
            const revenueCompositionEl = document.querySelector("#revenue-composition-chart");
            if (revenueCompositionEl) {
                const bookRev = @json($bookRev ?? 0);
                const shipRev = @json($shipRev ?? 0);
                
                if (bookRev > 0 || shipRev > 0) {
                    const compositionOptions = {
                    ...commonOptions,
                    series: [bookRev, shipRev],
                    labels: ['Book Sales', 'Shipping Fees'],
                    chart: {
                        type: 'donut',
                        height: 350,
                        toolbar: { show: true }
                    },
                    colors: ['#1A56DB', '#10B981'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '16px',
                                        fontWeight: 600,
                                        color: '#374151',
                                        offsetY: -10
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '24px',
                                        fontWeight: 700,
                                        color: '#111827',
                                        offsetY: 10,
                                        formatter: function (val) {
                                            const numVal = parseFloat(val) || 0;
                                            return "RM " + numVal.toFixed(0);
                                        }
                                    },
                                    total: {
                                        show: true,
                                        showAlways: true,
                                        label: 'Total Revenue',
                                        fontSize: '14px',
                                        fontWeight: 600,
                                        color: '#6B7280',
                                        formatter: function (w) {
                                            const total = w.globals.seriesTotals.reduce((a, b) => (a || 0) + (b || 0), 0);
                                            return "RM " + total.toFixed(2);
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val, opts) {
                            if (val === undefined || val === null || isNaN(val)) {
                                return "0%";
                            }
                            return val.toFixed(1) + "%";
                        },
                        style: {
                            fontSize: '12px',
                            fontWeight: 600,
                            colors: ['#fff']
                        },
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 1,
                            left: 1,
                            blur: 1,
                            opacity: 0.35
                        }
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '14px',
                        fontWeight: 600,
                        markers: {
                            width: 14,
                            height: 14,
                            radius: 7,
                            offsetX: -5,
                            offsetY: 0
                        },
                        itemMargin: {
                            horizontal: 15,
                            vertical: 8
                        },
                        formatter: function(seriesName, opts) {
                            const value = opts.w.globals.series[opts.seriesIndex];
                            const percentage = opts.percent.toFixed(1);
                            return seriesName + ": <strong>RM " + value.toFixed(2) + "</strong> (" + percentage + "%)";
                        }
                    },
                    tooltip: {
                        shared: false,
                        followCursor: true,
                        custom: function({series, seriesIndex, dataPointIndex, w}) {
                            const label = w.globals.labels[dataPointIndex] || 'Unknown';
                            const value = series[seriesIndex] || 0;
                            const percentage = (w.globals.seriesPercent[seriesIndex]?.[dataPointIndex] || 0).toFixed(2);
                            const total = w.globals.seriesTotals.reduce((a, b) => (a || 0) + (b || 0), 0);
                            
                            return `
                                <div class="p-3 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white mb-2">${label}</div>
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Amount:</span>
                                            <span class="text-sm font-bold ${dataPointIndex === 0 ? 'text-blue-600' : 'text-green-600'}">RM ${value.toFixed(2)}</span>
            </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Percentage:</span>
                                            <span class="text-sm font-semibold text-purple-600">${percentage}%</span>
            </div>
                                        <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Total Revenue:</span>
                                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">RM ${total.toFixed(2)}</span>
            </div>
        </div>
    </div>
                                </div>
                            `;
                        }
                    }
                };
                try {
                    new ApexCharts(revenueCompositionEl, compositionOptions).render();
                } catch (error) {
                    console.error('Error rendering Revenue Composition chart:', error);
                    revenueCompositionEl.innerHTML = '<p class="text-center text-gray-500 py-8">Error loading chart. Please refresh the page.</p>';
                }
                } else {
                    revenueCompositionEl.innerHTML = '<p class="text-center text-gray-500 py-8">No revenue data available.</p>';
                }
            } else {
                console.error('Revenue Composition chart element not found');
            }
        });
    </script>
</div>
@endsection
