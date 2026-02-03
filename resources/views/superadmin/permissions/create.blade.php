@extends('layouts.superadmin')

@section('header', 'Create Permission')

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
            <h2 class="text-2xl font-serif font-semibold text-bookty-black mb-6">Create New Permission</h2>

            <form action="{{ route('superadmin.permissions.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Permission Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500 @error('name') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Use a descriptive name like "edit books" or "view orders".</p>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700 transition-colors duration-200">
                        Create Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
