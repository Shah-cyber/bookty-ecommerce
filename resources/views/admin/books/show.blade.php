@extends('layouts.admin')

@section('header', 'Book Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.books.index') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300">
            &larr; Back to Books
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/4 mb-6 md:mb-0 md:pr-6">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                    @else
                        <div class="w-full h-96 bg-gray-200 dark:bg-gray-600 rounded-lg shadow-md flex items-center justify-center">
                            <svg class="h-24 w-24 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    <div class="mt-6 flex space-x-2">
                        <a href="{{ route('admin.books.edit', $book) }}" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            Edit
                        </a>
                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="md:w-3/4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-4">by {{ $book->author }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Genre</h3>
                            <p class="mt-1">
                                <span class="px-2 py-1 text-sm font-medium rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                    {{ $book->genre->name }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tropes</h3>
                            <div class="mt-1 flex flex-wrap gap-2">
                                @forelse($book->tropes as $trope)
                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        {{ $trope->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-500 dark:text-gray-400">No tropes assigned</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">RM {{ $book->price }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock</h3>
                            <p class="mt-1">
                                @if($book->stock > 10)
                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        {{ $book->stock }} in stock
                                    </span>
                                @elseif($book->stock > 0)
                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                        {{ $book->stock }} in stock (Low)
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                        Out of stock
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Synopsis</h3>
                        <div class="prose max-w-none text-gray-700 dark:text-gray-300">
                            {{ $book->synopsis }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
