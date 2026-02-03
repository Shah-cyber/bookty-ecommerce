@extends('layouts.superadmin')

@section('header', 'Admin Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('superadmin.admins.index') }}" class="flex items-center text-bookty-purple-600 hover:text-bookty-purple-800">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Admins
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="h-20 w-20 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                    <span class="text-2xl font-medium text-bookty-purple-800">{{ substr($admin->name, 0, 1) }}</span>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-serif font-semibold text-bookty-black">{{ $admin->name }}</h2>
                    <p class="text-gray-600">{{ $admin->email }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-bookty-black mb-4">Admin Information</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $admin->id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                Admin
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $admin->created_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $admin->updated_at->format('F d, Y \a\t h:i A') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-8 flex space-x-4">
                <a href="{{ route('superadmin.admins.edit', $admin) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                    Edit Admin
                </a>
                <form action="{{ route('superadmin.admins.destroy', $admin) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200">
                        Delete Admin
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
