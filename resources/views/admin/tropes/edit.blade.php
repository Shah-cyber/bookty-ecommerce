@extends('layouts.admin')

@section('header', 'Edit Trope')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.tropes.index') }}" class="text-purple-600 hover:text-purple-900">
            &larr; Back to Tropes
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Trope: {{ $trope->name }}</h2>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Please fix the following errors:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.tropes.update', $trope) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $trope->name) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $trope->slug) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                <p class="mt-1 text-xs text-gray-500">URL-friendly version of the name (e.g., "enemies-to-lovers")</p>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('description', $trope->description) }}</textarea>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    Update Trope
                </button>
            </div>
        </form>
    </div>

    <script>
        // Auto-generate slug from name if slug is empty
        document.getElementById('name').addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            if (slugInput.value === '') {
                const name = this.value;
                const slug = name.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-')     // Replace spaces with hyphens
                    .replace(/-+/g, '-');     // Replace multiple hyphens with single hyphen
                
                slugInput.value = slug;
            }
        });
    </script>
@endsection
