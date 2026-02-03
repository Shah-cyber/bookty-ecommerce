@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
   
    <!-- Dashboard Skeleton Loader -->
    <div id="dashboard-skeleton" class="animate-pulse space-y-8">
        <!-- Skeleton: Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            @for ($i = 0; $i < 5; $i++)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between">
                        <div class="space-y-2">
                            <div class="h-3 w-20 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                            <div class="h-6 w-24 bg-gray-200 dark:bg-gray-700 rounded-md"></div>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-gray-200 dark:bg-gray-700"></div>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Skeleton: Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Orders Skeleton -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="h-4 w-32 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    <div class="h-3 w-16 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                </div>
                <div class="space-y-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center justify-between">
                            <div class="h-3 w-20 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                            <div class="h-3 w-24 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                            <div class="h-3 w-16 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Top Selling Books Skeleton -->
            <div class="w-full bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex justify-between items-start border-b border-gray-100 dark:border-gray-700 pb-4 mb-4">
                    <div class="space-y-2">
                        <div class="h-4 w-32 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                        <div class="h-3 w-40 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    </div>
                    <div class="h-6 w-20 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl space-y-2">
                        <div class="h-3 w-16 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                        <div class="h-4 w-24 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl space-y-2">
                        <div class="h-3 w-20 bg-gray-200 dark:bg-gray-700 rounded-full ml-auto"></div>
                        <div class="h-5 w-16 bg-gray-200 dark:bg-gray-700 rounded-full ml-auto"></div>
                    </div>
                </div>
                <div class="h-48 w-full bg-gray-100 dark:bg-gray-700 rounded-xl"></div>
            </div>

            <!-- Sales This Period Skeleton -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="space-y-2">
                        <div class="h-6 w-28 bg-gray-200 dark:bg-gray-700 rounded-md"></div>
                        <div class="h-3 w-32 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    </div>
                    <div class="h-6 w-24 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                </div>
                <div class="h-40 w-full bg-gray-100 dark:bg-gray-700 rounded-xl mb-4"></div>
                <div class="flex items-center justify-between">
                    <div class="h-4 w-24 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    <div class="h-4 w-16 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Skeleton: Low Stock Books -->
        <div class="mt-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="h-4 w-32 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    <div class="h-3 w-16 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                </div>
                <div class="space-y-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-8 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                <div class="h-3 w-32 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                            </div>
                            <div class="h-3 w-20 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                            <div class="h-3 w-12 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Real Dashboard Content -->
    <div id="dashboard-content" class="hidden">

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
        <!-- Recent Orders - Redesigned -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 dark:from-blue-600 dark:to-cyan-600 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Recent Orders</h2>
                            <p class="text-xs text-white/70">Latest 5 transactions</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-white/20 hover:bg-white/30 rounded-lg backdrop-blur-sm transition-colors">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Orders List -->
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @if(isset($recentOrders) && count($recentOrders) > 0)
                    @foreach($recentOrders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                            <!-- Avatar -->
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-cyan-400 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900 dark:text-white truncate">{{ $order->user->name }}</span>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $order->created_at->format('M d, Y') }} · {{ $order->created_at->format('h:i A') }}
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="flex-shrink-0">
                                @if($order->status === 'pending' || $order->status === 'processing')
                                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @elseif($order->status === 'shipped')
                                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                        Shipped
                                    </span>
                                @elseif($order->status === 'completed')
                                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Amount -->
                            <div class="flex-shrink-0 text-right">
                                <span class="font-semibold text-gray-900 dark:text-white">RM {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            
                            <!-- Arrow -->
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">No orders yet</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Orders will appear here once customers start purchasing.</p>
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            Go to Orders
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Best Selling Books - Redesigned -->
        <div class="w-full bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-violet-500 to-purple-600 dark:from-violet-600 dark:to-purple-700 p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-sm font-medium opacity-90">Top Selling Books</span>
                        </div>
                        <h3 id="topBooksTotalSold" class="text-3xl font-bold tracking-tight">0 <span class="text-lg font-normal opacity-80">copies</span></h3>
                    </div>
                    <div id="topBooksChangeBadge" class="flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm">
                        <svg id="topBooksChangeIcon" class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                        <span id="topBooksChangeText">0%</span>
                    </div>
                </div>
            </div>
            
            <!-- Stats Summary -->
            <div class="grid grid-cols-3 gap-4 p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
                <div class="text-center">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Top Book</p>
                    <p id="topBooksTopTitle" class="text-sm font-bold text-violet-600 dark:text-violet-400 truncate px-1" title="">—</p>
                </div>
                <div class="text-center border-x border-gray-200 dark:border-gray-600">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Total Titles</p>
                    <p id="topBooksTitlesCount" class="text-xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
                <div class="text-center">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Revenue</p>
                    <p id="topBooksRevenue" class="text-sm font-bold text-emerald-600 dark:text-emerald-400">RM 0</p>
                </div>
            </div>
            
            <!-- Chart -->
            <div class="p-6">
                <div id="bar-chart" class="w-full"></div>
            </div>
            
            <!-- Footer Controls -->
            <div class="flex items-center justify-between p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-700/20">
                <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown" data-dropdown-placement="bottom" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors" type="button">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span id="topBooksPeriodLabel">Last 6 months</span>
                    <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-lg w-48 dark:bg-gray-700 dark:divide-gray-600 ring-1 ring-black ring-opacity-5">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li><a href="#" data-period="today" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-blue-500 mr-3"></span>Today
                        </a></li>
                        <li><a href="#" data-period="yesterday" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-gray-400 mr-3"></span>Yesterday
                        </a></li>
                        <li><a href="#" data-period="last_7_days" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-3"></span>Last 7 days
                        </a></li>
                        <li><a href="#" data-period="last_30_days" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-orange-500 mr-3"></span>Last 30 days
                        </a></li>
                        <li><a href="#" data-period="last_90_days" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-pink-500 mr-3"></span>Last 90 days
                        </a></li>
                        <li><a href="#" data-period="last_6_months" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-violet-500 mr-3"></span>Last 6 months
                        </a></li>
                        <li><a href="#" data-period="last_year" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-red-500 mr-3"></span>Last year
                        </a></li>
                    </ul>
                </div>
                <a href="{{ route('admin.reports.sales') }}" class="inline-flex items-center text-sm font-medium text-violet-600 hover:text-violet-700 dark:text-violet-400 dark:hover:text-violet-300 transition-colors">
                    View Full Report
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Sales This Week - Redesigned -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 dark:from-emerald-600 dark:to-teal-700 p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium opacity-90">Sales Revenue</span>
                        </div>
                        <h3 id="salesWeekTotal" class="text-3xl font-bold tracking-tight">RM 0.00</h3>
                    </div>
                    <div id="salesWeekChangeWrap" class="flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm">
                        <span id="salesWeekChange">0%</span>
                        <svg id="salesWeekChangeIcon" class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Stats Summary -->
            <div class="grid grid-cols-3 gap-4 p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
                <div class="text-center">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Orders</p>
                    <p id="salesTotalOrders" class="text-xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
                <div class="text-center border-x border-gray-200 dark:border-gray-600">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Avg Order</p>
                    <p id="salesAvgOrder" class="text-xl font-bold text-gray-900 dark:text-white">RM 0</p>
                </div>
                <div class="text-center">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Peak Day</p>
                    <p id="salesPeakDay" class="text-xl font-bold text-emerald-600 dark:text-emerald-400">-</p>
                </div>
            </div>
            
            <!-- Chart -->
            <div class="p-6">
                <div id="data-series-chart" class="w-full"></div>
            </div>
            
            <!-- Footer Controls -->
            <div class="flex items-center justify-between p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-700/20">
                <button id="salesWeekButton" data-dropdown-toggle="salesWeekDropdown" data-dropdown-placement="bottom" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors" type="button">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span id="salesPeriodLabel">This week</span>
                    <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="salesWeekDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-lg w-48 dark:bg-gray-700 dark:divide-gray-600 ring-1 ring-black ring-opacity-5">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="salesWeekButton">
                        <li><a href="#" data-period="today" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-blue-500 mr-3"></span>Today
                        </a></li>
                        <li><a href="#" data-period="yesterday" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-gray-400 mr-3"></span>Yesterday
                        </a></li>
                        <li><a href="#" data-period="this_week" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-3"></span>This week
                        </a></li>
                        <li><a href="#" data-period="last_7_days" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-purple-500 mr-3"></span>Last 7 days
                        </a></li>
                        <li><a href="#" data-period="last_30_days" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-orange-500 mr-3"></span>Last 30 days
                        </a></li>
                        <li><a href="#" data-period="last_90_days" class="flex items-center px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <span class="w-2 h-2 rounded-full bg-red-500 mr-3"></span>Last 90 days
                        </a></li>
                    </ul>
                </div>
                <a href="{{ route('admin.reports.sales') }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                    View Full Report
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Low Stock Books Section - Redesigned -->
    <div class="mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header with Warning Gradient -->
            <div class="bg-gradient-to-r from-orange-500 to-red-500 dark:from-orange-600 dark:to-red-600 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Low Stock Alert</h2>
                            <p class="text-xs text-white/70">Books running low on inventory</p>
                        </div>
                    </div>
                    @if(isset($lowStockBooks) && count($lowStockBooks) > 0)
                        <span class="px-3 py-1.5 text-sm font-bold text-white bg-white/20 rounded-full backdrop-blur-sm">
                            {{ count($lowStockBooks) }} items
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Books List -->
            @if(isset($lowStockBooks) && count($lowStockBooks) > 0)
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($lowStockBooks as $book)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                            <div class="flex items-center gap-4">
                                <!-- Book Cover -->
                                <div class="flex-shrink-0">
                                    @if($book->cover_image)
                                        <img class="h-14 w-10 object-cover rounded-lg shadow-sm" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                    @else
                                        <div class="h-14 w-10 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Book Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 dark:text-white truncate">{{ $book->title }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $book->author }}</p>
                                </div>
                                
                                <!-- Stock Level -->
                                <div class="flex-shrink-0 flex items-center gap-3">
                                    <!-- Stock Badge with Visual Indicator -->
                                    <div class="flex items-center gap-2">
                                        @php
                                            $stockLevel = $book->stock;
                                            $urgency = $stockLevel <= 2 ? 'critical' : ($stockLevel <= 5 ? 'warning' : 'low');
                                        @endphp
                                        
                                        @if($urgency === 'critical')
                                            <div class="flex items-center gap-2 px-3 py-1.5 bg-red-50 dark:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-800">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                                </span>
                                                <span class="text-sm font-bold text-red-700 dark:text-red-300">{{ $stockLevel }}</span>
                                                <span class="text-xs text-red-600 dark:text-red-400">left</span>
                                            </div>
                                        @elseif($urgency === 'warning')
                                            <div class="flex items-center gap-2 px-3 py-1.5 bg-orange-50 dark:bg-orange-900/30 rounded-lg border border-orange-200 dark:border-orange-800">
                                                <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                                                <span class="text-sm font-bold text-orange-700 dark:text-orange-300">{{ $stockLevel }}</span>
                                                <span class="text-xs text-orange-600 dark:text-orange-400">left</span>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2 px-3 py-1.5 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                                <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                                                <span class="text-sm font-bold text-yellow-700 dark:text-yellow-300">{{ $stockLevel }}</span>
                                                <span class="text-xs text-yellow-600 dark:text-yellow-400">left</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Restock Button -->
                                    <a href="{{ route('admin.books.edit', $book) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-orange-700 dark:text-orange-300 bg-orange-100 dark:bg-orange-900/30 hover:bg-orange-200 dark:hover:bg-orange-900/50 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Restock
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Footer -->
                <div class="p-4 bg-gray-50/50 dark:bg-gray-700/20 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.books.index', ['stock' => 'low']) }}" class="inline-flex items-center text-sm font-medium text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 transition-colors">
                        View all low stock items
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            @else
                <!-- Empty State - All Good! -->
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">All stocked up!</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">All books have healthy stock levels.</p>
                    <a href="{{ route('admin.books.index') }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                        View inventory
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

    </div> <!-- /#dashboard-content -->

    <!-- Skeleton Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var skeleton = document.getElementById('dashboard-skeleton');
            var content = document.getElementById('dashboard-content');

            if (!skeleton || !content) return;

            // Small delay to show skeleton before revealing the real content
            setTimeout(function () {
                skeleton.classList.add('hidden');
                content.classList.remove('hidden');
            }, 500);
        });
    </script>
    
    <!-- ApexCharts: Top Selling Books Bar Chart -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initial data from server-side rendering
            var categories = @json(isset($bestSellingBooks) ? $bestSellingBooks->pluck('title') : []);
            var dataSeries = @json(isset($bestSellingBooks) ? $bestSellingBooks->pluck('total_sold') : []);
            var unitPrices = @json(isset($bestSellingBooks) ? $bestSellingBooks->pluck('price') : []);
            
            var chart = null;
            var chartEl = document.getElementById('bar-chart');

            // Vibrant color palette
            var colorPalette = [
                '#8b5cf6', '#ec4899', '#06b6d4', '#10b981', '#f59e0b', 
                '#ef4444', '#6366f1', '#14b8a6', '#f97316', '#84cc16'
            ];

            function renderChart() {
                if (!chartEl || typeof ApexCharts === 'undefined') return;
                
                // Handle empty data state
                if (categories.length === 0) {
                    chartEl.innerHTML = '<div class="flex flex-col items-center justify-center py-16 text-gray-400 dark:text-gray-500">'
                        + '<svg class="w-16 h-16 mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">'
                        + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'
                        + '</svg>'
                        + '<p class="text-sm font-medium">No books sold in this period</p>'
                        + '<p class="text-xs mt-1 opacity-70">Try selecting a different time range</p>'
                        + '</div>';
                    return;
                } else {
                    if (!chartEl.classList.contains('apexcharts-canvas')) {
                        chartEl.innerHTML = '';
                    }
                }
                
                var isDark = document.documentElement.classList.contains('dark');
                
                // Find max for highlighting
                var maxVal = Math.max(...dataSeries);
                var maxIdx = dataSeries.indexOf(maxVal);
                
                var options = {
                    series: [{
                        name: 'Copies Sold',
                        data: dataSeries
                    }],
                    chart: {
                        type: 'bar',
                        height: Math.max(280, categories.length * 45),
                        fontFamily: 'Inter, sans-serif',
                        toolbar: { show: false },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 600,
                            animateGradually: { enabled: true, delay: 80 }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 6,
                            borderRadiusApplication: 'end',
                            barHeight: '70%',
                            distributed: true,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    colors: colorPalette,
                    dataLabels: {
                        enabled: true,
                        textAnchor: 'start',
                        formatter: function(val, opts) {
                            var isBest = opts.dataPointIndex === maxIdx && maxVal > 0;
                            return isBest ? val + ' 🏆' : String(val);
                        },
                        offsetX: 8,
                        style: {
                            fontSize: '12px',
                            fontWeight: 700,
                            colors: [isDark ? '#f3f4f6' : '#1f2937']
                        },
                        background: {
                            enabled: false
                        },
                        dropShadow: { enabled: false }
                    },
                    legend: { show: false },
                    grid: {
                        show: true,
                        borderColor: isDark ? '#374151' : '#f3f4f6',
                        strokeDashArray: 4,
                        xaxis: { lines: { show: true } },
                        yaxis: { lines: { show: false } },
                        padding: { top: 0, right: 30, bottom: 0, left: 0 }
                    },
                    xaxis: {
                        categories: categories,
                        labels: {
                            style: {
                                colors: isDark ? '#9ca3af' : '#6b7280',
                                fontSize: '11px',
                                fontFamily: 'Inter, sans-serif'
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: isDark ? '#d1d5db' : '#4b5563',
                                fontSize: '12px',
                                fontFamily: 'Inter, sans-serif',
                                fontWeight: 500
                            },
                            maxWidth: 180,
                            formatter: function(val) {
                                // Truncate long titles
                                if (val && val.length > 25) {
                                    return val.substring(0, 22) + '...';
                                }
                                return val;
                            }
                        }
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        custom: function({ series, seriesIndex, dataPointIndex, w }) {
                            var qty = series[seriesIndex][dataPointIndex] || 0;
                            var price = parseFloat((unitPrices && unitPrices[dataPointIndex]) ? unitPrices[dataPointIndex] : 0) || 0;
                            var total = (qty * price).toFixed(2);
                            var title = w.globals.labels[dataPointIndex] || '';
                            var color = w.globals.colors[dataPointIndex];
                            var isBest = dataPointIndex === maxIdx;
                            var percent = maxVal > 0 ? Math.round((qty / maxVal) * 100) : 0;
                            
                            return '<div class="px-4 py-3 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-xl min-w-[200px]">'
                                + '<div class="flex items-start justify-between mb-2">'
                                + '<div class="flex items-center flex-1 mr-2">'
                                + '<span class="w-3 h-3 rounded-full mr-2 flex-shrink-0" style="background-color:' + color + '"></span>'
                                + '<span class="font-bold text-gray-900 dark:text-white text-sm line-clamp-2">' + title + '</span>'
                                + '</div>'
                                + (isBest ? '<span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300 whitespace-nowrap">Best Seller</span>' : '')
                                + '</div>'
                                + '<div class="space-y-1.5">'
                                + '<div class="flex justify-between items-center"><span class="text-xs text-gray-500 dark:text-gray-400">Copies Sold</span><span class="text-sm font-bold text-violet-600 dark:text-violet-400">' + qty + '</span></div>'
                                + '<div class="flex justify-between items-center"><span class="text-xs text-gray-500 dark:text-gray-400">Unit Price</span><span class="text-sm font-semibold text-gray-900 dark:text-white">RM ' + price.toFixed(2) + '</span></div>'
                                + '<div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-700 pt-1.5 mt-1.5"><span class="text-xs text-gray-500 dark:text-gray-400">Total Revenue</span><span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">RM ' + total + '</span></div>'
                                + '</div>'
                                + '</div>';
                        }
                    },
                    states: {
                        hover: {
                            filter: { type: 'darken', value: 0.1 }
                        }
                    }
                };
                
                if (chart) { chart.destroy(); }
                chart = new ApexCharts(chartEl, options);
                chart.render();
            }

            function updateStats(summary) {
                var totalSoldEl = document.getElementById('topBooksTotalSold');
                var topTitleEl = document.getElementById('topBooksTopTitle');
                var titlesCountEl = document.getElementById('topBooksTitlesCount');
                var revenueEl = document.getElementById('topBooksRevenue');
                var changeBadge = document.getElementById('topBooksChangeBadge');
                var changeText = document.getElementById('topBooksChangeText');
                var changeIcon = document.getElementById('topBooksChangeIcon');
                
                // Calculate totals
                var totalSold = 0;
                var totalRevenue = 0;
                for (var i = 0; i < dataSeries.length; i++) {
                    var qty = parseInt(dataSeries[i], 10) || 0;
                    var price = parseFloat(unitPrices[i]) || 0;
                    totalSold += qty;
                    totalRevenue += qty * price;
                }
                
                // Find top title
                var topTitle = '—';
                if (categories.length > 0) {
                    var maxIdx = 0;
                    for (var j = 1; j < dataSeries.length; j++) {
                        if ((dataSeries[j] || 0) > (dataSeries[maxIdx] || 0)) maxIdx = j;
                    }
                    topTitle = categories[maxIdx];
                }
                
                // Use summary if provided, otherwise use calculated values
                var changePercent = 0;
                if (summary) {
                    totalSold = summary.total_sold || totalSold;
                    topTitle = summary.top_title || topTitle;
                    changePercent = summary.change_percent || 0;
                }
                
                // Update DOM with animation
                if (totalSoldEl) {
                    totalSoldEl.innerHTML = totalSold + ' <span class="text-lg font-normal opacity-80">copies</span>';
                }
                if (topTitleEl) {
                    topTitleEl.textContent = topTitle.length > 30 ? topTitle.substring(0, 27) + '...' : topTitle;
                    topTitleEl.title = topTitle;
                }
                if (titlesCountEl) {
                    titlesCountEl.textContent = categories.length;
                }
                if (revenueEl) {
                    revenueEl.textContent = 'RM ' + (totalRevenue >= 1000 ? (totalRevenue/1000).toFixed(1) + 'k' : totalRevenue.toFixed(0));
                }
                
                // Update change badge
                if (changeBadge && changeText && changeIcon) {
                    var isIncrease = changePercent > 0;
                    var isDecrease = changePercent < 0;
                    var isNeutral = changePercent === 0;
                    
                    // Format the text
                    if (isIncrease) {
                        changeText.textContent = '+' + changePercent.toFixed(1) + '%';
                    } else if (isDecrease) {
                        changeText.textContent = changePercent.toFixed(1) + '%';
                    } else {
                        changeText.textContent = '0%';
                    }
                    
                    // Update badge styling and icon based on increase/decrease/neutral
                    if (isIncrease) {
                        // Green/positive - up arrow
                        changeBadge.className = 'flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm';
                        changeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>';
                        changeIcon.style.display = '';
                    } else if (isDecrease) {
                        // Red/negative - down arrow
                        changeBadge.className = 'flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-red-500/30 backdrop-blur-sm';
                        changeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>';
                        changeIcon.style.display = '';
                    } else {
                        // Neutral - no change, show minus/equal indicator
                        changeBadge.className = 'flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-white/10 backdrop-blur-sm opacity-70';
                        changeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>';
                        changeIcon.style.display = '';
                    }
                }
            }

            // Initial render with static data first
            updateStats();
            renderChart();
            
            // Then fetch real data with change percentage
            fetch("{{ route('admin.top-selling') }}?period=last_6_months", {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(res){ return res.json(); })
            .then(function(json){
                categories = json.titles || [];
                dataSeries = (json.quantities || []).map(function(v){ return parseInt(v, 10) || 0; });
                unitPrices = (json.prices || []).map(function(v){ return parseFloat(v) || 0; });
                updateStats(json.summary);
                renderChart();
            })
            .catch(function(err){
                console.error('Error fetching initial top-selling data:', err);
            });

            // Dropdown filtering
            var dropdown = document.getElementById('lastDaysdropdown');
            if (dropdown) {
                dropdown.addEventListener('click', function(e) {
                    var target = e.target.closest('a[data-period]');
                    if (!target) return;
                    e.preventDefault();
                    var period = target.getAttribute('data-period');
                    var label = target.textContent.trim();
                    
                    // Update period label in footer
                    var periodLabel = document.getElementById('topBooksPeriodLabel');
                    if (periodLabel) {
                        periodLabel.textContent = label;
                    }

                    // Show loading state
                    if (chartEl) {
                        chartEl.style.opacity = '0.5';
                        chartEl.style.pointerEvents = 'none';
                    }

                    fetch("{{ route('admin.top-selling') }}?period=" + encodeURIComponent(period), {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(function(res){ return res.json(); })
                    .then(function(json){
                        categories = json.titles || [];
                        dataSeries = (json.quantities || []).map(function(v){ return parseInt(v, 10) || 0; });
                        unitPrices = (json.prices || []).map(function(v){ return parseFloat(v) || 0; });
                        
                        updateStats(json.summary);
                        renderChart();
                        
                        if (chartEl) {
                            chartEl.style.opacity = '1';
                            chartEl.style.pointerEvents = 'auto';
                        }
                    })
                    .catch(function(err){
                        console.error('Error fetching data:', err);
                        if (chartEl) {
                            chartEl.innerHTML = '<div class="flex flex-col items-center justify-center py-12 text-red-400">'
                                + '<svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">'
                                + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
                                + '</svg>'
                                + '<p class="text-sm font-medium">Failed to load data</p>'
                                + '</div>';
                            chartEl.style.opacity = '1';
                            chartEl.style.pointerEvents = 'auto';
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
            var currentOrders = [];
            var currentLabels = [];

            function formatRM(n){ n = parseFloat(n||0); return 'RM ' + n.toFixed(2); }
            
            function formatCompact(n) {
                n = parseFloat(n||0);
                if (n >= 1000) return 'RM ' + (n / 1000).toFixed(1) + 'k';
                return 'RM ' + n.toFixed(0);
            }

            function renderSalesChart(labels, revenue, orders){
                if (!el || typeof ApexCharts === 'undefined') return;
                
                currentOrders = orders;
                currentLabels = labels;
                
                var isDark = document.documentElement.classList.contains('dark');
                
                // Find max value for highlighting
                var maxVal = Math.max(...revenue);
                var maxIdx = revenue.indexOf(maxVal);
                
                // Generate colors - highlight the best day
                var barColors = revenue.map(function(val, idx) {
                    if (idx === maxIdx && val > 0) return '#10b981'; // emerald for best day
                    return isDark ? '#6ee7b7' : '#34d399'; // lighter emerald for others
                });
                
                if (salesChart) { salesChart.destroy(); }
                
                // Handle empty data
                if (labels.length === 0 || revenue.every(function(v) { return v === 0; })) {
                    el.innerHTML = '<div class="flex flex-col items-center justify-center py-12 text-gray-400 dark:text-gray-500">'
                        + '<svg class="w-16 h-16 mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">'
                        + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'
                        + '</svg>'
                        + '<p class="text-sm font-medium">No sales data for this period</p>'
                        + '<p class="text-xs mt-1 opacity-70">Try selecting a different time range</p>'
                        + '</div>';
                    return;
                }
                
                // Calculate how many labels to skip for readability
                var labelCount = labels.length;
                var tickAmount = labelCount <= 7 ? labelCount : 
                                 labelCount <= 14 ? 7 : 
                                 labelCount <= 31 ? 6 : 
                                 labelCount <= 90 ? 8 : 10;
                
                var options = {
                    series: [{
                        name: 'Revenue',
                        data: revenue
                    }],
                    chart: { 
                        type: 'bar',
                        height: labelCount > 14 ? 280 : 240,
                        fontFamily: 'Inter, sans-serif', 
                        toolbar: { show: false }, 
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 600,
                            animateGradually: { enabled: true, delay: 100 }
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: labelCount > 30 ? 3 : 6,
                            borderRadiusApplication: 'end',
                            columnWidth: labelCount > 30 ? '95%' : labelCount > 14 ? '85%' : '60%',
                            distributed: true,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    colors: barColors,
                    dataLabels: {
                        enabled: labelCount <= 7,
                        formatter: function(val) {
                            if (val === 0) return '';
                            return val >= 1000 ? (val/1000).toFixed(1) + 'k' : val.toFixed(0);
                        },
                        offsetY: -20,
                        style: {
                            fontSize: '11px',
                            fontWeight: 600,
                            colors: [isDark ? '#9ca3af' : '#6b7280']
                        }
                    },
                    legend: { show: false },
                    grid: {
                        show: true,
                        borderColor: isDark ? '#374151' : '#f3f4f6',
                        strokeDashArray: 4,
                        xaxis: { lines: { show: false } },
                        yaxis: { lines: { show: true } },
                        padding: { top: 10, right: 10, bottom: 0, left: 10 }
                    },
                    xaxis: {
                        categories: labels,
                        tickAmount: tickAmount,
                        labels: {
                            rotate: 0,
                            rotateAlways: false,
                            hideOverlappingLabels: true,
                            showDuplicates: false,
                            trim: false,
                            style: {
                                colors: isDark ? '#9ca3af' : '#6b7280',
                                fontSize: '11px',
                                fontFamily: 'Inter, sans-serif',
                                fontWeight: 500
                            },
                            formatter: function(value, timestamp, opts) {
                                // For longer periods, show shorter format
                                if (labelCount > 14) {
                                    // Extract just the day number from "20 Dec" format
                                    var parts = value.split(' ');
                                    return parts[0]; // Just the day number
                                }
                                return value;
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        tooltip: { enabled: false }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                if (val >= 1000) return (val / 1000).toFixed(1) + 'k';
                                return val.toFixed(0);
                            },
                            style: {
                                colors: isDark ? '#9ca3af' : '#6b7280',
                                fontSize: '11px',
                                fontFamily: 'Inter, sans-serif'
                            }
                        }
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        custom: function({series, seriesIndex, dataPointIndex, w}){
                            var date = labels[dataPointIndex] || '';
                            var rev = series[seriesIndex][dataPointIndex] || 0;
                            var ord = Array.isArray(orders) ? (orders[dataPointIndex]||0) : 0;
                            var aov = ord > 0 ? (parseFloat(rev)/ord) : 0;
                            var isBest = dataPointIndex === maxIdx && rev > 0;
                            
                            return '<div class="px-4 py-3 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-xl min-w-[180px]">'
                                + '<div class="flex items-center justify-between mb-2">'
                                + '<span class="font-bold text-gray-900 dark:text-white">' + date + '</span>'
                                + (isBest ? '<span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">Best Day</span>' : '')
                                + '</div>'
                                + '<div class="space-y-1.5">'
                                + '<div class="flex justify-between items-center"><span class="text-xs text-gray-500 dark:text-gray-400">Revenue</span><span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">' + formatRM(rev) + '</span></div>'
                                + '<div class="flex justify-between items-center"><span class="text-xs text-gray-500 dark:text-gray-400">Orders</span><span class="text-sm font-semibold text-gray-900 dark:text-white">' + ord + '</span></div>'
                                + '<div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-700 pt-1.5 mt-1.5"><span class="text-xs text-gray-500 dark:text-gray-400">Avg Order</span><span class="text-sm font-semibold text-gray-900 dark:text-white">' + formatRM(aov) + '</span></div>'
                                + '</div>'
                                + '</div>';
                        }
                    },
                    states: {
                        hover: {
                            filter: { type: 'darken', value: 0.15 }
                        }
                    }
                };
                
                salesChart = new ApexCharts(el, options);
                salesChart.render();
            }

            function updateSummaryStats(revenue, orders, labels) {
                var totalOrders = orders.reduce(function(a, b) { return a + b; }, 0);
                var totalRev = revenue.reduce(function(a, b) { return a + b; }, 0);
                var avgOrder = totalOrders > 0 ? totalRev / totalOrders : 0;
                
                // Find peak day
                var maxRev = Math.max(...revenue);
                var maxIdx = revenue.indexOf(maxRev);
                var peakDay = maxRev > 0 && labels[maxIdx] ? labels[maxIdx] : '-';
                
                // Update DOM
                var totalOrdersEl = document.getElementById('salesTotalOrders');
                var avgOrderEl = document.getElementById('salesAvgOrder');
                var peakDayEl = document.getElementById('salesPeakDay');
                
                if (totalOrdersEl) animateNumber(totalOrdersEl, totalOrders, false);
                if (avgOrderEl) avgOrderEl.textContent = formatCompact(avgOrder);
                if (peakDayEl) peakDayEl.textContent = peakDay;
            }
            
            function animateNumber(el, target, isCurrency) {
                var current = parseInt(el.textContent.replace(/[^0-9]/g, '')) || 0;
                var increment = Math.ceil((target - current) / 20);
                var step = function() {
                    current += increment;
                    if ((increment > 0 && current >= target) || (increment < 0 && current <= target)) {
                        current = target;
                        el.textContent = isCurrency ? formatRM(current) : current;
                        return;
                    }
                    el.textContent = isCurrency ? formatRM(current) : current;
                    requestAnimationFrame(step);
                };
                if (current !== target) requestAnimationFrame(step);
                else el.textContent = isCurrency ? formatRM(target) : target;
            }

            function setHeader(total, change){
                var totalEl = document.getElementById('salesWeekTotal');
                var changeEl = document.getElementById('salesWeekChange');
                var wrap = document.getElementById('salesWeekChangeWrap');
                var icon = document.getElementById('salesWeekChangeIcon');
                
                var isIncrease = change > 0;
                var isDecrease = change < 0;
                var isNeutral = change === 0;
                
                if (totalEl) totalEl.textContent = formatRM(total);
                
                // Format percentage text
                if (changeEl) {
                    if (isIncrease) {
                        changeEl.textContent = '+' + change.toFixed(1) + '%';
                    } else if (isDecrease) {
                        changeEl.textContent = change.toFixed(1) + '%';
                    } else {
                        changeEl.textContent = '0%';
                    }
                }
                
                // Update badge styling
                if (wrap) {
                    if (isIncrease) {
                        wrap.className = 'flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-white/20 text-white';
                    } else if (isDecrease) {
                        wrap.className = 'flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-red-500/30 text-red-100';
                    } else {
                        wrap.className = 'flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-white/10 text-white/70';
                    }
                }
                
                // Update icon direction
                if (icon) {
                    if (isIncrease) {
                        // Up arrow
                        icon.style.transform = 'rotate(0deg)';
                        icon.style.display = '';
                    } else if (isDecrease) {
                        // Down arrow
                        icon.style.transform = 'rotate(180deg)';
                        icon.style.display = '';
                    } else {
                        // Neutral - hide arrow or show horizontal line
                        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>';
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
            }

            function loadSales(period, labelText){
                // Show loading state
                if (el) {
                    el.style.opacity = '0.5';
                    el.style.pointerEvents = 'none';
                }

                fetch("{{ route('admin.sales-this-period') }}?period=" + encodeURIComponent(period), { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
                    .then(function(r){ return r.json(); })
                    .then(function(json){
                        var labels = json.labels || [];
                        var revenue = json.revenue || [];
                        var orders = json.orders || [];
                        
                        setHeader(json.summary.total_revenue || 0, json.summary.change_percent || 0);
                        updateSummaryStats(revenue, orders, labels);
                        renderSalesChart(labels, revenue, orders);
                        
                        // Update period label
                        var periodLabel = document.getElementById('salesPeriodLabel');
                        if (periodLabel && labelText) {
                            periodLabel.textContent = labelText;
                        }
                        
                        if (el) {
                            el.style.opacity = '1';
                            el.style.pointerEvents = 'auto';
                        }
                    })
                    .catch(function(err){
                        console.error('Error fetching sales data:', err);
                        if (el) {
                            el.innerHTML = '<div class="flex flex-col items-center justify-center py-12 text-red-400">'
                                + '<svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">'
                                + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
                                + '</svg>'
                                + '<p class="text-sm font-medium">Failed to load sales data</p>'
                                + '</div>';
                            el.style.opacity = '1';
                            el.style.pointerEvents = 'auto';
                        }
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
