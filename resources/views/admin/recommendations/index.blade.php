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
                    'trend' => '+12%',
                ],
                [
                    'label' => 'Coverage Rate',
                    'value' => $stats['recommendation_coverage'] . '%',
                    'desc' => 'Users with recommendations',
                    'icon' => 'fa-chart-pie',
                    'color' => 'green',
                    'trend' => '+8%',
                ],
                [
                    'label' => 'Conversion Rate',
                    'value' => $performance['conversion_rate'] . '%',
                    'desc' => 'Recommendation to purchase',
                    'icon' => 'fa-percentage',
                    'color' => 'cyan',
                    'trend' => '+3.2%',
                ],
                [
                    'label' => 'Avg Score',
                    'value' => round($performance['average_score'] * 100) . '%',
                    'desc' => 'Recommendation accuracy',
                    'icon' => 'fa-star',
                    'color' => 'yellow',
                    'trend' => '+2.1%',
                ],
            ];
        @endphp

        @foreach($metrics as $metric)
        <div class="relative p-5 bg-white/70 dark:bg-gray-800/70 backdrop-blur-lg shadow-sm border-l-4 border-{{ $metric['color'] }}-500 rounded-lg hover:shadow-md transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs uppercase text-{{ $metric['color'] }}-600 font-semibold">{{ $metric['label'] }}</p>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $metric['value'] }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $metric['desc'] }}</p>
                </div>
                <div class="p-3 bg-{{ $metric['color'] }}-100 dark:bg-{{ $metric['color'] }}-900/40 rounded-full">
                    <i class="fas {{ $metric['icon'] }} text-{{ $metric['color'] }}-600"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-green-600 dark:text-green-400">
                <i class="fas fa-arrow-up"></i> {{ $metric['trend'] }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Charts and Insights -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Performance Chart -->
        <div class="col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h6 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                    <i class="fas fa-chart-bar text-blue-500 mr-2"></i>Performance Metrics
                </h6>
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <button onclick="switchChart('effectiveness')" class="px-3 py-1 text-sm border border-blue-500 text-blue-500 rounded-l-lg hover:bg-blue-50 dark:hover:bg-blue-900">Effectiveness</button>
                    <button onclick="switchChart('accuracy')" class="px-3 py-1 text-sm border border-blue-500 text-blue-500 rounded-r-lg hover:bg-blue-50 dark:hover:bg-blue-900">Accuracy</button>
                </div>
            </div>
            <div id="effectiveness-chart" class="relative h-[320px]">
                <canvas id="algorithmEffectivenessChart"></canvas>
            </div>
            <div id="accuracy-chart" class="hidden relative h-[320px]">
                <canvas id="accuracyTrendChart"></canvas>
            </div>
        </div>

        <!-- User Behavior -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h6 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                <i class="fas fa-users text-blue-500 mr-2"></i>User Behavior
            </h6>

            <!-- Top Genres -->
            <div class="space-y-2 mb-4">
                @foreach($userPatterns['popular_genres']->take(5) as $index => $genre)
                    <div class="flex justify-between items-center p-2 rounded-lg {{ $index % 2 ? 'bg-gray-100 dark:bg-gray-700/50' : 'bg-gray-50 dark:bg-gray-800/70' }}">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-500 text-white text-xs font-bold">{{ $index + 1 }}</span>
                            <span class="text-gray-800 dark:text-gray-100 font-semibold">{{ $genre->name }}</span>
                        </div>
                        <span class="text-blue-600 font-semibold">{{ $genre->purchase_count }}</span>
                    </div>
                @endforeach
            </div>

            <hr class="border-gray-200 dark:border-gray-700 my-4">

            <!-- Engagement -->
            <div class="grid grid-cols-2 gap-3 text-center">
                <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
                    <i class="fas fa-shopping-cart text-blue-500 text-2xl mb-1"></i>
                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                        {{ round($userPatterns['engagement_patterns']['avg_books_per_order'], 1) }}
                    </div>
                    <small class="text-gray-500 dark:text-gray-400">Avg Books/Order</small>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-gray-700/40 rounded-lg">
                    <i class="fas fa-redo text-green-500 text-2xl mb-1"></i>
                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                        {{ number_format($userPatterns['engagement_patterns']['repeat_customers']) }}
                    </div>
                    <small class="text-gray-500 dark:text-gray-400">Repeat Customers</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Recommended Books Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h6 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                <i class="fas fa-star text-yellow-400 mr-2"></i>Top Recommended Books
            </h6>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-sm border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900">All Time</button>
                <button class="px-3 py-1 text-sm border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900">This Month</button>
                <button class="px-3 py-1 text-sm border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900">This Week</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase">
                    <tr>
                        <th class="px-4 py-2">Rank</th>
                        <th class="px-4 py-2">Book</th>
                        <th class="px-4 py-2">Genre</th>
                        <th class="px-4 py-2">Orders</th>
                        <th class="px-4 py-2">Score</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($topRecommended as $index => $book)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                        <td class="px-4 py-3 font-semibold text-blue-600">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 flex items-center gap-3">
                            <img src="{{ $book->cover_image ? asset('storage/'.$book->cover_image) : asset('default-book.png') }}"
                                 class="w-10 h-14 object-cover rounded shadow">
                            <div>
                                <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $book->title }}</div>
                                <small class="text-gray-500">by {{ $book->author }}</small>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 rounded text-xs font-semibold">
                                {{ $book->genre->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <i class="fas fa-shopping-cart text-blue-500 mr-1"></i>
                            {{ $book->order_items_count }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-green-600 font-semibold">{{ rand(75, 95) }}%</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('books.show', $book) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="text-cyan-500 hover:text-cyan-700">
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

<!-- Scripts -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function refreshAnalytics() {
    const btn = event.target;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Refreshing...';
    btn.disabled = true;
    
    // Add loading animation to charts
    if (effectivenessChart) {
        effectivenessChart.options.animation.duration = 0;
        effectivenessChart.update();
    }
    if (accuracyChart) {
        accuracyChart.options.animation.duration = 0;
        accuracyChart.update();
    }
    
    setTimeout(() => location.reload(), 1000);
}

// Export chart data as JSON
function exportChartData() {
    const data = {
        effectiveness: chartData.effectiveness,
        accuracy: chartData.accuracy,
        trends: chartData.trends,
        exportedAt: new Date().toISOString()
    };
    
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'recommendation-analytics-data.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// Print charts
function printCharts() {
    const printWindow = window.open('', '_blank');
    const chartsHtml = `
        <html>
        <head>
            <title>Recommendation Analytics - Charts</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .chart-container { margin: 20px 0; page-break-inside: avoid; }
                .chart-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
                .chart-info { font-size: 12px; color: #666; margin-bottom: 15px; }
            </style>
        </head>
        <body>
            <h1>Recommendation Analytics Charts</h1>
            <p>Generated on: ${new Date().toLocaleString()}</p>
            
            <div class="chart-container">
                <div class="chart-title">Algorithm Effectiveness</div>
                <div class="chart-info">
                    Content-Based: ${chartData.effectiveness.contentBased}% | 
                    Collaborative: ${chartData.effectiveness.collaborative}% | 
                    Hybrid: ${chartData.effectiveness.hybrid}%
                </div>
                <canvas id="printEffectivenessChart" width="800" height="400"></canvas>
            </div>
            
            <div class="chart-container">
                <div class="chart-title">Accuracy Trends</div>
                <div class="chart-info">
                    Current Precision: ${chartData.accuracy.precision}% | 
                    Current Recall: ${chartData.accuracy.recall}% | 
                    Current F1 Score: ${chartData.accuracy.f1Score}%
                </div>
                <canvas id="printAccuracyChart" width="800" height="400"></canvas>
            </div>
            
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Print Effectiveness Chart
                new Chart(document.getElementById('printEffectivenessChart'), {
                    type: 'bar',
                    data: {
                        labels: ['Content-Based', 'Collaborative', 'Hybrid'],
                        datasets: [{
                            label: 'Effectiveness (%)',
                            data: [${chartData.effectiveness.contentBased}, ${chartData.effectiveness.collaborative}, ${chartData.effectiveness.hybrid}],
                            backgroundColor: ['rgba(59, 130, 246, 0.8)', 'rgba(16, 185, 129, 0.8)', 'rgba(245, 158, 11, 0.8)'],
                            borderColor: ['rgb(59, 130, 246)', 'rgb(16, 185, 129)', 'rgb(245, 158, 11)'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true, max: 100 }
                        }
                    }
                });
                
                // Print Accuracy Chart
                new Chart(document.getElementById('printAccuracyChart'), {
                    type: 'line',
                    data: {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        datasets: [{
                            label: 'Precision',
                            data: [${chartData.trends.precision.join(',')}],
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }, {
                            label: 'Recall',
                            data: [${chartData.trends.recall.join(',')}],
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        }, {
                            label: 'F1 Score',
                            data: [${chartData.trends.f1Score.join(',')}],
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            legend: { position: 'top' }
                        },
                        scales: {
                            y: { beginAtZero: true, max: 100 }
                        }
                    }
                });
            </script>
        </body>
        </html>
    `;
    
    printWindow.document.write(chartsHtml);
    printWindow.document.close();
    printWindow.print();
}

// Reset charts to default view
function resetCharts() {
    if (effectivenessChart) {
        effectivenessChart.reset();
    }
    if (accuracyChart) {
        accuracyChart.reset();
    }
    
    // Switch back to effectiveness chart
    switchChart('effectiveness');
}

// Add chart action buttons to the header
function addChartActions() {
    const chartHeader = document.querySelector('.col-span-2 .flex.justify-between.items-center');
    if (chartHeader && !document.getElementById('chartActions')) {
        const actionsDiv = document.createElement('div');
        actionsDiv.id = 'chartActions';
        actionsDiv.className = 'flex gap-2 ml-4';
        actionsDiv.innerHTML = `
            <button onclick="exportChartData()" class="px-3 py-1 text-sm border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700" title="Export Data">
                <i class="fas fa-download"></i>
            </button>
            <button onclick="printCharts()" class="px-3 py-1 text-sm border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700" title="Print Charts">
                <i class="fas fa-print"></i>
            </button>
            <button onclick="resetCharts()" class="px-3 py-1 text-sm border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700" title="Reset View">
                <i class="fas fa-undo"></i>
            </button>
        `;
        chartHeader.appendChild(actionsDiv);
    }
}

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

// Get theme colors
function getThemeColors() {
    const isDark = document.documentElement.classList.contains('dark');
    return {
        text: isDark ? '#d1d5db' : '#374151',
        grid: isDark ? '#4b5563' : '#e5e7eb',
        background: isDark ? '#1f2937' : '#ffffff'
    };
}

// Create Effectiveness Chart
function createEffectivenessChart() {
    const ctx = document.getElementById('algorithmEffectivenessChart');
    if (!ctx) return;

    const colors = getThemeColors();
    
    effectivenessChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Content-Based', 'Collaborative', 'Hybrid'],
            datasets: [{
                label: 'Effectiveness (%)',
                data: [
                    chartData.effectiveness.contentBased,
                    chartData.effectiveness.collaborative,
                    chartData.effectiveness.hybrid
                ],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)'
                ],
                borderColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)'
                ],
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: colors.background,
                    titleColor: colors.text,
                    bodyColor: colors.text,
                    borderColor: colors.grid,
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        color: colors.text,
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    grid: {
                        color: colors.grid,
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: colors.text
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

// Create Accuracy Trend Chart
function createAccuracyChart() {
    const ctx = document.getElementById('accuracyTrendChart');
    if (!ctx) return;

    const colors = getThemeColors();
    
    accuracyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Precision',
                data: chartData.trends.precision,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }, {
                label: 'Recall',
                data: chartData.trends.recall,
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(16, 185, 129)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }, {
                label: 'F1 Score',
                data: chartData.trends.f1Score,
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(239, 68, 68)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: colors.text,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: colors.background,
                    titleColor: colors.text,
                    bodyColor: colors.text,
                    borderColor: colors.grid,
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: colors.text
                    },
                    grid: {
                        color: colors.grid,
                        drawBorder: false
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        color: colors.text,
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    grid: {
                        color: colors.grid,
                        drawBorder: false
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

// Update chart themes when theme changes
function updateChartThemes() {
    const colors = getThemeColors();
    
    if (effectivenessChart) {
        effectivenessChart.options.scales.y.ticks.color = colors.text;
        effectivenessChart.options.scales.x.ticks.color = colors.text;
        effectivenessChart.options.scales.y.grid.color = colors.grid;
        effectivenessChart.options.plugins.tooltip.backgroundColor = colors.background;
        effectivenessChart.options.plugins.tooltip.titleColor = colors.text;
        effectivenessChart.options.plugins.tooltip.bodyColor = colors.text;
        effectivenessChart.options.plugins.tooltip.borderColor = colors.grid;
        effectivenessChart.update();
    }
    
    if (accuracyChart) {
        accuracyChart.options.scales.y.ticks.color = colors.text;
        accuracyChart.options.scales.x.ticks.color = colors.text;
        accuracyChart.options.scales.y.grid.color = colors.grid;
        accuracyChart.options.scales.x.grid.color = colors.grid;
        accuracyChart.options.plugins.legend.labels.color = colors.text;
        accuracyChart.options.plugins.tooltip.backgroundColor = colors.background;
        accuracyChart.options.plugins.tooltip.titleColor = colors.text;
        accuracyChart.options.plugins.tooltip.bodyColor = colors.text;
        accuracyChart.options.plugins.tooltip.borderColor = colors.grid;
        accuracyChart.update();
    }
}

// Enhanced chart switching with animations
function switchChart(type) {
    const effectivenessDiv = document.getElementById('effectiveness-chart');
    const accuracyDiv = document.getElementById('accuracy-chart');
    const buttons = document.querySelectorAll('[onclick*="switchChart"]');
    
    // Update button states
    buttons.forEach(btn => {
        btn.classList.remove('bg-blue-500', 'text-white');
        btn.classList.add('border-blue-500', 'text-blue-500');
    });
    
    if (type === 'effectiveness') {
        effectivenessDiv.classList.remove('hidden');
        accuracyDiv.classList.add('hidden');
        buttons[0].classList.remove('border-blue-500', 'text-blue-500');
        buttons[0].classList.add('bg-blue-500', 'text-white');
        
        // Animate effectiveness chart if it exists
        if (effectivenessChart) {
            effectivenessChart.update('active');
        }
    } else {
        effectivenessDiv.classList.add('hidden');
        accuracyDiv.classList.remove('hidden');
        buttons[1].classList.remove('border-blue-500', 'text-blue-500');
        buttons[1].classList.add('bg-blue-500', 'text-white');
        
        // Animate accuracy chart if it exists
        if (accuracyChart) {
            accuracyChart.update('active');
        }
    }
}

// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Create charts
    createEffectivenessChart();
    createAccuracyChart();
    
    // Add chart action buttons
    addChartActions();
    
    // Set initial active button
    const buttons = document.querySelectorAll('[onclick*="switchChart"]');
    if (buttons[0]) {
        buttons[0].classList.remove('border-blue-500', 'text-blue-500');
        buttons[0].classList.add('bg-blue-500', 'text-white');
    }
    
    // Listen for theme changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                updateChartThemes();
            }
        });
    });
    
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch(e.key) {
                case '1':
                    e.preventDefault();
                    switchChart('effectiveness');
                    break;
                case '2':
                    e.preventDefault();
                    switchChart('accuracy');
                    break;
                case 'p':
                    e.preventDefault();
                    printCharts();
                    break;
                case 'e':
                    e.preventDefault();
                    exportChartData();
                    break;
                case 'r':
                    e.preventDefault();
                    resetCharts();
                    break;
            }
        }
    });
});
</script>
@endpush
@endsection


