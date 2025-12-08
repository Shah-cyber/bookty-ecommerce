@extends('layouts.admin')

@section('header', 'Add New Book')

@section('content')
    @section('content')
    <div class="w-full">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Book</h2>
                <a href="{{ route('admin.books.index') }}"
                    class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                    Back to Books
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors with your submission
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div
                    class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden">
                    <div class="p-6 md:p-8 space-y-8">
                        <!-- Book Basic Info -->
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-4">
                                    <label for="title"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                    <div class="mt-1">
                                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                            class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg transition-colors placeholder-gray-400"
                                            placeholder="e.g. The Great Gatsby">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="author"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Author</label>
                                    <div class="mt-1">
                                        <input type="text" name="author" id="author" value="{{ old('author') }}" required
                                            class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg transition-colors"
                                            placeholder="Author Name">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="slug"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 sm:text-sm">
                                            {{ config('app.url') }}/books/
                                        </span>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-purple-500 focus:border-purple-500 sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                            placeholder="the-great-gatsby">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Auto-generated from title. Used in
                                        URLs.</p>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="genre_id"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Genre</label>
                                    <div class="mt-1">
                                        <select id="genre_id" name="genre_id" required
                                            class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg">
                                            <option value="">Select a genre</option>
                                            @foreach($genres as $genre)
                                                <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tropes</label>
                                    <div
                                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 max-h-48 overflow-y-auto">
                                        @foreach($tropes as $trope)
                                            <label class="relative flex items-start py-1 cursor-pointer group">
                                                <div class="min-w-0 flex-1 text-sm">
                                                    <div
                                                        class="text-gray-700 dark:text-gray-200 select-none group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                                        {{ $trope->name }}</div>
                                                </div>
                                                <div class="ml-3 flex items-center h-5">
                                                    <input id="trope_{{ $trope->id }}" name="tropes[]" value="{{ $trope->id }}"
                                                        type="checkbox" {{ in_array($trope->id, old('tropes', [])) ? 'checked' : '' }}
                                                        class="focus:ring-purple-500 h-4 w-4 text-purple-600 border-gray-300 dark:border-gray-600 rounded cursor-pointer bg-white dark:bg-gray-700">
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 dark:border-gray-700 pt-8">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Pricing & Inventory
                            </h3>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 lg:grid-cols-4">
                                <div>
                                    <label for="price"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selling Price
                                        (RM)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">RM</span>
                                        </div>
                                        <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0"
                                            step="0.01"
                                            class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg"
                                            placeholder="0.00">
                                    </div>
                                </div>

                                <div>
                                    <label for="cost_price"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cost Price
                                        (RM)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">RM</span>
                                        </div>
                                        <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price') }}"
                                            min="0" step="0.01"
                                            class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg"
                                            placeholder="0.00">
                                    </div>
                                </div>

                                <div>
                                    <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock
                                        Quantity</label>
                                    <div class="mt-1">
                                        <input type="number" name="stock" id="stock" value="{{ old('stock', 10) }}" required
                                            min="0"
                                            class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg">
                                    </div>
                                </div>

                                <div>
                                    <label for="condition" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Book Condition</label>
                                    <div class="mt-1">
                                        <select id="condition" name="condition" required
                                            class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg">
                                            <option value="new" {{ old('condition', 'new') == 'new' ? 'selected' : '' }}>New</option>
                                            <option value="preloved" {{ old('condition') == 'preloved' ? 'selected' : '' }}>Preloved</option>
                                        </select>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select whether the book is new or preloved (second-hand).</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 dark:border-gray-700 pt-8">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Book Details</h3>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6 md:col-span-4">
                                    <label for="synopsis"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Synopsis</label>
                                    <div class="mt-1">
                                        <textarea id="synopsis" name="synopsis" rows="15"
                                            class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg"
                                            placeholder="Write a compelling summary...">{{ old('synopsis') }}</textarea>
                                    </div>
                                </div>

                                <div class="sm:col-span-6 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cover
                                        Image</label>
                                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                                        id="drop-zone">
                                        <div class="space-y-1 text-center">
                                            <div class="flex flex-col items-center">
                                                <div id="image-preview" class="hidden mb-3 relative group">
                                                    <img id="preview-img" src="" alt="Preview"
                                                        class="h-48 w-auto object-cover rounded-lg shadow-md">
                                                    <button type="button" id="remove-file"
                                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 focus:outline-none opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <svg id="upload-icon" class="mx-auto h-12 w-12 text-gray-400"
                                                    stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                                <label for="cover_image"
                                                    class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500 px-2">
                                                    <span>Upload a file</span>
                                                    <input id="cover_image" name="cover_image" type="file" class="sr-only"
                                                        accept="image/*">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                PNG, JPG up to 2MB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.books.index') }}"
                            class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white shadow-sm hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:-translate-y-0.5 transition-all">
                            Create Book
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            // Auto-generate slug from title
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            titleInput.addEventListener('input', function () {
                if (this.value) {
                    const slug = this.value.toLowerCase()
                        .replace(/[^\w\s-]/g, '') // Remove special characters
                        .replace(/\s+/g, '-')     // Replace spaces with hyphens
                        .replace(/-+/g, '-')      // Replace multiple hyphens with single hyphen
                        .replace(/^-+|-+$/g, ''); // Trim hyphens from start/end

                    slugInput.value = slug;
                } else {
                    slugInput.value = '';
                }
            });

            // Image preview functionality
            const fileInput = document.getElementById('cover_image');
            const previewDiv = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const uploadIcon = document.getElementById('upload-icon');
            const removeBtn = document.getElementById('remove-file');

            fileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        previewDiv.classList.remove('hidden');
                        uploadIcon.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            removeBtn.addEventListener('click', function () {
                fileInput.value = '';
                previewDiv.classList.add('hidden');
                uploadIcon.classList.remove('hidden');
            });

            // Drag and drop visual feedback
            const dropZone = document.getElementById('drop-zone');

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/10');
            }

            function unhighlight(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/10');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length) {
                    fileInput.files = files;
                    // Trigger change event manually
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            }
        </script>
    @endsection
@endsection