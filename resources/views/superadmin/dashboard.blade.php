@extends('layouts.superadmin')

@section('header', 'SuperAdmin Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-bookty-purple-600 to-bookty-pink-600 rounded-2xl p-8 text-white shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-purple-100 text-lg">Here's what's happening with your platform today.</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-32 h-32 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Admin Users Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
            <div class="bg-gradient-to-br from-bookty-purple-600 to-bookty-purple-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                </div>
                    <div class="text-white text-right">
                        <p class="text-purple-100 text-sm font-medium">Admin Users</p>
                        <p class="text-3xl font-bold counter" data-target="{{ $totalAdmins }}">0</p>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-gradient-to-r from-bookty-purple-50 to-purple-50">
                <div class="flex items-center text-bookty-purple-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span class="text-sm font-medium">System Administrators</span>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
            <div class="bg-gradient-to-br from-bookty-pink-600 to-pink-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-1a3 3 0 013.75-2.906z"></path>
                    </svg>
                </div>
                    <div class="text-white text-right">
                        <p class="text-pink-100 text-sm font-medium">Customers</p>
                        <p class="text-3xl font-bold counter" data-target="{{ $totalCustomers }}">0</p>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-gradient-to-r from-bookty-pink-50 to-pink-50">
                <div class="flex items-center text-bookty-pink-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Active Users</span>
                </div>
            </div>
        </div>

        <!-- Books Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                    </svg>
                </div>
                    <div class="text-white text-right">
                        <p class="text-indigo-100 text-sm font-medium">Books</p>
                        <p class="text-3xl font-bold counter" data-target="{{ $totalBooks }}">0</p>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-gradient-to-r from-indigo-50 to-blue-50">
                <div class="flex items-center text-indigo-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="text-sm font-medium">Total Catalog</span>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
            <div class="bg-gradient-to-br from-emerald-600 to-green-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                    <div class="text-white text-right">
                        <p class="text-emerald-100 text-sm font-medium">Total Revenue</p>
                        <p class="text-2xl font-bold">RM <span class="counter" data-target="{{ $totalRevenue }}">0</span></p>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-gradient-to-r from-emerald-50 to-green-50">
                <div class="flex items-center text-emerald-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <span class="text-sm font-medium">All Time Earnings</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Order Statistics -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">Order Statistics</h2>
                    <p class="text-gray-500">Real-time order status overview</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            
            <div class="space-y-4">
                <!-- Pending Orders -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
                        <span class="font-medium text-blue-800">Pending Orders</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-blue-600 counter" data-target="{{ $orderStats['pending'] }}">0</span>
                        <svg class="w-5 h-5 text-blue-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Processing Orders -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl border border-yellow-200 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="font-medium text-yellow-800">Processing</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-yellow-600 counter" data-target="{{ $orderStats['processing'] }}">0</span>
                        <svg class="w-5 h-5 text-yellow-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                </div>

                <!-- Shipped Orders -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-xl border border-indigo-200 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-indigo-500 rounded-full mr-3"></div>
                        <span class="font-medium text-indigo-800">Shipped</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-indigo-600 counter" data-target="{{ $orderStats['shipped'] }}">0</span>
                        <svg class="w-5 h-5 text-indigo-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="font-medium text-green-800">Completed</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-green-600 counter" data-target="{{ $orderStats['completed'] }}">0</span>
                        <svg class="w-5 h-5 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                </div>
                </div>

                <!-- Cancelled Orders -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-xl border border-red-200 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                        <span class="font-medium text-red-800">Cancelled</span>
                </div>
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-red-600 counter" data-target="{{ $orderStats['cancelled'] }}">0</span>
                        <svg class="w-5 h-5 text-red-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                </div>
                </div>
            </div>
        </div>

        <!-- User Registration Chart -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-bookty-purple-100 to-bookty-pink-100 rounded-full opacity-60"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-1">User Registrations</h2>
                        <p class="text-gray-500">Monthly growth in {{ date('Y') }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="p-3 bg-gradient-to-br from-bookty-purple-100 to-bookty-pink-100 rounded-xl">
                            <svg class="w-6 h-6 text-bookty-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="h-80 relative">
                    <canvas id="userRegistrationChart" class="w-full h-full"></canvas>
                </div>
                
                <div class="flex items-center justify-center mt-4 space-x-6">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-bookty-purple-600 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">New Users</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-gray-300 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600">Previous Year</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Debug Info (temporary) -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <h3 class="text-sm font-medium text-yellow-800 mb-2">🐛 Debug Info (Server Values)</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-yellow-600">Admins:</span> 
                <span class="font-mono">{{ $totalAdmins }}</span>
            </div>
            <div>
                <span class="text-yellow-600">Customers:</span> 
                <span class="font-mono">{{ $totalCustomers }}</span>
            </div>
            <div>
                <span class="text-yellow-600">Books:</span> 
                <span class="font-mono">{{ $totalBooks }}</span>
            </div>
            <div>
                <span class="text-yellow-600">Revenue:</span> 
                <span class="font-mono">{{ $totalRevenue }}</span>
            </div>
        </div>
        <div class="mt-2">
            <span class="text-yellow-600">Orders:</span>
            <span class="font-mono">{{ json_encode($orderStats) }}</span>
        </div>
        <div class="mt-3 flex flex-wrap gap-2">
            <button onclick="testAPI()" class="px-3 py-1 bg-yellow-600 text-white text-xs rounded hover:bg-yellow-700 transition-colors">
                🔍 Test API
            </button>
            <button onclick="updateCountersManually()" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                🔧 Fix Counters
            </button>
            <button onclick="forceDisplayValues()" class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors">
                ⚡ Force Values
            </button>
            <button onclick="animateCounters()" class="px-3 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                🎬 Animate
            </button>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">Recent Users</h2>
                    <p class="text-gray-500">Latest platform registrations</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-white rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-bookty-purple-600 hover:bg-bookty-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <span>View All</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="overflow-hidden">
            @if($recentUsers->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($recentUsers as $user)
                    <div class="px-8 py-6 hover:bg-gray-50 transition-colors duration-150 group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-bookty-purple-400 to-bookty-pink-400 rounded-full flex items-center justify-center text-white font-semibold text-lg shadow-md">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                
                                <!-- User Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-3 mb-1">
                                        <p class="text-lg font-semibold text-gray-900 group-hover:text-bookty-purple-600 transition-colors duration-150">
                                            {{ $user->name }}
                                        </p>
                            @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                                @if($role->name == 'superadmin') bg-gradient-to-r from-bookty-purple-100 to-purple-200 text-bookty-purple-800 border border-bookty-purple-200
                                                @elseif($role->name == 'admin') bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-200
                                                @else bg-gradient-to-r from-bookty-pink-100 to-pink-200 text-bookty-pink-800 border border-bookty-pink-200 @endif">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    @if($role->name == 'superadmin')
                                                        <path fill-rule="evenodd" d="M9.664 1.319a.75.75 0 01.672 0 41.059 41.059 0 018.198 5.424.75.75 0 01-.254 1.285 31.372 31.372 0 00-7.86 3.83.75.75 0 01-.84 0 31.508 31.508 0 00-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 013.305-2.033.75.75 0 00-.714-1.319 37 37 0 00-3.446 2.12A2.216 2.216 0 006 9.393v.38a31.293 31.293 0 00-4.28-1.746.75.75 0 01-.254-1.285 41.059 41.059 0 018.198-5.424zM6 11.459a29.848 29.848 0 00-2.455-1.158 41.029 41.029 0 00-.39 3.114.75.75 0 00.419.74c.528.256 1.046.53 1.554.82-.21-.899-.385-1.804-.528-2.716zM16 11.459c-.143.912-.318 1.817-.528 2.716.508-.29 1.026-.564 1.554-.82a.75.75 0 00.419-.74 41.029 41.029 0 00-.39-3.114 29.848 29.848 0 00-2.455 1.158z" clip-rule="evenodd"></path>
                                                    @elseif($role->name == 'admin')
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                                    @else
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    @endif
                                                </svg>
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                                    </div>
                                    <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            <!-- Join Date -->
                            <div class="flex items-center space-x-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="px-8 py-12 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500">No recent users found</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let chart; // Store chart instance
            let realtimeUpdateInterval;
            let chartUpdateInterval;
            let usersUpdateInterval;

            // Counter Animation
            function animateCounters() {
                const counters = document.querySelectorAll('.counter');
                const speed = 100; // Animation speed (lower = faster)

                console.log('Animating', counters.length, 'counter elements');
                
                counters.forEach((counter, index) => {
                    const target = +counter.getAttribute('data-target') || 0;
                    
                    console.log(`Animating Counter ${index}:`, {
                        target: target,
                        currentText: counter.innerText,
                        element: counter
                    });
                    
                    // Reset counter to 0 before animation
                    counter.innerText = '0';
                    
                    const updateCount = () => {
                        const count = +counter.innerText || 0;
                        const inc = Math.max(1, Math.ceil(target / speed));

                        if (count < target) {
                            const newCount = Math.min(target, count + inc);
                            counter.innerText = newCount.toLocaleString();
                            requestAnimationFrame(updateCount);
                        } else {
                            counter.innerText = target.toLocaleString();
                        }
                    };
                    
                    // Start animation
                    requestAnimationFrame(updateCount);
                });
            }

            // Update counter values without animation
            function updateCounterValue(element, newValue) {
                if (element) {
                    element.setAttribute('data-target', newValue);
                    element.innerText = newValue.toLocaleString();
                }
            }

            // Real-time stats update
            function updateRealtimeStats() {
                fetch('{{ route("superadmin.api.stats") }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Received stats data:', data);

                        // Get all counter elements by their current data-target values
                        const counters = document.querySelectorAll('.counter');
                        
                        if (counters.length === 0) {
                            console.warn('No counter elements found');
                            return;
                        }
                        
                        // Define target mapping for easier debugging and maintenance
                        const targetMapping = {
                            '{{ $totalAdmins }}': data.totalAdmins,
                            '{{ $totalCustomers }}': data.totalCustomers,
                            '{{ $totalBooks }}': data.totalBooks,
                            '{{ $totalRevenue }}': data.totalRevenue,
                            '{{ $orderStats['pending'] }}': data.orderStats.pending,
                            '{{ $orderStats['processing'] }}': data.orderStats.processing,
                            '{{ $orderStats['shipped'] }}': data.orderStats.shipped,
                            '{{ $orderStats['completed'] }}': data.orderStats.completed,
                            '{{ $orderStats['cancelled'] }}': data.orderStats.cancelled
                        };

                        console.log('Target mapping:', targetMapping);

                        counters.forEach(counter => {
                            const currentTarget = counter.getAttribute('data-target');
                            console.log('Processing counter with target:', currentTarget);
                            
                            if (targetMapping.hasOwnProperty(currentTarget)) {
                                const newValue = targetMapping[currentTarget];
                                console.log(`Updating counter from ${currentTarget} to ${newValue}`);
                                updateCounterValue(counter, newValue);
                            } else {
                                console.warn('No mapping found for target:', currentTarget);
                            }
                        });

                        // Update last updated time indicator
                        updateLastUpdatedTime();

                        console.log('Stats updated successfully at:', data.lastUpdated);
                    })
                    .catch(error => {
                        console.error('Error updating stats:', error);
                        showErrorNotification('Failed to update dashboard statistics');
                    });
            }

            // Update chart data
            function updateChartData() {
                fetch('{{ route("superadmin.api.user-registrations") }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Received chart data:', data);
                        if (chart && data.data) {
                            chart.updateSeries([{
                                name: 'New Users',
                                data: data.data
                            }]);
                            console.log('Chart updated successfully:', data.lastUpdated);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating chart:', error);
                        showErrorNotification('Failed to update user registration chart');
                    });
            }

            // Update recent users list
            function updateRecentUsers() {
                fetch('{{ route("superadmin.api.recent-users") }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Received users data:', data);
                        if (data.users) {
                            updateRecentUsersList(data.users);
                            console.log('Recent users updated successfully:', data.lastUpdated);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating recent users:', error);
                        showErrorNotification('Failed to update recent users list');
                    });
            }

            // Update recent users UI
            function updateRecentUsersList(users) {
                const container = document.querySelector('.divide-y.divide-gray-100');
                if (!container) return;

                container.innerHTML = '';
                
                if (users.length === 0) {
                    container.innerHTML = `
                        <div class="px-8 py-12 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500">No recent users found</p>
                        </div>
                    `;
                    return;
                }

                users.forEach(user => {
                    const rolesBadges = user.roles.map(role => {
                        let badgeClasses = '';
                        let iconPath = '';
                        
                        if (role === 'superadmin') {
                            badgeClasses = 'bg-gradient-to-r from-bookty-purple-100 to-purple-200 text-bookty-purple-800 border border-bookty-purple-200';
                            iconPath = 'M9.664 1.319a.75.75 0 01.672 0 41.059 41.059 0 018.198 5.424.75.75 0 01-.254 1.285 31.372 31.372 0 00-7.86 3.83.75.75 0 01-.84 0 31.508 31.508 0 00-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 013.305-2.033.75.75 0 00-.714-1.319 37 37 0 00-3.446 2.12A2.216 2.216 0 006 9.393v.38a31.293 31.293 0 00-4.28-1.746.75.75 0 01-.254-1.285 41.059 41.059 0 018.198-5.424zM6 11.459a29.848 29.848 0 00-2.455-1.158 41.029 41.029 0 00-.39 3.114.75.75 0 00.419.74c.528.256 1.046.53 1.554.82-.21-.899-.385-1.804-.528-2.716zM16 11.459c-.143.912-.318 1.817-.528 2.716.508-.29 1.026-.564 1.554-.82a.75.75 0 00.419-.74 41.029 41.029 0 00-.39-3.114 29.848 29.848 0 00-2.455 1.158z';
                        } else if (role === 'admin') {
                            badgeClasses = 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-200';
                            iconPath = 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z';
                        } else {
                            badgeClasses = 'bg-gradient-to-r from-bookty-pink-100 to-pink-200 text-bookty-pink-800 border border-bookty-pink-200';
                            iconPath = 'M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z';
                        }

                        return `
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full ${badgeClasses}">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="${iconPath}" clip-rule="evenodd"></path>
                                </svg>
                                ${role.charAt(0).toUpperCase() + role.slice(1)}
                            </span>
                        `;
                    }).join(' ');

                    const userHtml = `
                        <div class="px-8 py-6 hover:bg-gray-50 transition-colors duration-150 group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-bookty-purple-400 to-bookty-pink-400 rounded-full flex items-center justify-center text-white font-semibold text-lg shadow-md">
                                            ${user.avatar}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-3 mb-1">
                                            <p class="text-lg font-semibold text-gray-900 group-hover:text-bookty-purple-600 transition-colors duration-150">
                                                ${user.name}
                                            </p>
                                            ${rolesBadges}
                                        </div>
                                        <p class="text-sm text-gray-500 truncate">${user.email}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">${user.created_at_formatted}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', userHtml);
                });
            }

            // Add visual indicator for last update
            function updateLastUpdatedTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString();
                
                // Create or update last updated indicator
                let indicator = document.getElementById('last-updated-indicator');
                if (!indicator) {
                    indicator = document.createElement('div');
                    indicator.id = 'last-updated-indicator';
                    indicator.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 opacity-0 transition-opacity duration-300';
                    document.body.appendChild(indicator);
                }
                
                indicator.textContent = `✅ Updated: ${timeString}`;
                indicator.style.opacity = '1';
                
                setTimeout(() => {
                    indicator.style.opacity = '0';
                }, 3000);
            }

            // Show error notification
            function showErrorNotification(message) {
                let indicator = document.getElementById('error-indicator');
                if (!indicator) {
                    indicator = document.createElement('div');
                    indicator.id = 'error-indicator';
                    indicator.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 opacity-0 transition-opacity duration-300';
                    document.body.appendChild(indicator);
                }
                
                indicator.textContent = `❌ ${message}`;
                indicator.style.opacity = '1';
                
                setTimeout(() => {
                    indicator.style.opacity = '0';
                }, 5000);
            }

            // Real-time toggle functionality
            function createRealtimeToggle() {
                const toggleHtml = `
                    <div class="fixed bottom-4 left-4 bg-white rounded-lg shadow-lg border border-gray-200 p-4 z-40">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center">
                                <input type="checkbox" id="realtime-toggle" class="form-checkbox h-4 w-4 text-bookty-purple-600 rounded focus:ring-bookty-purple-500 border-gray-300">
                                <label for="realtime-toggle" class="ml-2 text-sm font-medium text-gray-700">Real-time Updates</label>
                            </div>
                            <div id="realtime-status" class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                <span class="text-xs text-gray-500">Stopped</span>
                            </div>
                        </div>
                        <div class="mt-2 flex space-x-2">
                            <button id="test-update-btn" class="px-3 py-1 bg-bookty-purple-600 text-white text-xs rounded hover:bg-bookty-purple-700 transition-colors">
                                Test Update
                            </button>
                            <button id="test-chart-btn" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                                Test Chart
                            </button>
                            <button id="test-users-btn" class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors">
                                Test Users
                            </button>
                        </div>
                    </div>
                `;
                
                document.body.insertAdjacentHTML('beforeend', toggleHtml);
                
                const toggle = document.getElementById('realtime-toggle');
                const status = document.getElementById('realtime-status');
                
                toggle.addEventListener('change', function() {
                    if (this.checked) {
                        startRealtimeUpdates();
                        status.innerHTML = '<div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div><span class="text-xs text-green-600">Active</span>';
                    } else {
                        stopRealtimeUpdates();
                        status.innerHTML = '<div class="w-2 h-2 bg-gray-400 rounded-full"></div><span class="text-xs text-gray-500">Stopped</span>';
                    }
                });

                // Add event listeners for test buttons
                document.getElementById('test-update-btn').addEventListener('click', function() {
                    console.log('Testing stats update...');
                    updateRealtimeStats();
                });

                document.getElementById('test-chart-btn').addEventListener('click', function() {
                    console.log('Testing chart update...');
                    updateChartData();
                });

                document.getElementById('test-users-btn').addEventListener('click', function() {
                    console.log('Testing users update...');
                    updateRecentUsers();
                });

                // Add a simple API test function
                window.testAPI = function() {
                    console.log('Testing API endpoints...');
                    
                    fetch('{{ route("superadmin.api.stats") }}')
                        .then(response => response.json())
                        .then(data => {
                            console.log('API Stats Response:', data);
                        })
                        .catch(error => {
                            console.error('API Stats Error:', error);
                        });
                };

                // Add window function for manual counter update
                window.updateCountersManually = function() {
                    console.log('🔧 Manual counter update triggered');
                    const counters = document.querySelectorAll('.counter');
                    console.log('Found counters for manual update:', counters.length);
                    
                    counters.forEach((counter, index) => {
                        const target = counter.getAttribute('data-target');
                        const formattedValue = target ? (+target).toLocaleString() : '0';
                        console.log(`Manually updating counter ${index}: target=${target} -> display=${formattedValue}`);
                        counter.innerText = formattedValue;
                    });
                    
                    console.log('✅ Manual counter update completed');
                };

                // Force display with server values (direct from debug panel)
                window.forceDisplayValues = function() {
                    console.log('⚡ Force display values triggered');
                    
                    // Direct server values from the debug panel
                    const serverValues = {
                        totalAdmins: {{ $totalAdmins }},
                        totalCustomers: {{ $totalCustomers }},
                        totalBooks: {{ $totalBooks }},
                        totalRevenue: {{ $totalRevenue }},
                        orderStats: @json($orderStats)
                    };
                    
                    console.log('Server values:', serverValues);
                    
                    // Find all counters and map them to server values
                    const counterMappings = [
                        { selector: '.counter[data-target="{{ $totalAdmins }}"]', value: serverValues.totalAdmins },
                        { selector: '.counter[data-target="{{ $totalCustomers }}"]', value: serverValues.totalCustomers },
                        { selector: '.counter[data-target="{{ $totalBooks }}"]', value: serverValues.totalBooks },
                        { selector: '.counter[data-target="{{ $totalRevenue }}"]', value: serverValues.totalRevenue },
                        { selector: '.counter[data-target="{{ $orderStats['pending'] }}"]', value: serverValues.orderStats.pending },
                        { selector: '.counter[data-target="{{ $orderStats['processing'] }}"]', value: serverValues.orderStats.processing },
                        { selector: '.counter[data-target="{{ $orderStats['shipped'] }}"]', value: serverValues.orderStats.shipped },
                        { selector: '.counter[data-target="{{ $orderStats['completed'] }}"]', value: serverValues.orderStats.completed },
                        { selector: '.counter[data-target="{{ $orderStats['cancelled'] }}"]', value: serverValues.orderStats.cancelled }
                    ];
                    
                    counterMappings.forEach((mapping, index) => {
                        const element = document.querySelector(mapping.selector);
                        if (element && mapping.value !== undefined) {
                            element.innerText = (+mapping.value).toLocaleString();
                            console.log(`Set counter ${index}: ${mapping.selector} = ${mapping.value}`);
                        } else {
                            console.warn(`Counter not found or value undefined: ${mapping.selector}`, mapping.value);
                        }
                    });
                    
                    console.log('✅ Force display completed');
                };
            }

            // Start real-time updates
            function startRealtimeUpdates() {
                // Update stats every 30 seconds
                realtimeUpdateInterval = setInterval(updateRealtimeStats, 30000);
                
                // Update chart every 2 minutes
                chartUpdateInterval = setInterval(updateChartData, 120000);
                
                // Update users every 1 minute
                usersUpdateInterval = setInterval(updateRecentUsers, 60000);
            }

            // Stop real-time updates
            function stopRealtimeUpdates() {
                if (realtimeUpdateInterval) clearInterval(realtimeUpdateInterval);
                if (chartUpdateInterval) clearInterval(chartUpdateInterval);
                if (usersUpdateInterval) clearInterval(usersUpdateInterval);
            }

            // Debug: Log initial values
            console.log('Initial values from server:');
            console.log('Total Admins:', {{ $totalAdmins }});
            console.log('Total Customers:', {{ $totalCustomers }});
            console.log('Total Books:', {{ $totalBooks }});
            console.log('Total Revenue:', {{ $totalRevenue }});
            console.log('Order Stats:', @json($orderStats));

            // Function to ensure counters display values (fallback)
            function ensureCountersDisplay() {
                const counters = document.querySelectorAll('.counter');
                console.log('Ensuring counters display values:', counters.length);
                
                counters.forEach((counter, index) => {
                    const target = counter.getAttribute('data-target');
                    console.log(`Counter ${index}: target=${target}, current text="${counter.innerText}"`);
                    
                    // If counter is still showing 0 or empty, set the target value immediately
                    if (target && (counter.innerText === '0' || counter.innerText === '' || !counter.innerText)) {
                        counter.innerText = (+target).toLocaleString();
                        console.log(`Fixed counter ${index} to show: ${counter.innerText}`);
                    }
                });
            }

            // Set initial values and animate
            ensureCountersDisplay();
            
            // Start counter animation
            setTimeout(() => {
                animateCounters();
                
                // Fallback: ensure values are shown after animation
                setTimeout(ensureCountersDisplay, 3000);
            }, 100);

            // ApexCharts Configuration
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const registrationData = Array(12).fill(0);
            
            @foreach($userRegistrations as $data)
                registrationData[{{ $data->month - 1 }}] = {{ $data->count }};
            @endforeach
            
            const chartOptions = {
                series: [{
                    name: 'New Users',
                    data: registrationData
                }],
                chart: {
                type: 'bar',
                    height: 320,
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                colors: ['#9061F9'],
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '60%',
                        distributed: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: months,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Users'
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.25,
                        gradientToColors: ['#7C3AED'],
                        inverseColors: false,
                        opacityFrom: 0.8,
                        opacityTo: 0.1,
                        stops: [0, 100]
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " new users"
                        }
                    },
                    theme: 'dark'
                },
                grid: {
                    borderColor: 'rgba(107, 114, 128, 0.1)',
                    strokeDashArray: 5
                }
            };

            chart = new ApexCharts(document.querySelector("#userRegistrationChart"), chartOptions);
            chart.render();

            // Add hover effects to cards
            const cards = document.querySelectorAll('.group');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px) scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Initialize real-time controls
            createRealtimeToggle();

            // Add loading state
            const chartContainer = document.getElementById('userRegistrationChart').parentElement;
            chartContainer.classList.add('relative');
            
            // Remove loading state after chart is ready
            setTimeout(() => {
                const loadingEl = chartContainer.querySelector('.loading');
                if (loadingEl) {
                    loadingEl.remove();
                }
            }, 2500);

            // Clean up intervals when leaving the page
            window.addEventListener('beforeunload', function() {
                stopRealtimeUpdates();
            });

            // Add keyboard shortcut to toggle real-time updates (Ctrl+R)
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'r') {
                    e.preventDefault();
                    const toggle = document.getElementById('realtime-toggle');
                    if (toggle) {
                        toggle.checked = !toggle.checked;
                        toggle.dispatchEvent(new Event('change'));
                    }
                }
            });

            console.log('🚀 SuperAdmin Dashboard initialized with real-time capabilities!');
            console.log('💡 Press Ctrl+R to toggle real-time updates');
        });
    </script>
    @endpush
@endsection
