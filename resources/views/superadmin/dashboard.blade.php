@extends('layouts.superadmin')

@section('header', 'SuperAdmin Dashboard')

@section('content')
    <!-- SuperAdmin Dashboard Skeleton Loader -->
    <div id="superadmin-dashboard-skeleton" class="animate-pulse space-y-8">
      

        <!-- Skeleton: Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-4 bg-gradient-to-br from-gray-200 to-gray-300">
                        <div class="flex items-center justify-between">
                            <div class="p-3 bg-white/40 rounded-xl">
                                <div class="w-8 h-8 bg-gray-200 rounded-lg"></div>
                            </div>
                            <div class="text-right space-y-2">
                                <div class="h-3 w-20 bg-white/70 rounded-full"></div>
                                <div class="h-6 w-16 bg-white/90 rounded-md"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50">
                        <div class="h-3 w-32 bg-gray-200 rounded-full"></div>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Skeleton: Order & Registrations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Order Statistics Skeleton -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="space-y-2">
                        <div class="h-4 w-40 bg-gray-200 rounded-full"></div>
                        <div class="h-3 w-48 bg-gray-200 rounded-full"></div>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <div class="w-6 h-6 bg-blue-100 rounded-lg"></div>
                    </div>
                </div>
                <div class="space-y-4">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                <div class="h-3 w-28 bg-gray-200 rounded-full"></div>
                            </div>
                            <div class="h-5 w-10 bg-gray-200 rounded-md"></div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- User Registration Chart Skeleton -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full opacity-60"></div>
                <div class="relative space-y-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="space-y-2">
                            <div class="h-4 w-40 bg-gray-200 rounded-full"></div>
                            <div class="h-3 w-48 bg-gray-200 rounded-full"></div>
                        </div>
                        <div class="p-3 bg-gray-100 rounded-xl">
                            <div class="w-6 h-6 bg-gray-200 rounded-lg"></div>
                        </div>
                    </div>
                    <div class="h-80 w-full bg-gray-50 rounded-xl"></div>
                </div>
            </div>
        </div>

        <!-- Skeleton: Recent Users -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="space-y-2">
                        <div class="h-4 w-40 bg-gray-200 rounded-full"></div>
                        <div class="h-3 w-48 bg-gray-200 rounded-full"></div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white rounded-lg shadow-sm">
                            <div class="w-5 h-5 bg-gray-200 rounded-md"></div>
                        </div>
                        <div class="h-8 w-24 bg-bookty-purple-200 rounded-lg"></div>
                    </div>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @for ($i = 0; $i < 4; $i++)
                    <div class="px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full"></div>
                                <div class="space-y-2">
                                    <div class="h-4 w-32 bg-gray-200 rounded-full"></div>
                                    <div class="h-3 w-40 bg-gray-200 rounded-full"></div>
                                </div>
                            </div>
                            <div class="h-3 w-24 bg-gray-200 rounded-full"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Real SuperAdmin Dashboard Content -->
    <div id="superadmin-dashboard-content" class="hidden">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Admin Users -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Admin Users</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalAdmins ?? 0 }}</h4>
                </div>
                <div class="p-3 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
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

        <!-- Total Revenue -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">RM {{ number_format($totalRevenue ?? 0, 2) }}</h4>
                </div>
                <div class="p-3 rounded-xl bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Order Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Order Statistics</h2>
            </div>
            
            <div class="space-y-3">
                <!-- Pending Orders -->
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Pending</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $orderStats['pending'] ?? 0 }}</span>
                </div>

                <!-- Processing Orders -->
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Processing</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $orderStats['processing'] ?? 0 }}</span>
                </div>

                <!-- Shipped Orders -->
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Shipped</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $orderStats['shipped'] ?? 0 }}</span>
                </div>

                <!-- Completed Orders -->
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Completed</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $orderStats['completed'] ?? 0 }}</span>
                </div>

                <!-- Cancelled Orders -->
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Cancelled</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $orderStats['cancelled'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- User Registration Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">User Registrations</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monthly growth in {{ date('Y') }}</p>
                </div>
                <div class="p-3 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <!-- Chart Summary Stats -->
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-3 text-center">
                    <p class="text-xs font-medium text-purple-600 dark:text-purple-400 uppercase tracking-wide">Total</p>
                    <p id="chart-total" class="text-xl font-bold text-purple-700 dark:text-purple-300 mt-1">0</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3 text-center">
                    <p class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wide">Average</p>
                    <p id="chart-avg" class="text-xl font-bold text-blue-700 dark:text-blue-300 mt-1">0</p>
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-3 text-center">
                    <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 uppercase tracking-wide">Peak</p>
                    <p id="chart-peak" class="text-xl font-bold text-emerald-700 dark:text-emerald-300 mt-1">0</p>
                </div>
            </div>
            
            <div class="h-72 relative" id="userRegistrationChart">
                <!-- Chart renders here -->
            </div>
            
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">New Users</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-purple-700 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Current Month</span>
                    </div>
                </div>
                <button onclick="refreshChart()" class="text-xs text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 font-medium flex items-center gap-1 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Users</h2>
            <a href="{{ route('admin.customers.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors">View all</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @if($recentUsers->count() > 0)
                        @foreach($recentUsers as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                            <span class="text-sm font-medium text-purple-700 dark:text-purple-300">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($role->name == 'superadmin') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                                            @elseif($role->name == 'admin') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p>No recent users found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    </div> <!-- /#superadmin-dashboard-content -->

    <!-- Skeleton Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var skeleton = document.getElementById('superadmin-dashboard-skeleton');
            var content = document.getElementById('superadmin-dashboard-content');

            if (!skeleton || !content) return;

            setTimeout(function () {
                skeleton.classList.add('hidden');
                content.classList.remove('hidden');
            }, 500);
        });
    </script>

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

            // Update chart summary stats
            function updateChartSummary(total, avg, peak) {
                const totalEl = document.getElementById('chart-total');
                const avgEl = document.getElementById('chart-avg');
                const peakEl = document.getElementById('chart-peak');
                
                if (totalEl) {
                    animateNumber(totalEl, total);
                }
                if (avgEl) {
                    animateNumber(avgEl, avg);
                }
                if (peakEl) {
                    animateNumber(peakEl, peak);
                }
            }

            // Animate number change
            function animateNumber(element, target) {
                const current = parseInt(element.textContent) || 0;
                const diff = target - current;
                const duration = 500;
                const steps = 20;
                const stepTime = duration / steps;
                const stepValue = diff / steps;
                let step = 0;
                
                const animation = setInterval(() => {
                    step++;
                    const newValue = Math.round(current + (stepValue * step));
                    element.textContent = newValue.toLocaleString();
                    
                    if (step >= steps) {
                        clearInterval(animation);
                        element.textContent = target.toLocaleString();
                    }
                }, stepTime);
            }

            // Refresh chart function (called by refresh button)
            window.refreshChart = function() {
                const refreshBtn = document.querySelector('button[onclick="refreshChart()"]');
                if (refreshBtn) {
                    refreshBtn.innerHTML = `
                        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Loading...
                    `;
                }
                
                updateChartData();
                
                setTimeout(() => {
                    if (refreshBtn) {
                        refreshBtn.innerHTML = `
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Refresh
                        `;
                    }
                }, 1000);
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
                            
                            // Update summary stats
                            const total = data.data.reduce((a, b) => a + b, 0);
                            const avg = Math.round(total / 12);
                            const peak = Math.max(...data.data);
                            updateChartSummary(total, avg, peak);
                            
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

            // ApexCharts Bar Chart Configuration
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const registrationData = Array(12).fill(0);
            
            @foreach($userRegistrations as $data)
                registrationData[{{ $data->month - 1 }}] = {{ $data->count }};
            @endforeach

            // Calculate total and average for summary
            const totalUsers = registrationData.reduce((a, b) => a + b, 0);
            const avgUsers = Math.round(totalUsers / 12);
            const maxUsers = Math.max(...registrationData);
            const currentMonth = new Date().getMonth();
            
            const chartOptions = {
                series: [{
                    name: 'New Users',
                    data: registrationData
                }],
                chart: {
                    type: 'bar',
                    height: 320,
                    fontFamily: 'Inter, system-ui, sans-serif',
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 50
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    },
                    dropShadow: {
                        enabled: true,
                        top: 2,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                    }
                },
                colors: registrationData.map((val, index) => {
                    // Highlight current month with different color
                    if (index === currentMonth) return '#7C3AED';
                    return '#9061F9';
                }),
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 6,
                        borderRadiusApplication: 'end',
                        columnWidth: '55%',
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val > 0 ? val : '';
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '11px',
                        fontWeight: 600,
                        colors: ['#6B7280']
                    }
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
                    },
                    labels: {
                        style: {
                            colors: '#6B7280',
                            fontSize: '12px',
                            fontWeight: 500
                        }
                    },
                    crosshairs: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Users',
                        style: {
                            color: '#6B7280',
                            fontSize: '12px',
                            fontWeight: 600
                        }
                    },
                    labels: {
                        style: {
                            colors: '#6B7280',
                            fontSize: '12px'
                        },
                        formatter: function(val) {
                            return Math.round(val);
                        }
                    },
                    min: 0,
                    forceNiceScale: true
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.3,
                        gradientToColors: registrationData.map((val, index) => {
                            if (index === currentMonth) return '#5B21B6';
                            return '#7C3AED';
                        }),
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 0.85,
                        stops: [0, 100]
                    }
                },
                tooltip: {
                    enabled: true,
                    shared: false,
                    intersect: true,
                    custom: function({ series, seriesIndex, dataPointIndex, w }) {
                        const value = series[seriesIndex][dataPointIndex];
                        const month = months[dataPointIndex];
                        const isCurrentMonth = dataPointIndex === currentMonth;
                        const percentOfMax = maxUsers > 0 ? Math.round((value / maxUsers) * 100) : 0;
                        
                        return `
                            <div class="bg-gray-900 text-white px-4 py-3 rounded-lg shadow-xl border border-gray-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-3 h-3 rounded-full ${isCurrentMonth ? 'bg-purple-500' : 'bg-purple-400'}"></div>
                                    <span class="font-semibold">${month} ${new Date().getFullYear()}</span>
                                    ${isCurrentMonth ? '<span class="text-xs bg-purple-500 px-2 py-0.5 rounded-full">Current</span>' : ''}
                                </div>
                                <div class="text-2xl font-bold text-purple-400">${value}</div>
                                <div class="text-xs text-gray-400 mt-1">new user${value !== 1 ? 's' : ''} registered</div>
                                <div class="mt-2 pt-2 border-t border-gray-700">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-400">vs. Peak:</span>
                                        <span class="font-medium">${percentOfMax}%</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                },
                legend: {
                    show: false
                },
                grid: {
                    borderColor: 'rgba(107, 114, 128, 0.1)',
                    strokeDashArray: 4,
                    padding: {
                        top: 10,
                        right: 10,
                        bottom: 0,
                        left: 10
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'darken',
                            value: 0.9
                        }
                    },
                    active: {
                        filter: {
                            type: 'darken',
                            value: 0.8
                        }
                    }
                },
                responsive: [{
                    breakpoint: 640,
                    options: {
                        chart: {
                            height: 280
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '70%'
                            }
                        },
                        dataLabels: {
                            enabled: false
                        }
                    }
                }]
            };

            chart = new ApexCharts(document.querySelector("#userRegistrationChart"), chartOptions);
            chart.render();

            // Update chart summary stats
            updateChartSummary(totalUsers, avgUsers, maxUsers);

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
