@extends('layouts.superadmin')

@section('header', 'Edit Admin User')

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
            <h2 class="text-2xl font-serif font-semibold text-bookty-black mb-6">Edit Admin User</h2>

            <form action="{{ route('superadmin.admins.update', $admin) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}" required
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" required
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (leave blank to keep current)</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700 transition-colors duration-200">
                        Update Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
