@extends('layouts.admin')

@section('header', 'Sales Reports')

@section('content')
<div class="space-y-8">
    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Report Filters</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Period</label>
                <select name="period" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ is_string($startDate) ? substr($startDate, 0, 10) : ($startDate ? $startDate->format('Y-m-d') : '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ is_string($endDate) ? substr($endDate, 0, 10) : ($endDate ? $endDate->format('Y-m-d') : '') }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Revenue Over Time</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.reports.export.sales', ['type' => 'bestsellers', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</a>
            </div>
        </div>
        <div id="revenue-line-chart" class="w-full" style="height: 320px;"></div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var revCategories = @json(($revenueData ?? collect())->pluck('period'));
                var revSeries = @json(($revenueData ?? collect())->pluck('revenue'));
                var revOrders = @json(($revenueData ?? collect())->pluck('orders_count'));

                // Fallback if no data
                if (!Array.isArray(revCategories) || revCategories.length === 0) {
                    var container = document.getElementById('revenue-line-chart');
                    if (container) {
                        container.innerHTML = '<div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center text-sm text-gray-500 dark:text-gray-300">No revenue data for selected period.</div>';
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
                    // Accepts 'YYYY-MM', 'YYYY-MM-DD', or 'YYYY'
                    if (typeof p !== 'string') return p;
                    if (/^\d{4}-\d{2}-\d{2}$/.test(p)) {
                        // YYYY-MM-DD → e.g., 2025-09-01 → Sep 01, 2025
                        var d = new Date(p + 'T00:00:00');
                        if (!isNaN(d)) return d.toLocaleDateString(undefined, { month: 'short', day: '2-digit', year: 'numeric' });
                    } else if (/^\d{4}-\d{2}$/.test(p)) {
                        // YYYY-MM → Sep 2025
                        var parts = p.split('-');
                        var d2 = new Date(parts[0], parseInt(parts[1], 10) - 1, 1);
                        if (!isNaN(d2)) return d2.toLocaleDateString(undefined, { month: 'short', year: 'numeric' });
                    }
                    return p;
                }

                var displayCategories = revCategories.map(formatPeriodLabel);

                var options = {
                    chart: {
                        height: 320,
                        type: 'line',
                        toolbar: { show: false },
                        fontFamily: 'Inter, sans-serif'
                    },
                    stroke: {
                        width: 4,
                        curve: 'smooth'
                    },
                    dataLabels: { enabled: false },
                    grid: {
                        show: true,
                        borderColor: '#e5e7eb',
                        strokeDashArray: 4,
                        // Add extra right/bottom padding so last x-axis label isn't clipped
                        padding: { left: 8, right: 28, top: 8, bottom: 14 }
                    },
                    series: [{
                        name: 'Revenue (RM)',
                        data: revSeries,
                        color: '#7c3aed'
                    }],
                    xaxis: {
                        categories: displayCategories,
                        tickPlacement: 'between',
                        labels: {
                            show: true,
                            rotate: -25,
                            rotateAlways: true,
                            hideOverlappingLabels: true,
                            trim: false,
                            style: { fontFamily: 'Inter, sans-serif', cssClass: 'text-xs font-normal fill-gray-500' }
                        },
                        axisBorder: { show: true, color: '#e5e7eb' },
                        axisTicks: { show: true, color: '#e5e7eb' },
                        tooltip: { enabled: false }
                    },
                    yaxis: {
                        min: 0,
                        tickAmount: 5,
                        decimalsInFloat: 0,
                        labels: {
                            show: true,
                            formatter: function (val) { return formatCurrencyShort(val); },
                            style: { fontFamily: 'Inter, sans-serif', cssClass: 'text-xs font-normal fill-gray-500' }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        title: {
                            text: 'Revenue (RM)',
                            style: { fontFamily: 'Inter, sans-serif', fontWeight: 500, cssClass: 'text-xs fill-gray-500' }
                        }
                    },
                    tooltip: {
                        shared: false,
                        intersect: true,
                        custom: function({ series, seriesIndex, dataPointIndex, w }) {
                            var dateLabel = w.globals.labels[dataPointIndex] || '';
                            var revenue = series[seriesIndex][dataPointIndex] || 0;
                            var orders = Array.isArray(revOrders) && revOrders[dataPointIndex] ? parseInt(revOrders[dataPointIndex], 10) : 0;
                            var aov = orders > 0 ? (parseFloat(revenue) / orders) : 0;
                            return '<div class="px-3 py-2 text-sm">'
                                + '<div class="font-semibold text-gray-900 dark:text-gray-100">' + dateLabel + '</div>'
                                + '<div class="mt-1 text-gray-600 dark:text-gray-300">Revenue: <span class="font-medium">RM ' + (parseFloat(revenue).toFixed(2)) + '</span></div>'
                                + '<div class="text-gray-600 dark:text-gray-300">Orders: <span class="font-medium">' + orders + '</span></div>'
                                + '<div class="text-gray-600 dark:text-gray-300">Avg Order Value: <span class="font-medium">RM ' + aov.toFixed(2) + '</span></div>'
                                + '</div>';
                        }
                    },
                    markers: {
                        size: 3,
                        strokeWidth: 0,
                        colors: ['#7c3aed']
                    }
                };

                if (document.getElementById('revenue-line-chart') && typeof ApexCharts !== 'undefined') {
                    var chart = new ApexCharts(document.getElementById('revenue-line-chart'), options);
                    chart.render();
                }
            });
        </script>
    </div>

    <!-- Bestsellers by Revenue -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Bestsellers by Revenue</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Genre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Revenue</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @if(isset($bestsellersByRevenue) && count($bestsellersByRevenue) > 0)
                        @foreach($bestsellersByRevenue as $index => $book)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($book->cover_image)
                                            <div class="flex-shrink-0 h-10 w-8">
                                                <img class="h-10 w-8 object-cover rounded" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-10 w-8 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="h-6 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->author }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->genre->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">RM {{ number_format($book->total_revenue, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No sales data available for the selected period.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bestsellers by Units -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Bestsellers by Units Sold</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Genre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Units Sold</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @if(isset($bestsellersByUnits) && count($bestsellersByUnits) > 0)
                        @foreach($bestsellersByUnits as $index => $book)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($book->cover_image)
                                            <div class="flex-shrink-0 h-10 w-8">
                                                <img class="h-10 w-8 object-cover rounded" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-10 w-8 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="h-6 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->author }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->genre->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">{{ $book->total_units }} units</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No sales data available for the selected period.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sales by Genre -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Sales by Genre</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">Pie Chart</p>
                </div>
            </div>
            <div class="space-y-4">
                @if(isset($salesByGenre) && count($salesByGenre) > 0)
                    @foreach($salesByGenre as $genre)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $genre->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-300">{{ $genre->books_count }} books</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-green-600">RM {{ number_format($genre->total_revenue, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-500 dark:text-gray-300">No genre sales data available.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
