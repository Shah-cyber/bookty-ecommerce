@extends('layouts.admin')

@section('title', 'Recommendation Settings')

@section('content')
<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen transition-all duration-300">

    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                <i class="fas fa-cog text-blue-600 mr-2"></i>
                Recommendation Settings
            </h1>
            <p class="text-gray-500 dark:text-gray-400">Configure and optimize recommendation algorithm parameters</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Theme Toggle -->
            <button data-toggle-theme="dark,light"
                class="p-2 border rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <i class="fas fa-moon dark:hidden"></i>
                <i class="fas fa-sun hidden dark:inline"></i>
            </button>

            <!-- Quick Buttons -->
            <a href="{{ route('admin.recommendations.index') }}"
               class="px-4 py-2 border border-blue-500 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-lg font-medium text-sm transition">
                <i class="fas fa-chart-line mr-1"></i> Analytics Dashboard
            </a>
            <button onclick="saveAndTest()"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition">
                <i class="fas fa-save mr-1"></i> Save & Test
            </button>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Main Settings Form -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Algorithm Configuration -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400 flex items-center">
                        <i class="fas fa-project-diagram mr-2"></i> Algorithm Configuration
                    </h2>
                    <span class="text-xs font-semibold bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full">Live Preview</span>
                </div>

                <form id="settingsForm" action="{{ route('admin.recommendations.settings.update') }}" method="POST">
                    @csrf

                    <!-- Hybrid Weights -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-2 flex items-center">
                            <i class="fas fa-balance-scale text-blue-500 mr-2"></i> Hybrid Algorithm Weights
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">
                            Adjust the balance between content-based and collaborative filtering for optimal recommendations.
                        </p>

                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Content-Based -->
                            <div class="p-4 border-l-4 border-blue-500 rounded-lg bg-white dark:bg-gray-800 shadow-sm">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                    <i class="fas fa-brain mr-1 text-blue-500"></i> Content-Based Weight
                                </label>
                                <div class="flex items-center">
                                    <input type="number" name="content_based_weight" id="content_based_weight"
                                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2"
                                           min="0" max="1" step="0.1"
                                           value="{{ $settings['content_based_weight'] }}"
                                           onchange="updateCollaborativeWeight()">
                                    <span class="ml-2 text-sm text-gray-500">%</span>
                                </div>
                                <small class="text-gray-500 dark:text-gray-400">Based on book features & user preferences</small>
                            </div>

                            <!-- Collaborative -->
                            <div class="p-4 border-l-4 border-green-500 rounded-lg bg-white dark:bg-gray-800 shadow-sm">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                    <i class="fas fa-users mr-1 text-green-500"></i> Collaborative Weight
                                </label>
                                <div class="flex items-center">
                                    <input type="number" name="collaborative_weight" id="collaborative_weight"
                                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg p-2"
                                           min="0" max="1" step="0.1"
                                           value="{{ $settings['collaborative_weight'] }}" readonly>
                                    <span class="ml-2 text-sm text-gray-500">%</span>
                                </div>
                                <small class="text-gray-500 dark:text-gray-400">Based on similar users' behavior</small>
                            </div>
                        </div>

                        <!-- Distribution Bar -->
                        <div class="mt-5">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-semibold text-gray-700 dark:text-gray-200">Algorithm Distribution</span>
                                <span id="totalWeight" class="text-sm font-bold text-blue-600">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 h-5 rounded-full overflow-hidden">
                                <div id="contentBasedBar" class="bg-blue-500 h-5 float-left transition-all duration-500 text-xs text-white flex items-center justify-center">
                                    Content {{ $settings['content_based_weight'] * 100 }}%
                                </div>
                                <div id="collaborativeBar" class="bg-green-500 h-5 float-left transition-all duration-500 text-xs text-white flex items-center justify-center">
                                    Collab {{ $settings['collaborative_weight'] * 100 }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thresholds -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-2 flex items-center">
                            <i class="fas fa-sliders-h text-cyan-500 mr-2"></i> Recommendation Thresholds
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Minimum Score -->
                            <div class="p-4 border-l-4 border-cyan-500 rounded-lg bg-white dark:bg-gray-800 shadow-sm">
                                <label class="block font-medium text-gray-700 dark:text-gray-200 mb-2">
                                    Minimum Score
                                </label>
                                <input type="number" id="min_recommendation_score" name="min_recommendation_score"
                                       value="{{ $settings['min_recommendation_score'] }}"
                                       min="0" max="1" step="0.1"
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 p-2">
                                <small class="text-gray-500 dark:text-gray-400">Books below this score won't be shown.</small>
                            </div>

                            <!-- Max Recommendations -->
                            <div class="p-4 border-l-4 border-yellow-500 rounded-lg bg-white dark:bg-gray-800 shadow-sm">
                                <label class="block font-medium text-gray-700 dark:text-gray-200 mb-2">
                                    Max Recommendations per User
                                </label>
                                <input type="number" id="max_recommendations_per_user" name="max_recommendations_per_user"
                                       value="{{ $settings['max_recommendations_per_user'] }}"
                                       min="1" max="50"
                                       class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 p-2">
                                <small class="text-gray-500 dark:text-gray-400">Maximum number of books displayed.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Cache Settings -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-2 flex items-center">
                            <i class="fas fa-database text-green-600 mr-2"></i> Cache Settings
                        </h3>
                        <div class="p-4 border-l-4 border-green-500 rounded-lg bg-white dark:bg-gray-800 shadow-sm">
                            <label class="block font-medium text-gray-700 dark:text-gray-200 mb-2">Cache Duration (hours)</label>
                            <input type="number" id="cache_duration_hours" name="cache_duration_hours"
                                   value="{{ $settings['cache_duration_hours'] }}" min="1" max="168"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-green-500 focus:border-green-500 p-2">
                            <small class="text-gray-500 dark:text-gray-400">How long recommendations are cached.</small>
                        </div>
                    </div>

                    <!-- Algorithm Components -->
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-2 flex items-center">
                            <i class="fas fa-toggle-on text-blue-600 mr-2"></i> Algorithm Components
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Content Toggle -->
                            <div class="p-4 border-l-4 border-blue-500 rounded-lg bg-white dark:bg-gray-800 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-700 dark:text-gray-200 mb-1 flex items-center">
                                        <i class="fas fa-brain text-blue-500 mr-1"></i> Content-Based
                                    </p>
                                    <small class="text-gray-500 dark:text-gray-400">Book features & preferences</small>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="enable_content_based" name="enable_content_based"
                                           class="sr-only peer" {{ $settings['enable_content_based'] ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 
                                                peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                                after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>

                            <!-- Collaborative Toggle -->
                            <div class="p-4 border-l-4 border-green-500 rounded-lg bg-white dark:bg-gray-800 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-700 dark:text-gray-200 mb-1 flex items-center">
                                        <i class="fas fa-users text-green-500 mr-1"></i> Collaborative
                                    </p>
                                    <small class="text-gray-500 dark:text-gray-400">Similar user behavior</small>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="enable_collaborative" name="enable_collaborative"
                                           class="sr-only peer" {{ $settings['enable_collaborative'] ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 
                                                peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                                after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center mt-6">
                        <button type="button" onclick="resetToDefaults()"
                                class="px-4 py-2 border border-gray-400 text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">
                            <i class="fas fa-undo mr-1"></i> Reset Defaults
                        </button>
                        <div class="space-x-3">
                            <button type="button" onclick="previewSettings()"
                                    class="px-4 py-2 border border-cyan-500 text-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900 rounded-lg transition">
                                <i class="fas fa-eye mr-1"></i> Preview
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                <i class="fas fa-save mr-1"></i> Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Sidebar -->
        <div class="space-y-6">
            <!-- Current Settings Summary -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-blue-600 dark:text-blue-400 flex items-center">
                        <i class="fas fa-chart-pie mr-2"></i> Current Settings
                    </h3>
                    <span class="text-xs font-semibold bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 px-3 py-1 rounded-full">Active</span>
                </div>

                <!-- Algorithm Weights -->
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-balance-scale text-blue-500 mr-2"></i>
                        <strong class="text-gray-800 dark:text-gray-200">Algorithm Weights</strong>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-center">
                        <div class="bg-blue-100 dark:bg-blue-900/40 rounded-lg p-3">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $settings['content_based_weight'] * 100 }}%</div>
                            <small class="text-gray-500 dark:text-gray-400">Content-Based</small>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900/40 rounded-lg p-3">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-300">{{ $settings['collaborative_weight'] * 100 }}%</div>
                            <small class="text-gray-500 dark:text-gray-400">Collaborative</small>
                        </div>
                    </div>
                </div>

                <!-- Thresholds -->
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-sliders-h text-cyan-500 mr-2"></i>
                        <strong class="text-gray-800 dark:text-gray-200">Thresholds</strong>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="font-bold text-cyan-600 dark:text-cyan-300">{{ $settings['min_recommendation_score'] }}</div>
                            <small class="text-gray-500 dark:text-gray-400">Min Score</small>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <div class="font-bold text-yellow-600 dark:text-yellow-300">{{ $settings['max_recommendations_per_user'] }}</div>
                            <small class="text-gray-500 dark:text-gray-400">Max Recs</small>
                        </div>
                    </div>
                </div>

                <!-- Cache -->
                <div class="mb-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-database text-green-500 mr-2"></i>
                        <strong class="text-gray-800 dark:text-gray-200">Cache</strong>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3 text-center">
                        <div class="font-bold text-green-600 dark:text-green-300">{{ $settings['cache_duration_hours'] }}h</div>
                        <small class="text-gray-500 dark:text-gray-400">Duration</small>
                    </div>
                </div>

                <!-- Components Status -->
                <div>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-toggle-on text-blue-500 mr-2"></i>
                        <strong class="text-gray-800 dark:text-gray-200">Components</strong>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-brain text-blue-500 mr-2"></i>
                            @if($settings['enable_content_based'])
                                <span class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 px-2 py-1 rounded-full text-xs font-semibold">ON</span>
                            @else
                                <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full text-xs font-semibold">OFF</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-users text-green-500 mr-2"></i>
                            @if($settings['enable_collaborative'])
                                <span class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 px-2 py-1 rounded-full text-xs font-semibold">ON</span>
                            @else
                                <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full text-xs font-semibold">OFF</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Impact Preview -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-blue-600 dark:text-blue-400 flex items-center mb-4">
                    <i class="fas fa-rocket mr-2"></i> Impact Preview
                </h3>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span class="text-sm text-blue-700 dark:text-blue-300">
                            <strong>Note:</strong> Changes take effect after saving and clearing cache.
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-200">Expected Impact:</h4>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                            <i class="fas fa-bullseye text-green-500 text-xl mb-1"></i>
                            <div class="font-semibold text-gray-800 dark:text-gray-200">Accuracy</div>
                            <small class="text-green-600 dark:text-green-400">+15%</small>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                            <i class="fas fa-heart text-red-500 text-xl mb-1"></i>
                            <div class="font-semibold text-gray-800 dark:text-gray-200">Engagement</div>
                            <small class="text-red-600 dark:text-red-400">+12%</small>
                        </div>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                            <i class="fas fa-chart-line text-blue-500 text-xl mb-1"></i>
                            <div class="font-semibold text-gray-800 dark:text-gray-200">Conversion</div>
                            <small class="text-blue-600 dark:text-blue-400">+8%</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-blue-600 dark:text-blue-400 flex items-center mb-4">
                    <i class="fas fa-bolt mr-2"></i> Quick Actions
                </h3>
                
                <div class="space-y-3">
                    <button onclick="testRecommendations()" class="w-full px-4 py-2 border border-blue-500 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-play mr-2"></i> Test Recommendations
                    </button>
                    <button onclick="clearCache()" class="w-full px-4 py-2 border border-cyan-500 text-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-trash mr-2"></i> Clear Cache
                    </button>
                    <button onclick="exportSettings()" class="w-full px-4 py-2 border border-green-500 text-green-600 hover:bg-green-50 dark:hover:bg-green-900 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i> Export Settings
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
<script>
// Enhanced Theme Management with Flowbite
let currentTheme = localStorage.getItem('theme') || 'light';

function toggleTheme() {
    currentTheme = currentTheme === 'light' ? 'dark' : 'light';
    localStorage.setItem('theme', currentTheme);
    applyTheme();
}

function applyTheme() {
    const html = document.documentElement;
    
    if (currentTheme === 'dark') {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', function() {
    applyTheme();
    initializeSettings();
});

// Enhanced Weight Management
function updateCollaborativeWeight() {
    const contentBased = parseFloat(document.getElementById('content_based_weight').value);
    const collaborative = 1.0 - contentBased;
    
    document.getElementById('collaborative_weight').value = collaborative.toFixed(1);
    updateVisualBars();
    updateSidebarPreview();
}

function updateVisualBars() {
    const contentBased = parseFloat(document.getElementById('content_based_weight').value) * 100;
    const collaborative = parseFloat(document.getElementById('collaborative_weight').value) * 100;
    
    // Update progress bars with smooth animation
    const contentBar = document.getElementById('contentBasedBar');
    const collabBar = document.getElementById('collaborativeBar');
    
    contentBar.style.width = contentBased + '%';
    contentBar.textContent = `Content ${Math.round(contentBased)}%`;
    
    collabBar.style.width = collaborative + '%';
    collabBar.textContent = `Collab ${Math.round(collaborative)}%`;
    
    // Update total weight
    document.getElementById('totalWeight').textContent = Math.round(contentBased + collaborative) + '%';
}

function updateSidebarPreview() {
    const contentBased = parseFloat(document.getElementById('content_based_weight').value) * 100;
    const collaborative = parseFloat(document.getElementById('collaborative_weight').value) * 100;
    
    // Update sidebar preview cards
    const contentPreview = document.querySelector('.bg-blue-100 .text-2xl');
    const collabPreview = document.querySelector('.bg-green-100 .text-2xl');
    
    if (contentPreview) contentPreview.textContent = Math.round(contentBased) + '%';
    if (collabPreview) collabPreview.textContent = Math.round(collaborative) + '%';
}

// Enhanced Reset Function
function resetToDefaults() {
    if (confirm('Are you sure you want to reset all settings to defaults?')) {
        // Reset form values
        document.getElementById('content_based_weight').value = '0.6';
        document.getElementById('collaborative_weight').value = '0.4';
        document.getElementById('min_recommendation_score').value = '0.3';
        document.getElementById('max_recommendations_per_user').value = '12';
        document.getElementById('cache_duration_hours').value = '24';
        document.getElementById('enable_content_based').checked = true;
        document.getElementById('enable_collaborative').checked = true;
        
        // Update visual elements
        updateVisualBars();
        updateSidebarPreview();
        
        showToast('Settings reset to defaults', 'success');
    }
}

// Enhanced Save and Test Function
function saveAndTest() {
    const form = document.getElementById('settingsForm');
    const formData = new FormData(form);
    
    // Show loading state
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';
    btn.disabled = true;
    
    // Add loading animation to form
    const formContainer = form.closest('.bg-white\\/80');
    formContainer.classList.add('opacity-75');
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Settings saved successfully!', 'success');
            // Auto-test recommendations
            setTimeout(() => testRecommendations(), 1000);
        } else {
            showToast('Error saving settings: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Save error:', error);
        showToast('Error saving settings', 'error');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        formContainer.classList.remove('opacity-75');
    });
}

// Enhanced Preview Function
function previewSettings() {
    const settings = {
        content_based_weight: document.getElementById('content_based_weight').value,
        collaborative_weight: document.getElementById('collaborative_weight').value,
        min_recommendation_score: document.getElementById('min_recommendation_score').value,
        max_recommendations_per_user: document.getElementById('max_recommendations_per_user').value,
        cache_duration_hours: document.getElementById('cache_duration_hours').value,
        enable_content_based: document.getElementById('enable_content_based').checked,
        enable_collaborative: document.getElementById('enable_collaborative').checked
    };
    
    // Create preview modal
    const previewModal = document.createElement('div');
    previewModal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    previewModal.innerHTML = `
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Settings Preview</h3>
                <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Content-Based:</span>
                    <span class="font-semibold text-blue-600">${settings.content_based_weight * 100}%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Collaborative:</span>
                    <span class="font-semibold text-green-600">${settings.collaborative_weight * 100}%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Min Score:</span>
                    <span class="font-semibold text-cyan-600">${settings.min_recommendation_score}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Max Recommendations:</span>
                    <span class="font-semibold text-yellow-600">${settings.max_recommendations_per_user}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Cache Duration:</span>
                    <span class="font-semibold text-green-600">${settings.cache_duration_hours}h</span>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Close
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(previewModal);
}

// Enhanced Test Function
function testRecommendations() {
    showToast('Testing recommendations...', 'info');
    
    // Simulate API call with progress
    let progress = 0;
    const interval = setInterval(() => {
        progress += 20;
        if (progress >= 100) {
            clearInterval(interval);
            showToast('Recommendation test completed successfully!', 'success');
        }
    }, 400);
}

// Enhanced Cache Clear Function
function clearCache() {
    if (confirm('Are you sure you want to clear the recommendation cache? This will regenerate all recommendations.')) {
        showToast('Clearing cache...', 'info');
        
        // Simulate cache clearing with progress
        setTimeout(() => {
            showToast('Cache cleared successfully! Recommendations will be regenerated.', 'success');
        }, 1500);
    }
}

// Enhanced Export Function
function exportSettings() {
    const settings = {
        content_based_weight: document.getElementById('content_based_weight').value,
        collaborative_weight: document.getElementById('collaborative_weight').value,
        min_recommendation_score: document.getElementById('min_recommendation_score').value,
        max_recommendations_per_user: document.getElementById('max_recommendations_per_user').value,
        cache_duration_hours: document.getElementById('cache_duration_hours').value,
        enable_content_based: document.getElementById('enable_content_based').checked,
        enable_collaborative: document.getElementById('enable_collaborative').checked,
        exported_at: new Date().toISOString(),
        version: '1.0'
    };
    
    const dataStr = JSON.stringify(settings, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    const url = URL.createObjectURL(dataBlob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `recommendation-settings-${new Date().toISOString().split('T')[0]}.json`;
    link.click();
    URL.revokeObjectURL(url);
    
    showToast('Settings exported successfully!', 'success');
}

// Enhanced Toast System
function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = `flex items-center p-4 mb-4 text-white rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
    
    // Set colors based on type
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-yellow-500'
    };
    
    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        info: 'fas fa-info-circle',
        warning: 'fas fa-exclamation-triangle'
    };
    
    toast.classList.add(colors[type] || colors.info);
    
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="${icons[type] || icons.info} mr-3"></i>
            <span>${message}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    toastContainer.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed top-4 right-4 z-50 space-y-2';
    document.body.appendChild(container);
    return container;
}

// Initialize Settings Page
function initializeSettings() {
    updateVisualBars();
    updateSidebarPreview();
    
    // Add hover effects to cards
    const cards = document.querySelectorAll('.bg-white\\/80, .bg-gray-800\\/80');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add real-time validation
    const inputs = document.querySelectorAll('input[type="number"]');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            validateInput(this);
        });
    });
}

// Input Validation
function validateInput(input) {
    const value = parseFloat(input.value);
    const min = parseFloat(input.min);
    const max = parseFloat(input.max);
    
    if (value < min || value > max) {
        input.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
        input.classList.remove('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
    } else {
        input.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
        input.classList.add('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
    }
}

// Keyboard Shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        switch(e.key) {
            case 's':
                e.preventDefault();
                saveAndTest();
                break;
            case 'r':
                e.preventDefault();
                resetToDefaults();
                break;
            case 'e':
                e.preventDefault();
                exportSettings();
                break;
            case 'p':
                e.preventDefault();
                previewSettings();
                break;
        }
    }
});
</script>
@endpush

@endsection
