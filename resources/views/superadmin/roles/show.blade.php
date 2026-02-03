@extends('layouts.superadmin')

@section('header', 'Role Details')

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
            <h2 class="text-2xl font-serif font-semibold text-bookty-black mb-6">Role: {{ $role->name }}</h2>

            <div class="mb-8">
                <h3 class="text-lg font-medium text-bookty-black mb-4">Permissions</h3>
                
                @if($role->permissions->isEmpty())
                    <p class="text-gray-500">This role has no permissions assigned.</p>
                @else
                    <div class="flex flex-wrap gap-2">
                        @foreach($role->permissions as $permission)
                            <span class="px-3 py-1 bg-bookty-purple-100 text-bookty-purple-800 rounded-full text-sm">
                                {{ $permission->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-8 flex space-x-4">
                <a href="{{ route('superadmin.roles.edit', $role) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                    Edit Role
                </a>
                @if(!in_array($role->name, ['superadmin', 'admin', 'customer']))
                    <form action="{{ route('superadmin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200">
                            Delete Role
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
