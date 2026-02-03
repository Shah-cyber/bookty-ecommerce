@extends('layouts.superadmin')

@section('header', 'Edit Role')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Back Button --}}
    <a href="{{ route('superadmin.roles.index') }}" 
       class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400 transition-colors group">
        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Roles
    </a>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
            <div class="flex items-center gap-4">
                @if($role->name === 'superadmin')
                    <div class="p-3 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl shadow-lg shadow-amber-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                @elseif($role->name === 'admin')
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl shadow-lg shadow-purple-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                @else
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg shadow-blue-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Role: <span class="capitalize">{{ $role->name }}</span></h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Modify role settings and permissions</p>
                </div>
            </div>
        </div>

        @if($role->name === 'superadmin')
            <div class="px-6 py-3 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-100 dark:border-amber-900/30">
                <div class="flex items-center gap-2 text-amber-700 dark:text-amber-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Superadmin role has all permissions by default and cannot be modified.</span>
                </div>
            </div>
        @endif

        <form action="{{ route('superadmin.roles.update', $role) }}" method="POST" class="p-6 space-y-8">
            @csrf
            @method('PUT')

            {{-- Role Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Role Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('name') border-red-500 ring-1 ring-red-500 @enderror {{ $role->name === 'superadmin' ? 'opacity-60 cursor-not-allowed' : '' }}"
                    {{ $role->name === 'superadmin' ? 'readonly' : '' }}>
                @if($role->name === 'superadmin')
                    <p class="mt-2 text-xs text-amber-600 dark:text-amber-400">The superadmin role name cannot be changed.</p>
                @endif
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Permissions Section --}}
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Permissions</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            @if($role->name === 'superadmin')
                                All permissions are enabled for superadmin
                            @else
                                Update the permissions for this role
                            @endif
                        </p>
                    </div>
                    @if($role->name !== 'superadmin')
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="selectAllPermissions()" class="text-xs font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 px-3 py-1.5 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-colors">
                                Select All
                            </button>
                            <button type="button" onclick="deselectAllPermissions()" class="text-xs font-medium text-gray-600 hover:text-gray-700 dark:text-gray-400 px-3 py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                Clear All
                            </button>
                        </div>
                    @endif
                </div>

                @php
                    $groupedPermissions = $permissions->groupBy(function($permission) {
                        $parts = explode(' ', $permission->name);
                        return count($parts) > 1 ? $parts[1] : 'other';
                    });
                @endphp

                <div class="space-y-4">
                    @foreach($groupedPermissions as $category => $categoryPermissions)
                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-100 dark:border-gray-700 {{ $role->name === 'superadmin' ? 'opacity-60' : '' }}">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 capitalize flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                {{ $category }}
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($categoryPermissions as $permission)
                                    <label class="relative flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 {{ $role->name === 'superadmin' ? 'cursor-not-allowed' : 'cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 hover:bg-purple-50 dark:hover:bg-purple-900/20' }} transition-all group">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            class="permission-checkbox h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 dark:border-gray-600 rounded transition-colors"
                                            {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                            {{ $role->name === 'superadmin' ? 'checked disabled' : '' }}>
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300 {{ $role->name !== 'superadmin' ? 'group-hover:text-purple-700 dark:group-hover:text-purple-300' : '' }} transition-colors">
                                            {{ $permission->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($role->name === 'superadmin')
                    @foreach($permissions as $permission)
                        <input type="hidden" name="permissions[]" value="{{ $permission->id }}">
                    @endforeach
                @endif

                @error('permissions')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('superadmin.roles.index') }}" 
                   class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:from-blue-700 hover:to-indigo-700 transition-all transform hover:-translate-y-0.5">
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function selectAllPermissions() {
    document.querySelectorAll('.permission-checkbox:not([disabled])').forEach(cb => cb.checked = true);
}
function deselectAllPermissions() {
    document.querySelectorAll('.permission-checkbox:not([disabled])').forEach(cb => cb.checked = false);
}
</script>
@endsection
