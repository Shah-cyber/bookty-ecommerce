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
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Profit Margin by Book -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Profit Margin by Book</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Book</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Genre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Profit Margin</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @if(isset($profitMarginByBook) && count($profitMarginByBook) > 0)
                        @foreach($profitMarginByBook as $book)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if(isset($book->cover_image) && $book->cover_image)
                                            <div class="flex-shrink-0 h-10 w-8">
                                                <img class="h-10 w-8 object-cover rounded" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-10 w-8 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                <svg class="h-6 w-4 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">N/A</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">RM {{ number_format($book->total_revenue, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">{{ isset($book->profit_margin) ? number_format($book->profit_margin, 2) : '0.00' }}%</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">No profitability data available for the selected period.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Profit Margin by Genre -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Profit Margin by Genre</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">Genre Profit Chart</p>
                </div>
            </div>
            <div class="space-y-4">
                @if(isset($profitMarginByGenre) && count($profitMarginByGenre) > 0)
                    @foreach($profitMarginByGenre as $genre)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $genre->name }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-green-600">RM {{ number_format($genre->total_revenue, 2) }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-300">75% margin</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-500 dark:text-gray-300">No genre profitability data available.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Monthly Profit vs Expenses -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Monthly Profit vs Expenses</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>

        <div class="max-w-full w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
            <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
                <dl>
                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Overview</dt>
                    <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">Monthly</dd>
                </dl>
                <div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
                        <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                        </svg>
                        Profit rate
                    </span>
                </div>
            </div>

            <div id="monthly-bar-chart"></div>
            <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                <div class="flex justify-between items-center pt-5">
                    <button id="dropdownMonthlyButton" data-dropdown-toggle="monthlyRangeDropdown" data-dropdown-placement="bottom" class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white" type="button">
                        Last 6 months
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div id="monthlyRangeDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMonthlyButton">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 6 months</a></li>
                        </ul>
                    </div>
                    <span class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500 px-3 py-2">Revenue Report</span>
                </div>
            </div>
        </div>

        @php
            $mpMonths = collect($monthlyProfitExpenses ?? [])->pluck('month')->toArray();
            $mpRevenue = collect($monthlyProfitExpenses ?? [])->pluck('revenue')->map(fn($v) => (float) $v)->toArray();
            $mpCost = collect($monthlyProfitExpenses ?? [])->pluck('cost')->map(fn($v) => (float) $v)->toArray();
        @endphp

        <script>
            (function(){
                const options = {
                    series: [
                        { name: "Income", color: "#31C48D", data: @json($mpRevenue) },
                        { name: "Expense", color: "#F05252", data: @json($mpCost) }
                    ],
                    chart: { sparkline: { enabled: false }, type: "bar", width: "100%", height: 400, toolbar: { show: false } },
                    plotOptions: { bar: { horizontal: true, columnWidth: "100%", borderRadiusApplication: "end", borderRadius: 6, dataLabels: { position: "top" } } },
                    legend: { show: true, position: "bottom" },
                    dataLabels: { enabled: false },
                    tooltip: { shared: true, intersect: false, y: { formatter: function(val){ return "RM " + val.toFixed(2); } } },
                    xaxis: {
                        categories: @json($mpMonths),
                        labels: { show: true, style: { fontFamily: "Inter, sans-serif", cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400' },
                            formatter: function(value){ return "RM " + value }
                        },
                        axisTicks: { show: false }, axisBorder: { show: false }
                    },
                    yaxis: { labels: { show: true, style: { fontFamily: "Inter, sans-serif", cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400' } } },
                    grid: { show: true, strokeDashArray: 4, padding: { left: 2, right: 2, top: -20 } },
                    fill: { opacity: 1 }
                };

                if (document.getElementById("monthly-bar-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("monthly-bar-chart"), options);
                    chart.render();
                }
            })();
        </script>
    </div>

    <!-- Refund Loss Analysis -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Refund Loss Analysis</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="text-3xl font-bold text-green-600">RM {{ number_format($refundLossAnalysis['total_revenue'] ?? 0, 2) }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-300 mt-2">Total Revenue</div>
            </div>
            <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="text-3xl font-bold text-red-600">RM {{ number_format($refundLossAnalysis['refunded_amount'] ?? 0, 2) }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-300 mt-2">Refunded Amount</div>
            </div>
            <div class="text-center p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="text-3xl font-bold text-orange-600">{{ $refundLossAnalysis['refund_percentage'] ?? 0 }}%</div>
                <div class="text-sm text-gray-500 dark:text-gray-300 mt-2">Refund Rate</div>
            </div>
        </div>
    </div>
</div>
@endsection
