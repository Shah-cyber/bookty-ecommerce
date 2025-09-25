@extends('layouts.admin')

@section('header', 'Edit Book')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.books.index') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300">
            &larr; Back to Books
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Edit Book: {{ $book->title }}</h2>

        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 mb-6" role="alert">
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
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $book->slug) }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">URL-friendly version of the title (e.g., "the-secret-garden")</p>
                    </div>

                    <div class="mb-4">
                        <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Author</label>
                        <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="genre_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Genre</label>
                        <select name="genre_id" id="genre_id" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <option value="">Select a genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" {{ old('genre_id', $book->genre_id) == $genre->id ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="tropes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tropes</label>
                        <div class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md p-2 max-h-48 overflow-y-auto">
                            @foreach($tropes as $trope)
                                <div class="flex items-center mb-1">
                                    <input type="checkbox" name="tropes[]" id="trope_{{ $trope->id }}" value="{{ $trope->id }}" 
                                        {{ in_array($trope->id, old('tropes', $book->tropes->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                                    <label for="trope_{{ $trope->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $trope->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Selling Price (RM)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $book->price) }}" required min="0" step="0.01" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="cost_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cost Price (RM)</label>
                        <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price', $book->cost_price) }}" min="0" step="0.01" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">How much you paid for this book (for profit calculations)</p>
                    </div>

                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" required min="0" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="cover_image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cover Image</label>
                        
                        <!-- Current Image -->
                        @if($book->cover_image)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current Image:</p>
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="h-40 w-auto object-cover rounded">
                            </div>
                        @endif
                        
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="cover_image_help" id="cover_image" name="cover_image" type="file" accept="image/*">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="cover_image_help">SVG, PNG, or JPG (MAX. 800x400px). Leave empty to keep current image.</p>
                        
                        <!-- Image Preview -->
                        <div id="image-preview" class="mt-3 hidden">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">New Image Preview:</p>
                                <button type="button" id="remove-file" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm font-medium">
                                    Remove File
                                </button>
                            </div>
                            <img id="preview-img" src="" alt="Preview" class="h-40 w-auto object-cover rounded">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="synopsis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Synopsis</label>
                        <textarea name="synopsis" id="synopsis" rows="6" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('synopsis', $book->synopsis) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
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

        // Image preview functionality
        document.getElementById('cover_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewDiv = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewDiv.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.classList.add('hidden');
            }
        });

        // Remove file functionality
        document.getElementById('remove-file').addEventListener('click', function() {
            const fileInput = document.getElementById('cover_image');
            const previewDiv = document.getElementById('image-preview');
            
            // Clear the file input
            fileInput.value = '';
            
            // Hide the preview
            previewDiv.classList.add('hidden');
        });
    </script>
@endsection
