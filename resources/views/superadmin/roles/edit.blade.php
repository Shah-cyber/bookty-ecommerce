@extends('layouts.superadmin')

@section('header', 'Edit Role')

@section('content')
    <div class="mb-6">
        <a href="{{ route('superadmin.roles.index') }}" class="flex items-center text-bookty-purple-600 hover:text-bookty-purple-800">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Roles
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-serif font-semibold text-bookty-black mb-6">Edit Role: {{ $role->name }}</h2>

            <form action="{{ route('superadmin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500 @error('name') border-red-500 @enderror"
                        {{ $role->name === 'superadmin' ? 'readonly' : '' }}>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($role->name === 'superadmin')
                        <p class="mt-1 text-sm text-gray-500">The superadmin role name cannot be changed.</p>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-bookty-black mb-4">Permissions</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($permissions as $permission)
                            <div class="flex items-center">
                                <input type="checkbox" name="permissions[]" id="permission_{{ $permission->id }}" value="{{ $permission->id }}"
                                    class="h-4 w-4 text-bookty-purple-600 focus:ring-bookty-purple-500 border-gray-300 rounded"
                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                    {{ $role->name === 'superadmin' ? 'checked disabled' : '' }}>
                                <label for="permission_{{ $permission->id }}" class="ml-2 block text-sm text-gray-900">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($role->name === 'superadmin')
                        <p class="mt-1 text-sm text-gray-500">The superadmin role has all permissions by default.</p>
                        @foreach($permissions as $permission)
                            <input type="hidden" name="permissions[]" value="{{ $permission->id }}">
                        @endforeach
                    @endif
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700 transition-colors duration-200">
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
