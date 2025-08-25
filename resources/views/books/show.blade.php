@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('books.index') }}" class="text-purple-600 hover:text-purple-900">
                &larr; Back to Books
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Book Cover -->
                <div class="md:w-1/3 p-6">
                    <div class="sticky top-6">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-full h-96 bg-gray-200 rounded-lg shadow-md flex items-center justify-center">
                                <svg class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        <div class="mt-6">
                            <div class="flex items-center mb-4">
                                <span class="text-2xl font-bold text-purple-600">RM {{ $book->price }}</span>
                                <span class="ml-2 text-sm {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $book->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>

                            <form action="{{ route('cart.add', $book) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $book->stock }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" {{ $book->stock < 1 ? 'disabled' : '' }}>
                                </div>
                                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 {{ $book->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $book->stock < 1 ? 'disabled' : '' }}>
                                    {{ $book->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Book Details -->
                <div class="md:w-2/3 p-6 border-t md:border-t-0 md:border-l border-gray-200">
                    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-600 mb-4">by {{ $book->author }}</p>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-purple-100 text-purple-800">
                            {{ $book->genre->name }}
                        </span>
                        @foreach($book->tropes as $trope)
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                {{ $trope->name }}
                            </span>
                        @endforeach
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Synopsis</h2>
                        <div class="prose max-w-none text-gray-700">
                            <p>{{ $book->synopsis }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Book Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Title</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $book->title }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Author</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $book->author }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Genre</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $book->genre->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tropes</h3>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $book->tropes->pluck('name')->join(', ') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Books -->
        @if($relatedBooks->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-serif font-bold text-gray-900 mb-6">You May Also Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedBooks as $relatedBook)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <a href="{{ route('books.show', $relatedBook) }}">
                                <div class="h-64 overflow-hidden">
                                    @if($relatedBook->cover_image)
                                        <img src="{{ asset('storage/' . $relatedBook->cover_image) }}" alt="{{ $relatedBook->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('books.show', $relatedBook) }}">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $relatedBook->title }}</h3>
                                </a>
                                <p class="text-sm text-gray-600 mb-2">{{ $relatedBook->author }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-purple-600 font-semibold">RM {{ $relatedBook->price }}</span>
                                    <span class="text-xs text-gray-500 px-2 py-1 bg-gray-100 rounded-full">{{ $relatedBook->genre->name }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
