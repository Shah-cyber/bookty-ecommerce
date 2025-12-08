@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
   

    <!-- Stats Cards -->
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <!-- Total Books -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Books</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalBooks ?? 0 }}</h4>
                </div>
                <div class="p-3 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalOrders ?? 0 }}</h4>
                </div>
                <div class="p-3 rounded-xl bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Customers</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalCustomers ?? 0 }}</h4>
                </div>
                <div class="p-3 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">RM {{ $totalRevenue ?? '0.00' }}</h4>
                </div>
                <div class="p-3 rounded-xl bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-300 relative overflow-hidden">
            @if($pendingOrdersCount > 0)
                <div class="absolute top-0 right-0 w-16 h-16 bg-yellow-400/10 rounded-bl-full -mr-8 -mt-8"></div>
            @endif
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Orders</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $pendingOrdersCount ?? 0 }}</h4>
                    @if($pendingOrdersCount > 0)
                        <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                            Needs Attention
                        </span>
                    @endif
                </div>
                <div class="p-3 rounded-xl bg-yellow-50 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <!-- Recent Orders -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @if(isset($recentOrders) && count($recentOrders) > 0)
                            @foreach($recentOrders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $order->public_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $order->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">RM {{ $order->total_amount }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($order->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1.5"></span>
                                                Pending
                                            </span>
                                        @elseif($order->status === 'shipped')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1.5"></span>
                                                Shipped
                                            </span>
                                        @elseif($order->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></span>
                                                Completed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p>No recent orders found</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Best Selling Books (Flowbite-styled card + ApexCharts) -->
        <!-- Best Selling Books -->
        <div class="w-full bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex justify-between items-start border-b border-gray-100 dark:border-gray-700 pb-4 mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Top Selling Books</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Most popular titles by sales volume</p>
                </div>
                <span id="topBooksPeriodBadge" class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-full dark:bg-green-900/30 dark:text-green-300">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    This month
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Top Title</p>
                    <p class="text-base font-bold text-purple-600 dark:text-purple-400 mt-1 truncate" id="topBooksTopTitle">—</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-right">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Sold</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1" id="topBooksTotalSold">0</p>
                </div>
            </div>

            <div id="bar-chart" class="w-full"></div>

            <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100 dark:border-gray-700">
                <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown" data-dropdown-placement="bottom" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white inline-flex items-center transition-colors" type="button">
                    Last 6 months
                    <svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-lg w-44 dark:bg-gray-700 dark:divide-gray-600 ring-1 ring-black ring-opacity-5">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li><a href="#" data-period="yesterday" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Yesterday</a></li>
                        <li><a href="#" data-period="today" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Today</a></li>
                        <li><a href="#" data-period="last_7_days" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Last 7 days</a></li>
                        <li><a href="#" data-period="last_30_days" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Last 30 days</a></li>
                        <li><a href="#" data-period="last_90_days" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Last 90 days</a></li>
                        <li><a href="#" data-period="last_6_months" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Last 6 months</a></li>
                        <li><a href="#" data-period="last_year" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Last year</a></li>
                    </ul>
                </div>
                <a href="{{ route('admin.reports.sales') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 inline-flex items-center transition-colors">
                    Full Report
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Sales This week -->
        <!-- Sales This week -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h5 id="salesWeekTotal" class="text-3xl font-bold text-gray-900 dark:text-white">RM 0.00</h5>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">Sales Overview</p>
                </div>
                <div id="salesWeekChangeWrap" class="flex items-center px-2.5 py-1 rounded-full text-sm font-semibold bg-gray-50 dark:bg-gray-700/50">
                    <span id="salesWeekChange">0%</span>
                    <svg id="salesWeekChangeIcon" class="w-3 h-3 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                    </svg>
                </div>
            </div>
            
            <div id="data-series-chart" class="w-full"></div>
            
            <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100 dark:border-gray-700">
                <button id="salesWeekButton" data-dropdown-toggle="salesWeekDropdown" data-dropdown-placement="bottom" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white inline-flex items-center transition-colors" type="button">
                    This week
                    <svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <div id="salesWeekDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-lg w-44 dark:bg-gray-700 dark:divide-gray-600 ring-1 ring-black ring-opacity-5">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="salesWeekButton">
                        <li><a href="#" data-period="this_week" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">This week</a></li>
                        <li><a href="#" data-period="yesterday" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Yesterday</a></li>
                        <li><a href="#" data-period="today" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Today</a></li>
                        <li><a href="#" data-period="last_7_days" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Last 7 days</a></li>
                        <li><a href="#" data-period="last_30_days" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Last 30 days</a></li>
                        <li><a href="#" data-period="last_90_days" class="block px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">Last 90 days</a></li>
                    </ul>
                </div>
                <a href="{{ route('admin.reports.sales') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 inline-flex items-center transition-colors">
                    Full Report
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Low Stock Books Section -->
    <div class="mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Low Stock Books</h2>
                <a href="{{ route('admin.books.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Book</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @if(isset($lowStockBooks) && count($lowStockBooks) > 0)
                            @foreach($lowStockBooks as $book)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($book->cover_image)
                                                <div class="flex-shrink-0 h-10 w-8">
                                                    <img class="h-10 w-8 object-cover rounded shadow-sm" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                                </div>
                                            @else
                                                <div class="flex-shrink-0 h-10 w-8 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white line-clamp-1">{{ $book->title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $book->author }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            {{ $book->stock }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.books.edit', $book) }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-green-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p>No low stock books found</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- ApexCharts: Top Selling Books Bar Chart -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initial data from server-side rendering
            var categories = @json(isset($bestSellingBooks) ? $bestSellingBooks->pluck('title') : []);
            var dataSeries = @json(isset($bestSellingBooks) ? $bestSellingBooks->pluck('total_sold') : []);
            var unitPrices = @json(isset($bestSellingBooks) ? $bestSellingBooks->pluck('price') : []);
            
            var chart = null;
            var chartEl = document.getElementById('bar-chart');

            function renderChart() {
                if (!chartEl || typeof ApexCharts === 'undefined') return;
                
                // Handle empty data state
                if (categories.length === 0) {
                    chartEl.innerHTML = '<div class="flex flex-col items-center justify-center py-12 text-gray-400 dark:text-gray-500"><svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg><p class="text-sm font-medium">No sales data available for this period</p></div>';
                    return;
                } else {
                    // Clear any previous "No data" message
                    if (!chartEl.classList.contains('apexcharts-canvas')) {
                        chartEl.innerHTML = '';
                    }
                }
                
                var isDark = document.documentElement.classList.contains('dark');
                
                var options = {
                  series: [{
                    name: 'Sold',
                    data: dataSeries
                  }],
                  chart: {
                    type: 'bar',
                    height: 350,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: { enabled: true, delay: 150 },
                        dynamicAnimation: { enabled: true, speed: 350 }
                    }
                  },
                  plotOptions: {
                    bar: {
                      horizontal: true,
                      columnWidth: '60%',
                      borderRadius: 6,
                      borderRadiusApplication: 'end',
                      barHeight: '60%',
                      distributed: true
                    }
                  },
                  colors: [
                    '#7c3aed', '#ec4899', '#06b6d4', '#10b981', '#f59e0b', 
                    '#ef4444', '#8b5cf6', '#f472b6', '#22c55e', '#3b82f6',
                    '#84cc16', '#f97316', '#6366f1', '#14b8a6', '#e11d48'
                  ],
                  dataLabels: { enabled: false },
                  legend: { show: false },
                  grid: {
                    show: true,
                    borderColor: isDark ? '#374151' : '#f3f4f6',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } },
                    padding: { top: 0, right: 0, bottom: 0, left: 10 }
                  },
                  xaxis: {
                    categories: categories,
                    labels: {
                      style: {
                        colors: isDark ? '#9ca3af' : '#6b7280',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif'
                      }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                  },
                  yaxis: {
                    labels: {
                      style: {
                        colors: isDark ? '#9ca3af' : '#6b7280',
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif',
                        fontWeight: 500
                      },
                      maxWidth: 200
                    }
                  },
                  tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    y: {
                        formatter: function (val) { return val + " copies" }
                    },
                    custom: function({ series, seriesIndex, dataPointIndex, w }) {
                      var qty = series[seriesIndex][dataPointIndex] || 0;
                      var price = parseFloat((unitPrices && unitPrices[dataPointIndex]) ? unitPrices[dataPointIndex] : 0) || 0;
                      var total = (qty * price).toFixed(2);
                      var title = w.globals.labels[dataPointIndex] || '';
                      var color = w.globals.colors[dataPointIndex];
                      
                      return '<div class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg shadow-lg">'
                        + '<div class="font-semibold text-gray-900 dark:text-white mb-1 flex items-center">'
                        + '<span class="w-2 h-2 rounded-full mr-2" style="background-color:' + color + '"></span>'
                        + title + '</div>'
                        + '<div class="text-gray-600 dark:text-gray-300 text-xs">Quantity: <span class="font-medium text-gray-900 dark:text-white">' + qty + '</span></div>'
                        + '<div class="text-gray-600 dark:text-gray-300 text-xs">Total Sales: <span class="font-medium text-gray-900 dark:text-white">RM ' + total + '</span></div>'
                        + '</div>';
                    }
                  }
                };
                
                if (chart) { chart.destroy(); }
                chart = new ApexCharts(chartEl, options);
                chart.render();
            }

            function updateHeader(summary) {
                var totalSoldEl = document.getElementById('topBooksTotalSold');
                var topTitleEl = document.getElementById('topBooksTopTitle');
                
                if (summary) {
                    if (totalSoldEl) totalSoldEl.textContent = summary.total_sold || 0;
                    if (topTitleEl) {
                        topTitleEl.textContent = summary.top_title || '—';
                        topTitleEl.title = summary.top_title || '';
                    }
                } else {
                    // Fallback calculation if summary not provided
                    var totalSold = 0;
                    for (var i = 0; i < dataSeries.length; i++) { totalSold += (parseInt(dataSeries[i], 10) || 0); }
                    if (totalSoldEl) totalSoldEl.textContent = totalSold;
                    
                    if (topTitleEl && categories.length > 0) {
                        var maxIdx = 0;
                        for (var j = 1; j < dataSeries.length; j++) {
                            if ((dataSeries[j] || 0) > (dataSeries[maxIdx] || 0)) maxIdx = j;
                        }
                        topTitleEl.textContent = categories[maxIdx];
                        topTitleEl.title = categories[maxIdx];
                    } else if (topTitleEl) {
                        topTitleEl.textContent = '—';
                    }
                }
            }

            // Initial render
            updateHeader();
            renderChart();

            // Dropdown filtering
            var dropdown = document.getElementById('lastDaysdropdown');
            if (dropdown) {
                dropdown.addEventListener('click', function(e) {
                    var target = e.target.closest('a[data-period]');
                    if (!target) return;
                    e.preventDefault();
                    var period = target.getAttribute('data-period');
                    var label = target.textContent.trim();
                    
                    // Update button text
                    var btn = document.getElementById('dropdownDefaultButton');
                    if(btn) {
                        btn.innerHTML = label + '<svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>';
                    }
                    
                    // Update period badge if it exists
                    var periodBadge = document.getElementById('topBooksPeriodBadge');
                    if (periodBadge) {
                        periodBadge.innerHTML = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>' + label;
                    }

                    // Show loading state (optional)
                    if (chartEl) chartEl.style.opacity = '0.5';

                    fetch("{{ route('admin.top-selling') }}?period=" + encodeURIComponent(period), {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(function(res){ return res.json(); })
                    .then(function(json){
                        categories = json.titles || [];
                        dataSeries = (json.quantities || []).map(function(v){ return parseInt(v, 10) || 0; });
                        unitPrices = (json.prices || []).map(function(v){ return parseFloat(v) || 0; });
                        
                        updateHeader(json.summary);
                        renderChart();
                        
                        if (chartEl) chartEl.style.opacity = '1';
                    })
                    .catch(function(err){
                        console.error('Error fetching data:', err);
                        if (chartEl) {
                            chartEl.innerHTML = '<div class="text-center py-8 text-sm text-red-500">Failed to load data.</div>';
                            chartEl.style.opacity = '1';
                        }
                    });
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var salesChart = null;
            var el = document.getElementById('data-series-chart');

            function formatRM(n){ n = parseFloat(n||0); return 'RM ' + n.toFixed(2); }

            function renderSalesChart(labels, revenue, orders){
                if (!el || typeof ApexCharts === 'undefined') return;
                
                var isDark = document.documentElement.classList.contains('dark');
                
                if (salesChart) { salesChart.destroy(); }
                
                var options = {
                    series: [ { name: 'Revenue', data: revenue } ],
                    chart: { 
                        height: 280, 
                        type: 'area', 
                        fontFamily: 'Inter, sans-serif', 
                        toolbar: { show:false }, 
                        zoom: { enabled: false },
                        animations: { enabled: true }
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
                    dataLabels: { enabled: false },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    grid: {
                        show: true,
                        borderColor: isDark ? '#374151' : '#f3f4f6',
                        strokeDashArray: 4,
                        xaxis: { lines: { show: false } }, 
                        yaxis: { lines: { show: true } },
                        padding: { top: 0, right: 0, bottom: 0, left: 10 }
                    },
                    xaxis: {
                        categories: labels,
                        labels: { show: false },
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        tooltip: { enabled: false }
                    },
                    yaxis: {
                        show: true,
                        labels: {
                            formatter: function (value) {
                                return value >= 1000 ? (value / 1000).toFixed(1) + 'k' : value;
                            },
                            style: {
                                colors: isDark ? '#9ca3af' : '#6b7280',
                                fontSize: '11px',
                                fontFamily: 'Inter, sans-serif'
                            },
                            offsetX: -10
                        }
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        custom: function({series, seriesIndex, dataPointIndex, w}){
                            var date = labels[dataPointIndex] || '';
                            var rev = series[seriesIndex][dataPointIndex] || 0;
                            var ord = Array.isArray(orders) ? (orders[dataPointIndex]||0) : 0;
                            var aov = ord>0 ? (parseFloat(rev)/ord) : 0;
                            
                            return '<div class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg shadow-lg">'
                                + '<div class="font-semibold text-gray-900 dark:text-white mb-1">' + date + '</div>'
                                + '<div class="text-xs text-gray-600 dark:text-gray-300 flex justify-between items-center gap-4"><span>Revenue:</span> <span class="font-medium text-purple-600 dark:text-purple-400">' + formatRM(rev) + '</span></div>'
                                + '<div class="text-xs text-gray-600 dark:text-gray-300 flex justify-between items-center gap-4"><span>Orders:</span> <span class="font-medium text-gray-900 dark:text-white">' + ord + '</span></div>'
                                + '<div class="text-xs text-gray-600 dark:text-gray-300 flex justify-between items-center gap-4"><span>Avg Order:</span> <span class="font-medium text-gray-900 dark:text-white">' + formatRM(aov) + '</span></div>'
                                + '</div>';
                        }
                    }
                };
                salesChart = new ApexCharts(el, options);
                salesChart.render();
            }

            function setHeader(total, change){
                var totalEl = document.getElementById('salesWeekTotal');
                var changeEl = document.getElementById('salesWeekChange');
                var wrap = document.getElementById('salesWeekChangeWrap');
                var icon = document.getElementById('salesWeekChangeIcon');
                
                if (totalEl) totalEl.textContent = formatRM(total);
                if (changeEl) changeEl.textContent = Math.abs(change) + '%';
                
                if (wrap) {
                    wrap.className = 'flex items-center px-2.5 py-1 rounded-full text-sm font-semibold ' + 
                        (change >= 0 
                            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' 
                            : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300');
                }
                
                if (icon) { 
                    icon.style.transform = (change >= 0 ? 'rotate(0deg)' : 'rotate(180deg)'); 
                }
            }

            function loadSales(period, labelText){
                // Show loading state
                if (el) el.style.opacity = '0.5';

                fetch("{{ route('admin.sales-this-period') }}?period=" + encodeURIComponent(period), { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
                    .then(function(r){ return r.json(); })
                    .then(function(json){
                        setHeader(json.summary.total_revenue || 0, json.summary.change_percent || 0);
                        renderSalesChart(json.labels || [], json.revenue || [], json.orders || []);
                        
                        // Update button text
                        var btn = document.getElementById('salesWeekButton');
                        if (btn && labelText) {
                            btn.innerHTML = labelText + '<svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>';
                        }
                        
                        // Update section title
                        var titleEl = document.querySelector('#salesWeekTotal + p');
                        if (titleEl && labelText) {
                            titleEl.textContent = 'Sales ' + labelText.toLowerCase();
                        }
                        
                        if (el) el.style.opacity = '1';
                    })
                    .catch(function(err){
                        console.error('Error fetching sales data:', err);
                        if (el) el.style.opacity = '1';
                    });
            }

            // init
            loadSales('this_week', 'This week');

            var dd = document.getElementById('salesWeekDropdown');
            if (dd) {
                dd.addEventListener('click', function(e){
                    var a = e.target.closest('a[data-period]');
                    if (!a) return;
                    e.preventDefault();
                    var label = a.textContent.trim();
                    loadSales(a.getAttribute('data-period'), label);
                });
            }
        });
    </script>
@endsection
