@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8 text-center">
            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-red-100 text-red-600 mb-6">
                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h1 class="text-2xl font-serif font-bold text-gray-900 mb-4">Access Denied</h1>
            <p class="text-gray-600 mb-6">Sorry, you don't have permission to access this page.</p>
            <div class="mt-8">
                <a href="{{ route('home') }}" class="px-6 py-3 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    Return to Homepage
                </a>
            </div>
        </div>
    </div>
@endsection
