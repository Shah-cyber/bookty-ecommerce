@extends('layouts.superadmin')

@section('header', 'Permission Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('superadmin.permissions.index') }}" class="flex items-center text-bookty-purple-600 hover:text-bookty-purple-800">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Permissions
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-serif font-semibold text-bookty-black mb-6">Permission: {{ $permission->name }}</h2>

            <div class="mb-8">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $permission->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Guard</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $permission->guard_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $permission->created_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $permission->updated_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-medium text-bookty-black mb-4">Assigned to Roles</h3>
                
                @if($permission->roles->isEmpty())
                    <p class="text-gray-500">This permission is not assigned to any role.</p>
                @else
                    <div class="flex flex-wrap gap-2">
                        @foreach($permission->roles as $role)
                            <span class="px-3 py-1 bg-bookty-purple-100 text-bookty-purple-800 rounded-full text-sm">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-8 flex space-x-4">
                <a href="{{ route('superadmin.permissions.edit', $permission) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                    Edit Permission
                </a>
                <form action="{{ route('superadmin.permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200">
                        Delete Permission
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
