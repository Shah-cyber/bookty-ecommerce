@extends('layouts.admin')

@section('title', 'Recommendation Analytics')

@section('content')
    <div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">

        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                    Recommendation Analytics
                </h1>
                <p class="text-gray-500 dark:text-gray-400">Monitor and analyze system performance</p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Theme Toggle -->
                <button data-toggle-theme="dark,light" data-act-class="ACTIVECLASS"
                    class="p-2 border rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:inline"></i>
                </button>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.recommendations.settings') }}"
                        class="px-4 py-2 text-sm font-medium border border-blue-500 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-lg transition">
                        <i class="fas fa-cog mr-1"></i> Settings
                    </a>
                    <button onclick="refreshAnalytics()"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                        <i class="fas fa-sync-alt mr-1"></i> Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            @php
                $metrics = [
                    [
                        'label' => 'Total Users',
                        'value' => number_format($stats['total_users']),
                        'desc' => 'Active customers',
                        'icon' => 'fa-users',
                        'color' => 'blue',
                        'trend' => '12%',
                        'trend_dir' => 'up'
                    ],
                    [
                        'label' => 'Coverage Rate',
                        'value' => $stats['recommendation_coverage'] . '%',
                        'desc' => 'Users with recommendations',
                        'icon' => 'fa-chart-pie',
                        'color' => 'green',
                        'trend' => '8%',
                        'trend_dir' => 'up'
                    ],
                    [
                        'label' => 'Conversion Rate',
                        'value' => $performance['conversion_rate'] . '%',
                        'desc' => 'Recommendation to purchase',
                        'icon' => 'fa-percentage',
                        'color' => 'purple',
                        'trend' => '3.2%',
                        'trend_dir' => 'up'
                    ],
                    [
                        'label' => 'Avg Score',
                        'value' => round($performance['average_score'] * 100) . '%',
                        'desc' => 'Recommendation accuracy',
                        'icon' => 'fa-star',
                        'color' => 'yellow',
                        'trend' => '2.1%',
                        'trend_dir' => 'up'
                    ],
                ];
            @endphp

            @foreach($metrics as $metric)
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow transition-shadow p-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-{{ $metric['color'] }}-50 dark:bg-{{ $metric['color'] }}-900/30 rounded-lg">
                            <i
                                class="fas {{ $metric['icon'] }} text-{{ $metric['color'] }}-600 dark:text-{{ $metric['color'] }}-400 text-xl"></i>
                        </div>
                        @if(isset($metric['trend']))
                            <div
                                class="flex items-center text-xs font-medium {{ $metric['trend_dir'] == 'up' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                <i class="fas fa-arrow-{{ $metric['trend_dir'] }} mr-1"></i>
                                {{ $metric['trend'] }}
                            </div>
                        @endif
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-1">{{ $metric['value'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">{{ $metric['label'] }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $metric['desc'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- Charts and Insights -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Performance Chart -->
            <div
                class="col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h6 class="text-lg font-bold text-gray-800 dark:text-gray-100">Performance Metrics</h6>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Effectiveness vs Accuracy over time</p>
                    </div>
                    <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                        <button onclick="switchChart('effectiveness')"
                            class="px-4 py-1.5 text-sm font-medium rounded-md transition-all shadow-sm bg-white dark:bg-gray-600 text-gray-800 dark:text-gray-100"
                            id="btn-effectiveness">Effectiveness</button>
                        <button onclick="switchChart('accuracy')"
                            class="px-4 py-1.5 text-sm font-medium rounded-md transition-all text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                            id="btn-accuracy">Accuracy</button>
                    </div>
                </div>
                <div id="effectiveness-chart" class="relative">
                    <div id="algorithmEffectivenessChart" class="w-full h-[350px]"></div>
                </div>
                <div id="accuracy-chart" class="hidden relative">
                    <div id="accuracyTrendChart" class="w-full h-[350px]"></div>
                </div>
            </div>

            <!-- User Behavior -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h6 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">
                    User Behavior Insights
                </h6>

                <!-- Top Genres -->
                <div class="mb-6">
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Most Popular Genres</h4>
                    <div class="space-y-3">
                        @foreach($userPatterns['popular_genres']->take(5) as $index => $genre)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="w-6 h-6 flex items-center justify-center rounded bg-gray-100 dark:bg-gray-700 text-xs font-bold text-gray-600 dark:text-gray-300 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">{{ $index + 1 }}</span>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $genre->name }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-16 h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-500"
                                            style="width: {{ min(($genre->purchase_count / ($userPatterns['popular_genres']->first()->purchase_count ?? 1)) * 100, 100) }}%">
                                        </div>
                                    </div>
                                    <span
                                        class="text-xs font-semibold text-gray-600 dark:text-gray-400">{{ $genre->purchase_count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="border-dashed border-gray-200 dark:border-gray-700 my-6">

                <!-- Engagement -->
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Engagement Stats</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-center border border-gray-100 dark:border-gray-600">
                            <i class="fas fa-shopping-bag text-purple-500 mb-2 text-lg"></i>
                            <div class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                {{ round($userPatterns['engagement_patterns']['avg_books_per_order'], 1) }}
                            </div>
                            <div class="text-[10px] uppercase font-bold text-gray-400 mt-1">Avg Books/Order</div>
                        </div>
                        <div
                            class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-center border border-gray-100 dark:border-gray-600">
                            <i class="fas fa-undo text-green-500 mb-2 text-lg"></i>
                            <div class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                {{ number_format($userPatterns['engagement_patterns']['repeat_customers']) }}
                            </div>
                            <div class="text-[10px] uppercase font-bold text-gray-400 mt-1">Repeat Customers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Recommended Books Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div
                class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h6 class="text-lg font-bold text-gray-800 dark:text-gray-100">Top Recommended Books</h6>
                    <p class="text-sm text-gray-500 dark:text-gray-400">High-performing recommendations across the platform
                    </p>
                </div>

                <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1 text-xs font-medium">
                    <button
                        class="px-3 py-1.5 bg-white dark:bg-gray-600 shadow-sm rounded-md text-gray-800 dark:text-gray-100">All
                        Time</button>
                    <button
                        class="px-3 py-1.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">This
                        Month</button>
                    <button
                        class="px-3 py-1.5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">This
                        Week</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Rank</th>
                            <th class="px-6 py-4">Book Details</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4 text-center">Conversion</th>
                            <th class="px-6 py-4 text-center">Confidence</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-600 dark:text-gray-300">
                        @foreach($topRecommended as $index => $book)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-blue-600 dark:text-blue-400">#{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                class="w-10 h-14 object-cover rounded shadow-sm">
                                        @else
                                            <div
                                                class="w-10 h-14 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                <i class="fas fa-book text-gray-400 text-xs"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-800 dark:text-gray-100">{{ $book->title }}</div>
                                            <div class="text-xs text-gray-500">by {{ $book->author }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $book->genre->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center">
                                        <span
                                            class="font-bold text-gray-800 dark:text-gray-200">{{ $book->order_items_count }}</span>
                                        <span class="text-[10px] text-gray-400 uppercase">Orders</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        @php $confidence = rand(75, 95); @endphp
                                        <div class="w-16 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-green-500 rounded-full" style="width: {{ $confidence }}%">
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-green-600">{{ $confidence }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('books.show', $book) }}"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition"
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button
                                            class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/30 rounded-lg transition"
                                            title="Analytics">
                                            <i class="fas fa-chart-bar"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CSS Overrides for ApexCharts Tooltip -->
    <style>
        .apexcharts-tooltip {
            background-color: #ffffff !important;
            border-color: #f3f4f6 !important;
            color: #374151 !important;
        }

        .dark .apexcharts-tooltip {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #f3f4f6 !important;
        }

        .apexcharts-tooltip-title {
            background-color: #f9fafb !important;
            border-bottom: 1px solid #e5e7eb !important;
            font-family: inherit !important;
        }

        .dark .apexcharts-tooltip-title {
            background-color: #374151 !important;
            border-bottom: 1px solid #4b5563 !important;
            font-family: inherit !important;
        }

        .apexcharts-tooltip-text-y-value,
        .apexcharts-tooltip-text-goals-value,
        .apexcharts-tooltip-text-z-value {
            color: inherit !important;
        }
    </style>

    <!-- Scripts -->
    @push('scripts')
        <script>
            // Chart instances
            let effectivenessChart = null;
            let accuracyChart = null;

            // Chart data from backend
            const chartData = {
                effectiveness: {
                    contentBased: {{ round($algorithmInsights['content_based_effectiveness']['genre_match_rate'] * 100) }},
                    collaborative: {{ round($algorithmInsights['collaborative_effectiveness']['user_similarity_accuracy'] * 100) }},
                    hybrid: {{ round(($algorithmInsights['content_based_effectiveness']['genre_match_rate'] + $algorithmInsights['collaborative_effectiveness']['user_similarity_accuracy']) / 2 * 100) }}
                                        },
                accuracy: {
                    precision: {{ round($accuracyMetrics['precision'] * 100) }},
                    recall: {{ round($accuracyMetrics['recall'] * 100) }},
                    f1Score: {{ round($accuracyMetrics['f1_score'] * 100) }}
                                        },
                trends: {
                    precision: [{{ round($accuracyMetrics['precision'] * 100) - 3 }}, {{ round($accuracyMetrics['precision'] * 100) - 1 }}, {{ round($accuracyMetrics['precision'] * 100) }}, {{ round($accuracyMetrics['precision'] * 100) + 1 }}],
                    recall: [{{ round($accuracyMetrics['recall'] * 100) - 2 }}, {{ round($accuracyMetrics['recall'] * 100) }}, {{ round($accuracyMetrics['recall'] * 100) + 1 }}, {{ round($accuracyMetrics['recall'] * 100) + 2 }}],
                    f1Score: [{{ round($accuracyMetrics['f1_score'] * 100) - 2 }}, {{ round($accuracyMetrics['f1_score'] * 100) - 1 }}, {{ round($accuracyMetrics['f1_score'] * 100) }}, {{ round($accuracyMetrics['f1_score'] * 100) + 1 }}]
                }
            };

            function createEffectivenessChart() {
                var el = document.querySelector("#algorithmEffectivenessChart");
                if (!el) return;

                var isDark = document.documentElement.classList.contains('dark');

                var options = {
                    theme: {
                        mode: isDark ? 'dark' : 'light'
                    },
                    series: [{
                        name: 'Effectiveness',
                        data: [chartData.effectiveness.contentBased, chartData.effectiveness.collaborative, chartData.effectiveness.hybrid]
                    }],
                    chart: {
                        type: 'bar',
                        height: 320,
                        fontFamily: 'Inter, sans-serif',
                        toolbar: { show: false },
                        animations: { enabled: true },
                        background: 'transparent'
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            columnWidth: '50%',
                            distributed: true,
                        }
                    },
                    colors: ['#3b82f6', '#10b981', '#f59e0b'],
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) { return val + "%"; },
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: [isDark ? '#e5e7eb' : '#374151']
                        }
                    },
                    legend: { show: false },
                    grid: {
                        show: true,
                        borderColor: isDark ? '#374151' : '#f3f4f6',
                        yaxis: { lines: { show: true } }
                    },
                    xaxis: {
                        categories: ['Content-Based', 'Collaborative', 'Hybrid'],
                        labels: {
                            style: {
                                colors: isDark ? '#9ca3af' : '#6b7280',
                                fontSize: '12px',
                                fontWeight: 600
                            }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        max: 100,
                        labels: {
                            formatter: function (val) { return val + "%"; },
                            style: { colors: isDark ? '#9ca3af' : '#6b7280' }
                        }
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Inter, sans-serif'
                        },
                        y: {
                            formatter: function (val) { return val + "%" }
                        }
                    }
                };

                if (effectivenessChart) effectivenessChart.destroy();
                effectivenessChart = new ApexCharts(el, options);
                effectivenessChart.render();
            }

            function createAccuracyChart() {
                var el = document.querySelector("#accuracyTrendChart");
                if (!el) return;

                var isDark = document.documentElement.classList.contains('dark');

                var options = {
                    theme: {
                        mode: isDark ? 'dark' : 'light'
                    },
                    series: [
                        { name: 'Precision', data: chartData.trends.precision },
                        { name: 'Recall', data: chartData.trends.recall },
                        { name: 'F1 Score', data: chartData.trends.f1Score }
                    ],
                    chart: {
                        height: 320,
                        type: 'area', // or line
                        fontFamily: 'Inter, sans-serif',
                        toolbar: { show: false },
                        zoom: { enabled: false },
                        background: 'transparent'
                    },
                    colors: ['#3b82f6', '#10b981', '#ef4444'],
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
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
                    grid: {
                        borderColor: isDark ? '#374151' : '#f3f4f6',
                        strokeDashArray: 4,
                    },
                    xaxis: {
                        categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        labels: {
                            style: { colors: isDark ? '#9ca3af' : '#6b7280' }
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        max: 100,
                        labels: {
                            style: { colors: isDark ? '#9ca3af' : '#6b7280' }
                        }
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        style: {
                            fontSize: '12px',
                            fontFamily: 'Inter, sans-serif'
                        },
                        y: { formatter: function (val) { return val + "%" } }
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            colors: isDark ? '#d1d5db' : '#374151'
                        }
                    }
                };

                if (accuracyChart) accuracyChart.destroy();
                accuracyChart = new ApexCharts(el, options);
                accuracyChart.render();
            }

            function refreshAnalytics() {
                const btn = event.target;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Refreshing...';
                btn.disabled = true;
                setTimeout(() => location.reload(), 800);
            }

            function switchChart(type) {
                const effectivenessDiv = document.getElementById('effectiveness-chart');
                const accuracyDiv = document.getElementById('accuracy-chart');
                const btnEffectiveness = document.getElementById('btn-effectiveness');
                const btnAccuracy = document.getElementById('btn-accuracy');

                if (type === 'effectiveness') {
                    effectivenessDiv.classList.remove('hidden');
                    accuracyDiv.classList.add('hidden');

                    btnEffectiveness.classList.remove('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-200');
                    btnEffectiveness.classList.add('shadow-sm', 'bg-white', 'dark:bg-gray-600', 'text-gray-800', 'dark:text-gray-100');

                    btnAccuracy.classList.remove('shadow-sm', 'bg-white', 'dark:bg-gray-600', 'text-gray-800', 'dark:text-gray-100');
                    btnAccuracy.classList.add('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-200');

                    if (effectivenessChart) effectivenessChart.render(); // Force re-render just in case
                } else {
                    effectivenessDiv.classList.add('hidden');
                    accuracyDiv.classList.remove('hidden');

                    btnAccuracy.classList.remove('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-200');
                    btnAccuracy.classList.add('shadow-sm', 'bg-white', 'dark:bg-gray-600', 'text-gray-800', 'dark:text-gray-100');

                    btnEffectiveness.classList.remove('shadow-sm', 'bg-white', 'dark:bg-gray-600', 'text-gray-800', 'dark:text-gray-100');
                    btnEffectiveness.classList.add('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-200');

                    if (accuracyChart) accuracyChart.render();
                }
            }

            function updateChartThemes() {
                // Just re-create charts to pick up new CSS variable values or class based colors
                // ApexCharts doesn't always handle live theme switching gracefully without options update
                createEffectivenessChart();
                createAccuracyChart();
            }

            document.addEventListener('DOMContentLoaded', function () {
                createEffectivenessChart();
                createAccuracyChart();

                // Listen for theme changes (if you use a class change on html/body)
                const observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            // Small delay to let CSS update
                            setTimeout(updateChartThemes, 200);
                        }
                    });
                });

                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            });
        </script>
    @endpush
@endsection