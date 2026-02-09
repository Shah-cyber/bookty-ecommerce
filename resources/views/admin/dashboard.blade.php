@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
   
    <!-- Dashboard Skeleton Loader -->
    <div id="dashboard-skeleton" class="animate-pulse space-y-6">
        <!-- Skeleton: Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                    <div class="flex items-center justify-between">
                        <div class="space-y-3 flex-1">
                            <div class="h-3 w-20 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                            <div class="h-7 w-28 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                            <div class="h-2 w-16 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                        </div>
                        <div class="h-12 w-12 rounded-xl bg-gray-200 dark:bg-gray-700"></div>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Skeleton: Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @for ($i = 0; $i < 2; $i++)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div class="h-5 w-32 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                        <div class="h-8 w-24 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                    </div>
                    <div class="h-72 w-full bg-gray-100 dark:bg-gray-700 rounded-xl"></div>
                </div>
            @endfor
        </div>
    </div>

    <!-- Real Dashboard Content -->
    <div id="dashboard-content" class="hidden space-y-6">

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute right-20 bottom-0 w-32 h-32 bg-white/5 rounded-full -mb-16"></div>
            <div class="relative z-10">
                <h1 class="text-2xl font-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-purple-100">Here's what's happening with your store today.</p>
                <div class="mt-4 flex flex-wrap gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                        <span class="text-purple-200 text-sm">Today's Orders</span>
                        <p class="text-xl font-bold" id="today-orders-banner">{{ $todayOrders ?? 0 }}</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2">
                        <span class="text-purple-200 text-sm">Today's Revenue</span>
                        <p class="text-xl font-bold" id="today-revenue-banner">RM {{ number_format($todayRevenue ?? 0, 2) }}</p>
                    </div>
                    @if($pendingOrdersCount > 0)
                        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
                           class="bg-yellow-500/90 hover:bg-yellow-500 backdrop-blur-sm rounded-xl px-4 py-2 transition-colors">
                            <span class="text-yellow-100 text-sm">Needs Attention</span>
                            <p class="text-xl font-bold">{{ $pendingOrdersCount }} Pending</p>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <!-- Total Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">RM {{ number_format($totalRevenue ?? 0, 2) }}</h4>
                        <div class="flex items-center mt-2">
                            @if(($revenueTrend ?? 0) >= 0)
                                <span class="inline-flex items-center text-xs font-medium text-green-600 dark:text-green-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                    {{ abs($revenueTrend) }}%
                                </span>
                            @else
                                <span class="inline-flex items-center text-xs font-medium text-red-600 dark:text-red-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                    {{ abs($revenueTrend) }}%
                                </span>
                            @endif
                            <span class="text-xs text-gray-400 ml-2">vs last month</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</p>
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalOrders ?? 0) }}</h4>
                        <div class="flex items-center mt-2">
                            @if(($ordersTrend ?? 0) >= 0)
                                <span class="inline-flex items-center text-xs font-medium text-green-600 dark:text-green-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                    {{ abs($ordersTrend) }}%
                                </span>
                            @else
                                <span class="inline-flex items-center text-xs font-medium text-red-600 dark:text-red-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                    {{ abs($ordersTrend) }}%
                                </span>
                            @endif
                            <span class="text-xs text-gray-400 ml-2">vs last month</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Customers</p>
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalCustomers ?? 0) }}</h4>
                        <div class="flex items-center mt-2">
                            @if(($customersTrend ?? 0) >= 0)
                                <span class="inline-flex items-center text-xs font-medium text-green-600 dark:text-green-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                    {{ abs($customersTrend) }}%
                                </span>
                            @else
                                <span class="inline-flex items-center text-xs font-medium text-red-600 dark:text-red-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                    {{ abs($customersTrend) }}%
                                </span>
                            @endif
                            <span class="text-xs text-gray-400 ml-2">vs last month</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 text-white shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Books -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Books</p>
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalBooks ?? 0) }}</h4>
                        <div class="flex items-center mt-2">
                            @php
                                $lowStockCount = isset($lowStockBooks) ? $lowStockBooks->count() : 0;
                            @endphp
                            @if($lowStockCount > 0)
                                <span class="inline-flex items-center text-xs font-medium text-amber-600 dark:text-amber-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    {{ $lowStockCount }} low stock
                                </span>
                            @else
                                <span class="inline-flex items-center text-xs font-medium text-green-600 dark:text-green-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    All stocked
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sales Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sales Overview</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Revenue performance over time</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p id="salesChartTotal" class="text-2xl font-bold text-gray-900 dark:text-white">RM 0.00</p>
                            <div id="salesChartChangeWrap" class="flex items-center justify-end gap-1 text-sm">
                                <span id="salesChartChange" class="font-medium text-green-600 dark:text-green-400">0%</span>
                                <svg id="salesChartIcon" class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                            </div>
                        </div>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" type="button"
                                class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                                <span id="salesPeriodLabel">This week</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-44 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50">
                                <a href="#" data-period="today" class="sales-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Today</a>
                                <a href="#" data-period="yesterday" class="sales-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Yesterday</a>
                                <a href="#" data-period="this_week" class="sales-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">This week</a>
                                <a href="#" data-period="last_7_days" class="sales-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Last 7 days</a>
                                <a href="#" data-period="last_30_days" class="sales-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Last 30 days</a>
                                <a href="#" data-period="last_90_days" class="sales-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Last 90 days</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sales-chart" class="w-full" style="min-height: 300px;"></div>
                <div class="flex items-center justify-between pt-4 mt-2 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Revenue</span>
                        </div>
                        <div id="salesAvgOrder" class="text-gray-500 dark:text-gray-400">
                            Avg: <span class="font-medium text-gray-900 dark:text-white">RM 0.00</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.sales') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 inline-flex items-center gap-1 transition-colors">
                        View Report
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Top Selling Books Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Top Selling Books</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Best performers by quantity sold</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p id="topBooksTotal" class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">units sold</p>
                        </div>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" type="button"
                                class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                                <span id="topBooksPeriodLabel">Last 6 months</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-44 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50">
                                <a href="#" data-period="today" class="topbooks-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Today</a>
                                <a href="#" data-period="yesterday" class="topbooks-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Yesterday</a>
                                <a href="#" data-period="last_7_days" class="topbooks-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Last 7 days</a>
                                <a href="#" data-period="last_30_days" class="topbooks-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Last 30 days</a>
                                <a href="#" data-period="last_90_days" class="topbooks-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Last 90 days</a>
                                <a href="#" data-period="last_6_months" class="topbooks-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Last 6 months</a>
                                <a href="#" data-period="last_year" class="topbooks-period-option block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Last year</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="topbooks-chart" class="w-full" style="min-height: 300px;"></div>
                <div class="flex items-center justify-between pt-4 mt-2 border-t border-gray-100 dark:border-gray-700">
                    <div id="topBooksLeader" class="text-sm text-gray-600 dark:text-gray-400">
                        Top: <span class="font-medium text-purple-600 dark:text-purple-400">—</span>
                    </div>
                    <a href="{{ route('admin.reports.sales') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 inline-flex items-center gap-1 transition-colors">
                        View Report
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Low Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Orders</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Latest customer orders</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 inline-flex items-center gap-1 transition-colors">
                        View all
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400">
                                            #{{ $order->public_id }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ substr($order->user->name ?? 'G', 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm text-gray-900 dark:text-white">{{ $order->user->name ?? 'Guest' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        RM {{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                                'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                'shipped' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                                                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No orders yet</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-amber-100 dark:bg-amber-900/30">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Low Stock</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Needs restocking</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 space-y-3 max-h-[400px] overflow-y-auto">
                    @forelse($lowStockBooks as $book)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-10 h-14 object-cover rounded-lg shadow-sm">
                            @else
                                <div class="w-10 h-14 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $book->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $book->author }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $book->stock <= 3 ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' }}">
                                    {{ $book->stock }} left
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-green-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">All books are well stocked!</p>
                        </div>
                    @endforelse
                </div>
                @if(count($lowStockBooks) > 0)
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('admin.books.index') }}" class="block w-full text-center px-4 py-2 text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-xl transition-colors">
                            Manage Inventory
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Order Status Distribution</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Current order breakdown by status</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $statuses = [
                        'pending' => ['label' => 'Pending', 'color' => 'yellow', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'processing' => ['label' => 'Processing', 'color' => 'blue', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                        'shipped' => ['label' => 'Shipped', 'color' => 'indigo', 'icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4'],
                        'completed' => ['label' => 'Completed', 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'cancelled' => ['label' => 'Cancelled', 'color' => 'red', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                @endphp
                @foreach($statuses as $key => $status)
                    <div class="p-4 rounded-xl bg-{{ $status['color'] }}-50 dark:bg-{{ $status['color'] }}-900/20 border border-{{ $status['color'] }}-100 dark:border-{{ $status['color'] }}-900/30">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-{{ $status['color'] }}-100 dark:bg-{{ $status['color'] }}-900/40">
                                <svg class="w-5 h-5 text-{{ $status['color'] }}-600 dark:text-{{ $status['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-{{ $status['color'] }}-700 dark:text-{{ $status['color'] }}-300">{{ $orderStatusCounts[$key] ?? 0 }}</p>
                                <p class="text-xs font-medium text-{{ $status['color'] }}-600 dark:text-{{ $status['color'] }}-400">{{ $status['label'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div> <!-- /#dashboard-content -->

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Show content after short delay
            var skeleton = document.getElementById('dashboard-skeleton');
            var content = document.getElementById('dashboard-content');

            setTimeout(function () {
                if (skeleton) skeleton.classList.add('hidden');
                if (content) content.classList.remove('hidden');
                
                // Initialize charts after content is visible
                initSalesChart();
                initTopBooksChart();
            }, 400);

            // Format currency
            function formatRM(n) {
                return 'RM ' + parseFloat(n || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            // Sales Chart
            var salesChart = null;
            function initSalesChart() {
                loadSalesData('this_week', 'This week');
            }

            function renderSalesChart(labels, revenue, orders) {
                var el = document.getElementById('sales-chart');
                if (!el || typeof ApexCharts === 'undefined') return;

                var isDark = document.documentElement.classList.contains('dark');

                if (salesChart) salesChart.destroy();

                // Handle single data point scenario (like "today" or "yesterday")
                var isSinglePoint = labels.length === 1;
                
                // For single point, ensure we have at least 2 points for better visualization
                var displayLabels = labels;
                var displayRevenue = revenue;
                var displayOrders = orders;
                
                if (isSinglePoint) {
                    // Add a starting point at 0 for better visual representation
                    displayLabels = ['Start', labels[0]];
                    displayRevenue = [0, revenue[0]];
                    displayOrders = [0, orders[0]];
                }

                var options = {
                    series: [{ name: 'Revenue', data: displayRevenue }],
                    chart: {
                        height: 300,
                        type: 'area',
                        fontFamily: 'Inter, sans-serif',
                        toolbar: { show: false },
                        zoom: { enabled: false },
                        animations: { enabled: true, easing: 'easeinout', speed: 800 },
                        sparkline: { enabled: false }
                    },
                    colors: ['#7c3aed'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0.05,
                            stops: [0, 90, 100]
                        }
                    },
                    dataLabels: { 
                        enabled: false, // Disable data labels to keep chart clean, use tooltips instead
                        formatter: function(val) {
                            return val > 0 ? formatRM(val) : '';
                        }
                    },
                    stroke: { 
                        curve: isSinglePoint ? 'straight' : 'smooth', // Straight line for single point
                        width: 3 
                    },
                    markers: {
                        size: isSinglePoint ? 6 : 5, // Larger markers for single point, visible markers for all
                        colors: ['#7c3aed'],
                        strokeColors: '#fff',
                        strokeWidth: 2,
                        hover: { size: 8 },
                        showNullDataPoints: false
                    },
                    grid: {
                        show: true,
                        borderColor: isDark ? '#374151' : '#f3f4f6',
                        strokeDashArray: 4,
                        xaxis: { lines: { show: false } },
                        yaxis: { lines: { show: true } },
                        padding: { top: isSinglePoint ? 20 : 0, right: 0, bottom: 0, left: 10 }
                    },
                    xaxis: {
                        categories: displayLabels,
                        labels: {
                            style: {
                                colors: isDark ? '#9ca3af' : '#6b7280',
                                fontSize: '12px',
                                fontWeight: isSinglePoint ? 600 : 400
                            },
                            formatter: function(value) {
                                // Hide "Start" label for single point scenarios
                                return value === 'Start' ? '' : value;
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        min: 0,
                        labels: {
                            formatter: function (value) {
                                // Format as RM currency
                                if (value >= 1000000) {
                                    return 'RM ' + (value / 1000000).toFixed(1) + 'M';
                                } else if (value >= 1000) {
                                    return 'RM ' + (value / 1000).toFixed(1) + 'k';
                                } else {
                                    return 'RM ' + value.toFixed(0);
                                }
                            },
                            style: {
                                colors: isDark ? '#9ca3af' : '#6b7280',
                                fontSize: '11px'
                            }
                        },
                        forceNiceScale: true // Ensure nice round numbers on Y-axis
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        custom: function({ series, seriesIndex, dataPointIndex, w }) {
                            // Skip tooltip for the "Start" point
                            if (isSinglePoint && dataPointIndex === 0) {
                                return '';
                            }
                            
                            var actualIndex = isSinglePoint ? dataPointIndex - 1 : dataPointIndex;
                            var date = labels[actualIndex] || '';
                            var rev = revenue[actualIndex] || 0;
                            var ord = orders[actualIndex] || 0;
                            var aov = ord > 0 ? (rev / ord) : 0;
                            return '<div class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg">' +
                                '<div class="font-semibold text-gray-900 dark:text-white mb-1">' + date + '</div>' +
                                '<div class="text-xs text-gray-600 dark:text-gray-300 flex justify-between gap-4"><span>Revenue:</span> <span class="font-medium text-purple-600">' + formatRM(rev) + '</span></div>' +
                                '<div class="text-xs text-gray-600 dark:text-gray-300 flex justify-between gap-4"><span>Orders:</span> <span class="font-medium">' + ord + '</span></div>' +
                                '<div class="text-xs text-gray-600 dark:text-gray-300 flex justify-between gap-4"><span>Avg Order:</span> <span class="font-medium">' + formatRM(aov) + '</span></div>' +
                                '</div>';
                        }
                    }
                };

                salesChart = new ApexCharts(el, options);
                salesChart.render();
            }

            function loadSalesData(period, label) {
                var el = document.getElementById('sales-chart');
                if (el) el.style.opacity = '0.5';

                fetch("{{ route('admin.sales-this-period') }}?period=" + encodeURIComponent(period), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(res) { return res.json(); })
                .then(function(json) {
                    // Update header
                    var totalEl = document.getElementById('salesChartTotal');
                    var changeEl = document.getElementById('salesChartChange');
                    var wrapEl = document.getElementById('salesChartChangeWrap');
                    var iconEl = document.getElementById('salesChartIcon');
                    var labelEl = document.getElementById('salesPeriodLabel');
                    var avgEl = document.getElementById('salesAvgOrder');

                    if (totalEl) totalEl.textContent = formatRM(json.summary.total_revenue);
                    if (changeEl) changeEl.textContent = Math.abs(json.summary.change_percent) + '%';
                    if (labelEl) labelEl.textContent = label;
                    if (avgEl) avgEl.innerHTML = 'Avg: <span class="font-medium text-gray-900 dark:text-white">' + formatRM(json.summary.avg_order_value || 0) + '</span>';

                    if (wrapEl && changeEl && iconEl) {
                        var isPositive = json.summary.change_percent >= 0;
                        changeEl.className = 'font-medium ' + (isPositive ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400');
                        iconEl.className = 'w-4 h-4 ' + (isPositive ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400');
                        iconEl.style.transform = isPositive ? 'rotate(0deg)' : 'rotate(180deg)';
                    }

                    renderSalesChart(json.labels || [], json.revenue || [], json.orders || []);

                    if (el) el.style.opacity = '1';
                })
                .catch(function(err) {
                    console.error('Error loading sales data:', err);
                    if (el) el.style.opacity = '1';
                });
            }

            // Sales period dropdown
            document.querySelectorAll('.sales-period-option').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var period = this.getAttribute('data-period');
                    var label = this.textContent.trim();
                    loadSalesData(period, label);
                });
            });

            // Top Books Chart
            var topBooksChart = null;
            function initTopBooksChart() {
                loadTopBooksData('last_6_months', 'Last 6 months');
            }

            function renderTopBooksChart(titles, quantities, prices) {
                var el = document.getElementById('topbooks-chart');
                if (!el || typeof ApexCharts === 'undefined') return;

                var isDark = document.documentElement.classList.contains('dark');

                // Handle empty data
                if (!titles || titles.length === 0) {
                    el.innerHTML = '<div class="flex flex-col items-center justify-center py-16 text-gray-400 dark:text-gray-500">' +
                        '<svg class="w-16 h-16 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>' +
                        '<p class="text-sm font-medium">No sales data for this period</p></div>';
                    return;
                }

                if (topBooksChart) topBooksChart.destroy();

                var options = {
                    series: [{ name: 'Sold', data: quantities }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        fontFamily: 'Inter, sans-serif',
                        toolbar: { show: false },
                        animations: { enabled: true, easing: 'easeinout', speed: 800 }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 6,
                            borderRadiusApplication: 'end',
                            barHeight: '70%',
                            distributed: true
                        }
                    },
                    colors: ['#7c3aed', '#ec4899', '#06b6d4', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#14b8a6', '#f97316', '#6366f1'],
                    dataLabels: { enabled: false },
                    legend: { show: false },
                    grid: {
                        show: true,
                        borderColor: isDark ? '#374151' : '#f3f4f6',
                        strokeDashArray: 4,
                        xaxis: { lines: { show: true } },
                        yaxis: { lines: { show: false } }
                    },
                    xaxis: {
                        categories: titles,
                        labels: {
                            style: {
                                colors: isDark ? '#9ca3af' : '#6b7280',
                                fontSize: '11px'
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: isDark ? '#9ca3af' : '#6b7280',
                                fontSize: '11px',
                                fontWeight: 500
                            },
                            maxWidth: 200,
                            formatter: function(val) {
                                return val.length > 25 ? val.substring(0, 25) + '...' : val;
                            }
                        }
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        custom: function({ series, seriesIndex, dataPointIndex, w }) {
                            var qty = series[seriesIndex][dataPointIndex] || 0;
                            var price = parseFloat(prices[dataPointIndex]) || 0;
                            var total = (qty * price).toFixed(2);
                            var title = w.globals.labels[dataPointIndex] || '';
                            var color = w.globals.colors[dataPointIndex];
                            return '<div class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg">' +
                                '<div class="font-semibold text-gray-900 dark:text-white mb-1 flex items-center gap-2">' +
                                '<span class="w-2 h-2 rounded-full" style="background-color:' + color + '"></span>' +
                                title + '</div>' +
                                '<div class="text-xs text-gray-600 dark:text-gray-300">Quantity: <span class="font-medium">' + qty + '</span></div>' +
                                '<div class="text-xs text-gray-600 dark:text-gray-300">Revenue: <span class="font-medium">' + formatRM(total) + '</span></div>' +
                                '</div>';
                        }
                    }
                };

                topBooksChart = new ApexCharts(el, options);
                topBooksChart.render();
            }

            function loadTopBooksData(period, label) {
                var el = document.getElementById('topbooks-chart');
                if (el) el.style.opacity = '0.5';

                fetch("{{ route('admin.top-selling') }}?period=" + encodeURIComponent(period), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(res) { return res.json(); })
                .then(function(json) {
                    // Update header
                    var totalEl = document.getElementById('topBooksTotal');
                    var labelEl = document.getElementById('topBooksPeriodLabel');
                    var leaderEl = document.getElementById('topBooksLeader');

                    if (totalEl) totalEl.textContent = json.summary.total_sold || 0;
                    if (labelEl) labelEl.textContent = label;
                    if (leaderEl) {
                        leaderEl.innerHTML = 'Top: <span class="font-medium text-purple-600 dark:text-purple-400">' + (json.summary.top_title || '—') + '</span>';
                    }

                    renderTopBooksChart(json.titles || [], json.quantities || [], json.prices || []);

                    if (el) el.style.opacity = '1';
                })
                .catch(function(err) {
                    console.error('Error loading top books data:', err);
                    if (el) el.style.opacity = '1';
                });
            }

            // Top books period dropdown
            document.querySelectorAll('.topbooks-period-option').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var period = this.getAttribute('data-period');
                    var label = this.textContent.trim();
                    loadTopBooksData(period, label);
                });
            });

            // Real-time stats refresh (every 60 seconds)
            setInterval(function() {
                fetch("{{ route('admin.realtime-stats') }}", {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(res) { return res.json(); })
                .then(function(json) {
                    var todayOrdersEl = document.getElementById('today-orders-banner');
                    var todayRevenueEl = document.getElementById('today-revenue-banner');
                    
                    if (todayOrdersEl) todayOrdersEl.textContent = json.today_orders || 0;
                    if (todayRevenueEl) todayRevenueEl.textContent = formatRM(json.today_revenue || 0);
                })
                .catch(function(err) {
                    console.error('Error fetching real-time stats:', err);
                });
            }, 60000);
        });
    </script>
@endsection
