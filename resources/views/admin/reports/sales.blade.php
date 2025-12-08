@extends('layouts.admin')

@section('header', 'Sales Reports')

@section('content')
    <div class="space-y-8">
        <!-- Summary Cards -->
        @php
            $totalRevenue = ($revenueData ?? collect())->sum('revenue') ?? 0;
            $totalOrders = ($revenueData ?? collect())->sum('orders_count') ?? 0;
            $avgOrderValue = $totalOrders > 0 ? ($totalRevenue / $totalOrders) : 0;
            $topGenre = ($salesByGenre ?? collect())->first();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Revenue Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center group-hover:bg-purple-100 dark:group-hover:bg-purple-900/40 transition-colors">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/20 px-2.5 py-1 rounded-full">Revenue</span>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">RM {{ number_format($totalRevenue, 2) }}</h3>
                    <p class="text-gray-400 text-xs mt-2 flex items-center">
                        <span class="text-green-500 flex items-center mr-1">
                            <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            {{ $totalOrders }}
                        </span>
                        orders this period
                    </p>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 transition-colors">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2.5 py-1 rounded-full">Orders</span>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Orders</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalOrders) }}</h3>
                    <p class="text-gray-400 text-xs mt-2">Completed transactions</p>
                </div>
            </div>

            <!-- Average Order Value Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/40 transition-colors">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2.5 py-1 rounded-full">AOV</span>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Avg Order Value</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">RM {{ number_format($avgOrderValue, 2) }}</h3>
                    <p class="text-gray-400 text-xs mt-2">Per transaction average</p>
                </div>
            </div>

            <!-- Top Genre Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-pink-50 dark:bg-pink-900/20 rounded-xl flex items-center justify-center group-hover:bg-pink-100 dark:group-hover:bg-pink-900/40 transition-colors">
                        <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-pink-600 dark:text-pink-400 bg-pink-50 dark:bg-pink-900/20 px-2.5 py-1 rounded-full">Top Genre</span>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Best Performing</p>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-1 truncate" title="{{ $topGenre->name ?? 'N/A' }}">{{ $topGenre->name ?? 'N/A' }}</h3>
                    <p class="text-gray-400 text-xs mt-2">RM {{ number_format($topGenre->total_revenue ?? 0, 2) }} revenue</p>
                </div>
            </div>
        </div>

        <!-- Enhanced Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter Reports
                    </h3>
                </div>
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wide">Period</label>
                        <select name="period" class="w-full bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                            <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wide">Start Date</label>
                        <input type="date" name="start_date" value="{{ is_string($startDate) ? substr($startDate, 0, 10) : ($startDate ? $startDate->format('Y-m-d') : '') }}" class="w-full bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wide">End Date</label>
                        <input type="date" name="end_date" value="{{ is_string($endDate) ? substr($endDate, 0, 10) : ($endDate ? $endDate->format('Y-m-d') : '') }}" class="w-full bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gray-900 dark:bg-blue-600 text-white px-6 py-2.5 rounded-xl hover:bg-gray-800 dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-gray-900/20 focus:ring-offset-2 transition-all duration-200 font-medium text-sm shadow-lg shadow-gray-900/10 flex items-center justify-center">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Revenue Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Revenue Over Time</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Track your sales performance trends</p>
                    </div>
                </div>
                <a href="{{ route('admin.reports.export.sales', ['type' => 'bestsellers', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 dark:focus:ring-gray-700 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Excel
                </a>
            </div>
            <div class="p-6">
                <div id="revenue-line-chart" class="w-full" style="height: 400px;"></div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var revCategories = @json(($revenueData ?? collect())->pluck('period'));
                    var revSeries = @json(($revenueData ?? collect())->pluck('revenue'));
                    var revOrders = @json(($revenueData ?? collect())->pluck('orders_count'));

                    // Fallback if no data
                    if (!Array.isArray(revCategories) || revCategories.length === 0) {
                        var container = document.getElementById('revenue-line-chart');
                        if (container) {
                            container.innerHTML = '<div class="h-96 bg-gray-50 dark:bg-gray-800/50 rounded-xl flex flex-col items-center justify-center text-sm text-gray-500 dark:text-gray-400 border-2 border-dashed border-gray-200 dark:border-gray-700"><div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4"><svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div><p class="font-medium">No revenue data found for this period.</p><p class="text-xs mt-1 text-gray-400">Try adjusting the date range.</p></div>';
                        }
                        return;
                    }

                    function formatCurrencyShort(val) {
                        var n = parseFloat(val || 0);
                        if (n >= 1_000_000) return 'RM ' + (n / 1_000_000).toFixed(1) + 'M';
                        if (n >= 1_000) return 'RM ' + (n / 1_000).toFixed(1) + 'K';
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

                    var options = {
                        chart: {
                            height: 400,
                            type: 'area', // Changed to area for better visual
                            toolbar: { show: false },
                            fontFamily: 'Inter, sans-serif',
                            zoom: { enabled: false },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800
                            }
                        },
                        colors: ['#8b5cf6'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0.05,
                                stops: [0, 90, 100]
                            }
                        },
                        stroke: {
                            width: 3,
                            curve: 'smooth',
                            lineCap: 'round'
                        },
                        dataLabels: { enabled: false },
                        grid: {
                            show: true,
                            borderColor: '#f3f4f6',
                            strokeDashArray: 4,
                            padding: { left: 20, right: 20, top: 20, bottom: 20 },
                            xaxis: { lines: { show: false } }
                        },
                        series: [{
                            name: 'Revenue',
                            data: revSeries
                        }],
                        xaxis: {
                            categories: displayCategories,
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: {
                                style: { fontFamily: 'Inter, sans-serif', fontSize: '12px', colors: '#9ca3af' },
                                offsetY: 5
                            },
                            tooltip: { enabled: false }
                        },
                        yaxis: {
                            labels: {
                                formatter: function (val) { return formatCurrencyShort(val); },
                                style: { fontFamily: 'Inter, sans-serif', fontSize: '12px', colors: '#9ca3af' },
                                offsetX: -10
                            }
                        },
                        tooltip: {
                            theme: 'light',
                            cssClass: 'custom-apex-tooltip',
                            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                                var dateLabel = w.globals.labels[dataPointIndex] || '';
                                var revenue = series[seriesIndex][dataPointIndex] || 0;
                                var orders = Array.isArray(revOrders) && revOrders[dataPointIndex] ? parseInt(revOrders[dataPointIndex], 10) : 0;
                                var aov = orders > 0 ? (parseFloat(revenue) / orders) : 0;

                                return '<div class="px-4 py-3 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 min-w-[200px]">'
                                    + '<div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">' + dateLabel + '</div>'
                                    + '<div class="space-y-2">'
                                    + '<div class="flex items-center justify-between"><span class="text-sm text-gray-600 dark:text-gray-300">Revenue</span><span class="text-sm font-bold text-purple-600 dark:text-purple-400">RM ' + parseFloat(revenue).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</span></div>'
                                    + '<div class="flex items-center justify-between"><span class="text-sm text-gray-600 dark:text-gray-300">Orders</span><span class="text-sm font-semibold text-gray-900 dark:text-gray-100">' + orders + '</span></div>'
                                    + '<div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-700"><span class="text-xs text-gray-500 dark:text-gray-400">Avg Order Value</span><span class="text-xs font-medium text-gray-700 dark:text-gray-300">RM ' + aov.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</span></div>'
                                    + '</div></div>';
                            }
                        },
                        markers: {
                            size: 0,
                            colors: ['#fff'],
                            strokeColors: '#8b5cf6',
                            strokeWidth: 2,
                            hover: { size: 6 }
                        }
                    };

                    if (document.getElementById('revenue-line-chart') && typeof ApexCharts !== 'undefined') {
                        var chart = new ApexCharts(document.getElementById('revenue-line-chart'), options);
                        chart.render();
                    }
                });
            </script>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Enhanced Bestsellers by Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Revenue</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Highest earning books</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" title="Export PDF">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Book</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                            @if(isset($bestsellersByRevenue) && count($bestsellersByRevenue) > 0)
                                @foreach($bestsellersByRevenue as $index => $book)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 group">
                                        <td class="px-6 py-4 whitespace-nowrap w-16">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $index < 3 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }} font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($book->cover_image)
                                                    <div class="flex-shrink-0 h-10 w-8 rounded shadow-sm overflow-hidden mr-3 group-hover:scale-105 transition-transform duration-200">
                                                        <img class="h-full w-full object-cover" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-8 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center mr-3">
                                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-1" title="{{ $book->title }}">{{ $book->title }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $book->author }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">RM {{ number_format($book->total_revenue, 2) }}</div>
                                            <div class="text-xs text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded-full inline-block mt-1">
                                                {{ $book->genre->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                            <p class="text-sm">No data available</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Enhanced Bestsellers by Units -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Units Sold</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Most popular by quantity</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" title="Export PDF">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Book</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Units</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                            @if(isset($bestsellersByUnits) && count($bestsellersByUnits) > 0)
                                @foreach($bestsellersByUnits as $index => $book)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 group">
                                        <td class="px-6 py-4 whitespace-nowrap w-16">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $index < 3 ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }} font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($book->cover_image)
                                                    <div class="flex-shrink-0 h-10 w-8 rounded shadow-sm overflow-hidden mr-3 group-hover:scale-105 transition-transform duration-200">
                                                        <img class="h-full w-full object-cover" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-8 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center mr-3">
                                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-1" title="{{ $book->title }}">{{ $book->title }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $book->author }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $book->total_units }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">units sold</div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            <p class="text-sm">No data available</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Enhanced Sales by Genre -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-pink-50 to-rose-50 dark:from-gray-700 dark:to-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="bg-pink-100 dark:bg-pink-900/30 rounded-lg p-2 mr-3">
                            <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Sales by Genre</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Revenue distribution across genres</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition-colors font-medium shadow-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            PDF
                        </button>
                        <button class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition-colors font-medium shadow-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Excel
                        </button>
                    </div>
                </div>
            </div>
        <!-- Enhanced Sales by Genre -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-pink-50 dark:bg-pink-900/20 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sales by Genre</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Revenue distribution across categories</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" title="Export PDF">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-1 flex flex-col justify-center">
                        <div class="relative">
                            <div id="genre-sales-pie-chart" class="w-full" style="height: 320px;"></div>
                            <!-- Center Text Overlay (Optional, if Donut) -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-1">Total Sales</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                    @php
                                        $totalGenreRevenue = ($salesByGenre ?? collect())->sum('total_revenue');
                                    @endphp
                                    RM {{ number_format($totalGenreRevenue, 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-2">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Genre Breakdown</h4>
                        <div class="space-y-4 max-h-[320px] overflow-y-auto pr-2 custom-scrollbar">
                            @if(isset($salesByGenre) && count($salesByGenre) > 0)
                                @foreach($salesByGenre as $index => $genre)
                                    @php
                                        $total = ($salesByGenre ?? collect())->sum('total_revenue');
                                        $percentage = $total > 0 ? ($genre->total_revenue / $total * 100) : 0;
                                        $colors = ['#ec4899', '#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1', '#14b8a6'];
                                        $color = $colors[$index % count($colors)];
                                    @endphp
                                    <div class="group">
                                        <div class="flex items-center justify-between mb-1">
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $color }}"></div>
                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $genre->name }}</span>
                                                <span class="text-xs text-gray-400 ml-2">({{ $genre->books_count ?? 0 }} books)</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-sm font-bold text-gray-900 dark:text-white">RM {{ number_format($genre->total_revenue, 2) }}</span>
                                                <span class="text-xs text-gray-500 ml-1">{{ number_format($percentage, 1) }}%</span>
                                            </div>
                                        </div>
                                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                            <div class="h-2 rounded-full transition-all duration-500 ease-out group-hover:opacity-80" style="width: {{ $percentage }}%; background-color: {{ $color }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex flex-col items-center justify-center py-12 text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                                    <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    <p class="text-sm">No genre data available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var genreData = @json($salesByGenre ?? collect());

                    // Fallback if no data
                    if (!Array.isArray(genreData) || genreData.length === 0) {
                        var container = document.getElementById('genre-sales-pie-chart');
                        if (container) {
                            container.innerHTML = ''; // Handled by the list view empty state
                        }
                        return;
                    }

                    // Prepare data for chart
                    var labels = genreData.map(function(item) { return item.name || 'Unknown'; });
                    var series = genreData.map(function(item) { return parseFloat(item.total_revenue || 0); });
                    var totalRevenue = series.reduce(function(a, b) { return a + b; }, 0);

                    // Generate colors matching the list
                    var colors = ['#ec4899', '#8b5cf6', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1', '#14b8a6'];

                    var chartColors = [];
                    for (var i = 0; i < labels.length; i++) {
                        chartColors.push(colors[i % colors.length]);
                    }

                    var options = {
                        chart: {
                            type: 'donut',
                            height: 320,
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
                        series: series,
                        labels: labels,
                        colors: chartColors,
                        dataLabels: { enabled: false },
                        legend: { show: false },
                        stroke: { show: false },
                        tooltip: {
                            enabled: true,
                            theme: 'light',
                            cssClass: 'custom-apex-tooltip',
                            y: {
                                formatter: function(val) {
                                    return 'RM ' + parseFloat(val).toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            },
                            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                                var label = w.globals.labels[seriesIndex];
                                var value = series[seriesIndex];
                                var percentage = ((value / totalRevenue) * 100).toFixed(1);
                                var color = w.globals.colors[seriesIndex];

                                return '<div class="px-3 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700">'
                                    + '<div class="flex items-center mb-1"><div class="w-2 h-2 rounded-full mr-2" style="background-color:' + color + '"></div><span class="text-xs font-semibold text-gray-700 dark:text-gray-300">' + label + '</span></div>'
                                    + '<div class="text-sm font-bold text-gray-900 dark:text-white">RM ' + parseFloat(value).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</div>'
                                    + '<div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">' + percentage + '% of total</div>'
                                    + '</div>';
                            }
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '75%',
                                    labels: { show: false } // Using custom overlay
                                }
                            }
                        }
                    };

                    if (document.getElementById('genre-sales-pie-chart') && typeof ApexCharts !== 'undefined') {
                        var chart = new ApexCharts(document.getElementById('genre-sales-pie-chart'), options);
                        chart.render();
                    }
                });
            </script>
        </div>
    </div>
@endsection

