@extends('layouts.superadmin')

@section('header', 'Create Permission')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    {{-- Back Button --}}
    <a href="{{ route('superadmin.permissions.index') }}" 
       class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400 transition-colors group">
        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Permissions
    </a>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl shadow-lg shadow-purple-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Create New Permission</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Add a new permission to the system</p>
                </div>
            </div>
        </div>

        <form action="{{ route('superadmin.permissions.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            {{-- Permission Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Permission Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    placeholder="e.g., view reports, manage users"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('name') border-red-500 ring-1 ring-red-500 @enderror">
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Naming Convention Guide --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900/30 rounded-xl p-4">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-300 mb-1">Naming Convention</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-400 mb-2">Use descriptive names following the pattern: <code class="px-1.5 py-0.5 bg-blue-100 dark:bg-blue-900/50 rounded text-xs font-mono">action resource</code></p>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="text-blue-600 dark:text-blue-400">
                                <span class="font-medium">Examples:</span>
                                <ul class="mt-1 space-y-1 text-blue-700 dark:text-blue-300">
                                    <li>• view books</li>
                                    <li>• edit orders</li>
                                    <li>• delete users</li>
                                </ul>
                            </div>
                            <div class="text-blue-600 dark:text-blue-400">
                                <span class="font-medium">Actions:</span>
                                <ul class="mt-1 space-y-1 text-blue-700 dark:text-blue-300">
                                    <li>• view, create, edit, delete</li>
                                    <li>• manage, access, export</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('superadmin.permissions.index') }}" 
                   class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 hover:from-purple-700 hover:to-indigo-700 transition-all transform hover:-translate-y-0.5">
                    Create Permission
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
