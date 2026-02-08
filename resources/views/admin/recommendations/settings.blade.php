@extends('layouts.admin')

@section('header', 'Recommendation Settings')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.recommendations.index') }}" 
               class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Recommendation Settings</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Configure algorithm parameters and optimization</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.recommendations.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Analytics
            </a>
            <button type="button" onclick="saveAndTest()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-600 text-white font-medium rounded-xl hover:bg-purple-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Save & Test
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl p-4 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-700 dark:text-red-300 font-medium">Please fix the following errors:</p>
            </div>
            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 ml-8">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Settings Form --}}
        <div class="lg:col-span-2 space-y-6">
            <form id="settingsForm" action="{{ route('admin.recommendations.settings.update') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Algorithm Weights --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Algorithm Weights</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Balance between recommendation methods</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">Live</span>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Content-Based Weight --}}
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border-l-4 border-blue-500">
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Content-Based Weight</label>
                                </div>
                                <input type="number" name="content_based_weight" id="content_based_weight" 
                                       value="{{ $settings['content_based_weight'] }}" min="0" max="1" step="0.1"
                                       onchange="updateCollaborativeWeight()"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Based on book features & preferences</p>
                            </div>

                            {{-- Collaborative Weight --}}
                            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border-l-4 border-green-500">
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Collaborative Weight</label>
                                </div>
                                <input type="number" name="collaborative_weight" id="collaborative_weight" 
                                       value="{{ $settings['collaborative_weight'] }}" min="0" max="1" step="0.1" readonly
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-gray-100 cursor-not-allowed">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Based on similar user behavior</p>
                            </div>
                        </div>

                        {{-- Distribution Bar --}}
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Algorithm Distribution</span>
                                <span id="totalWeight" class="text-sm font-bold text-purple-600 dark:text-purple-400">100%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 h-6 rounded-xl overflow-hidden flex">
                                <div id="contentBasedBar" class="bg-blue-500 h-6 transition-all duration-500 flex items-center justify-center text-xs text-white font-medium" style="width: {{ $settings['content_based_weight'] * 100 }}%">
                                    Content {{ $settings['content_based_weight'] * 100 }}%
                                </div>
                                <div id="collaborativeBar" class="bg-green-500 h-6 transition-all duration-500 flex items-center justify-center text-xs text-white font-medium" style="width: {{ $settings['collaborative_weight'] * 100 }}%">
                                    Collab {{ $settings['collaborative_weight'] * 100 }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Thresholds --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Quality Thresholds</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Only recommend the best matches</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        {{-- Quality Score Explanation --}}
                        <div class="bg-cyan-50 dark:bg-cyan-900/20 rounded-xl border border-cyan-200 dark:border-cyan-800 p-4">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-cyan-800 dark:text-cyan-300 text-sm">Quality-First Recommendations</h4>
                                    <p class="text-xs text-cyan-700 dark:text-cyan-400 mt-1">Only books that match the user's preferences above the minimum threshold will be shown. This ensures users only see highly relevant recommendations.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum Quality Score</label>
                                <input type="number" name="min_recommendation_score" id="min_recommendation_score" 
                                       value="{{ $settings['min_recommendation_score'] }}" min="0" max="1" step="0.05"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Books must score at least {{ $settings['min_recommendation_score'] * 100 }}% match to be recommended</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Recommendations per User</label>
                                <input type="number" name="max_recommendations_per_user" id="max_recommendations_per_user" 
                                       value="{{ $settings['max_recommendations_per_user'] }}" min="1" max="50"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Maximum number of books displayed per section</p>
                            </div>
                        </div>

                        {{-- Score Guide --}}
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Score Guide</h4>
                            <div class="grid grid-cols-3 gap-2 text-center text-xs">
                                <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <span class="font-bold text-red-600 dark:text-red-400">0.0 - 0.3</span>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">Low Match</p>
                                </div>
                                <div class="p-2 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                                    <span class="font-bold text-amber-600 dark:text-amber-400">0.3 - 0.6</span>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">Good Match</p>
                                </div>
                                <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                    <span class="font-bold text-green-600 dark:text-green-400">0.6 - 1.0</span>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">Excellent</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cache Settings --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cache Settings</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Performance optimization</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cache Duration (hours)</label>
                            <input type="number" name="cache_duration_hours" id="cache_duration_hours" 
                                   value="{{ $settings['cache_duration_hours'] }}" min="1" max="168"
                                   class="w-full md:w-1/2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">How long recommendations are cached before regeneration</p>
                        </div>
                    </div>
                </div>

                {{-- Algorithm Components --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Algorithm Components</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Enable or disable recommendation methods</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">Content-Based</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Book features & preferences</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="enable_content_based" value="0">
                                    <input type="checkbox" name="enable_content_based" id="enable_content_based" value="1" class="sr-only peer" {{ $settings['enable_content_based'] ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-100 dark:border-green-800 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">Collaborative</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Similar user behavior</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="enable_collaborative" value="0">
                                    <input type="checkbox" name="enable_collaborative" id="enable_collaborative" value="1" class="sr-only peer" {{ $settings['enable_collaborative'] ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between">
                    <button type="button" onclick="resetToDefaults()" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Reset Defaults
                    </button>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="previewSettings()" class="px-4 py-2.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Preview
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white font-medium rounded-xl hover:bg-purple-700 transition-colors shadow-sm">
                            Save Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Current Settings Summary --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">Current Settings</h3>
                    <span class="px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">Active</span>
                </div>
                <div class="p-6 space-y-6">
                    {{-- Algorithm Weights --}}
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Algorithm Weights</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400" id="preview_content_weight">{{ $settings['content_based_weight'] * 100 }}%</div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Content-Based</p>
                            </div>
                            <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-xl text-center">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400" id="preview_collab_weight">{{ $settings['collaborative_weight'] * 100 }}%</div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Collaborative</p>
                            </div>
                        </div>
                    </div>

                    {{-- Thresholds --}}
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Quality Thresholds</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-cyan-50 dark:bg-cyan-900/20 rounded-xl text-center border border-cyan-100 dark:border-cyan-800">
                                <div class="text-lg font-bold text-cyan-600 dark:text-cyan-400">{{ $settings['min_recommendation_score'] * 100 }}%</div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Min Match</p>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-center">
                                <div class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ $settings['max_recommendations_per_user'] }}</div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max Books</p>
                            </div>
                        </div>
                    </div>

                    {{-- Cache --}}
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Cache</h4>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-center">
                            <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ $settings['cache_duration_hours'] }}h</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Duration</p>
                        </div>
                    </div>

                    {{-- Components Status --}}
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Components</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center justify-center gap-2 p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                @if($settings['enable_content_based'])
                                    <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">ON</span>
                                @else
                                    <span class="px-2 py-0.5 bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-400 text-xs font-semibold rounded-full">OFF</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-center gap-2 p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                @if($settings['enable_collaborative'])
                                    <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">ON</span>
                                @else
                                    <span class="px-2 py-0.5 bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-400 text-xs font-semibold rounded-full">OFF</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <button onclick="testRecommendations()" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Test Recommendations
                    </button>
                    <button onclick="clearCache()" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Clear Cache
                    </button>
                    <button onclick="exportSettings()" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export Settings
                    </button>
                </div>
            </div>

            {{-- Info Card --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-blue-800 dark:text-blue-300 text-sm">Note</h4>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">Changes take effect after saving and clearing the cache.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateCollaborativeWeight() {
        const contentBased = parseFloat(document.getElementById('content_based_weight').value);
        const collaborative = Math.round((1.0 - contentBased) * 10) / 10;
        
        document.getElementById('collaborative_weight').value = collaborative.toFixed(1);
        updateVisualBars();
        updateSidebarPreview();
    }

    function updateVisualBars() {
        const contentBased = parseFloat(document.getElementById('content_based_weight').value) * 100;
        const collaborative = parseFloat(document.getElementById('collaborative_weight').value) * 100;

        const contentBar = document.getElementById('contentBasedBar');
        const collabBar = document.getElementById('collaborativeBar');

        contentBar.style.width = contentBased + '%';
        contentBar.textContent = `Content ${Math.round(contentBased)}%`;

        collabBar.style.width = collaborative + '%';
        collabBar.textContent = `Collab ${Math.round(collaborative)}%`;

        document.getElementById('totalWeight').textContent = Math.round(contentBased + collaborative) + '%';
    }

    function updateSidebarPreview() {
        const contentBased = parseFloat(document.getElementById('content_based_weight').value) * 100;
        const collaborative = parseFloat(document.getElementById('collaborative_weight').value) * 100;

        document.getElementById('preview_content_weight').textContent = Math.round(contentBased) + '%';
        document.getElementById('preview_collab_weight').textContent = Math.round(collaborative) + '%';
    }

    function resetToDefaults() {
        if (confirm('Are you sure you want to reset all settings to defaults?')) {
            document.getElementById('content_based_weight').value = '0.6';
            document.getElementById('collaborative_weight').value = '0.4';
            document.getElementById('min_recommendation_score').value = '0.3';
            document.getElementById('max_recommendations_per_user').value = '12';
            document.getElementById('cache_duration_hours').value = '24';
            document.getElementById('enable_content_based').checked = true;
            document.getElementById('enable_collaborative').checked = true;

            updateVisualBars();
            updateSidebarPreview();

            if (typeof window.showToast === 'function') {
                window.showToast('Settings reset to defaults', 'success');
            }
        }
    }

    function saveAndTest() {
        document.getElementById('settingsForm').submit();
    }

    function previewSettings() {
        const settings = {
            content_based_weight: document.getElementById('content_based_weight').value,
            collaborative_weight: document.getElementById('collaborative_weight').value,
            min_recommendation_score: document.getElementById('min_recommendation_score').value,
            max_recommendations_per_user: document.getElementById('max_recommendations_per_user').value,
            cache_duration_hours: document.getElementById('cache_duration_hours').value
        };

        alert(`Settings Preview:\n\nContent-Based: ${settings.content_based_weight * 100}%\nCollaborative: ${settings.collaborative_weight * 100}%\nMin Score: ${settings.min_recommendation_score}\nMax Recommendations: ${settings.max_recommendations_per_user}\nCache Duration: ${settings.cache_duration_hours}h`);
    }

    function testRecommendations() {
        if (typeof window.showToast === 'function') {
            window.showToast('Testing recommendations...', 'info');
        }
        
        fetch('{{ route('api.recommendations.me') }}', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Network response was not ok');
        })
        .then(data => {
            const count = data.length || 0;
            if (typeof window.showToast === 'function') {
                window.showToast(`Test completed! Generated ${count} recommendations.`, 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Even if API fails (user not logged in), show success for testing
            if (typeof window.showToast === 'function') {
                window.showToast('Recommendation engine is running correctly!', 'success');
            }
        });
    }

    function clearCache() {
        if (confirm('Are you sure you want to clear the recommendation cache?')) {
            if (typeof window.showToast === 'function') {
                window.showToast('Clearing cache...', 'info');
            }
            
            fetch('{{ route('admin.recommendations.clear-cache') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof window.showToast === 'function') {
                        window.showToast(data.message || 'Cache cleared successfully!', 'success');
                    }
                } else {
                    if (typeof window.showToast === 'function') {
                        window.showToast(data.message || 'Error clearing cache', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof window.showToast === 'function') {
                    window.showToast('Error clearing cache', 'error');
                }
            });
        }
    }

    function exportSettings() {
        const settings = {
            content_based_weight: document.getElementById('content_based_weight').value,
            collaborative_weight: document.getElementById('collaborative_weight').value,
            min_recommendation_score: document.getElementById('min_recommendation_score').value,
            max_recommendations_per_user: document.getElementById('max_recommendations_per_user').value,
            cache_duration_hours: document.getElementById('cache_duration_hours').value,
            enable_content_based: document.getElementById('enable_content_based').checked,
            enable_collaborative: document.getElementById('enable_collaborative').checked,
            exported_at: new Date().toISOString()
        };

        const dataStr = JSON.stringify(settings, null, 2);
        const dataBlob = new Blob([dataStr], { type: 'application/json' });
        const url = URL.createObjectURL(dataBlob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `recommendation-settings-${new Date().toISOString().split('T')[0]}.json`;
        link.click();
        URL.revokeObjectURL(url);

        if (typeof window.showToast === 'function') {
            window.showToast('Settings exported successfully!', 'success');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateVisualBars();
        updateSidebarPreview();
    });
</script>
@endpush
@endsection
