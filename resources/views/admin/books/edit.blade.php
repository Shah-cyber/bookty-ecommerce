@extends('layouts.admin')

@section('header', 'Edit Book')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.books.index') }}" class="text-purple-600 hover:text-purple-900">
            &larr; Back to Books
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Book: {{ $book->title }}</h2>

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

        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $book->slug) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <p class="mt-1 text-xs text-gray-500">URL-friendly version of the title (e.g., "the-secret-garden")</p>
                    </div>

                    <div class="mb-4">
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                        <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="genre_id" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                        <select name="genre_id" id="genre_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <option value="">Select a genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" {{ old('genre_id', $book->genre_id) == $genre->id ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="tropes" class="block text-sm font-medium text-gray-700 mb-1">Tropes</label>
                        <div class="border border-gray-300 rounded-md p-2 max-h-48 overflow-y-auto">
                            @foreach($tropes as $trope)
                                <div class="flex items-center mb-1">
                                    <input type="checkbox" name="tropes[]" id="trope_{{ $trope->id }}" value="{{ $trope->id }}" 
                                        {{ in_array($trope->id, old('tropes', $book->tropes->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="trope_{{ $trope->id }}" class="ml-2 text-sm text-gray-700">{{ $trope->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (RM)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $book->price) }}" required min="0" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" required min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                        
                        @if($book->cover_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-40 w-auto object-cover rounded">
                            </div>
                        @endif
                        
                        <input type="file" name="cover_image" id="cover_image" accept="image/*" class="w-full border border-gray-300 rounded-md p-2">
                        <p class="mt-1 text-xs text-gray-500">Leave empty to keep the current image. Recommended size: 400x600px, max 2MB</p>
                    </div>

                    <div class="mb-4">
                        <label for="synopsis" class="block text-sm font-medium text-gray-700 mb-1">Synopsis</label>
                        <textarea name="synopsis" id="synopsis" rows="6" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('synopsis', $book->synopsis) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    Update Book
                </button>
            </div>
        </form>
    </div>

    <script>
        // Auto-generate slug from title if slug is empty
        document.getElementById('title').addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            if (slugInput.value === '') {
                const title = this.value;
                const slug = title.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-')     // Replace spaces with hyphens
                    .replace(/-+/g, '-');     // Replace multiple hyphens with single hyphen
                
                slugInput.value = slug;
            }
        });
    </script>
@endsection
