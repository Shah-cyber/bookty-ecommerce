@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Filters</h2>
                    <form action="{{ route('books.index') }}" method="GET">
                        <!-- Genre Filter -->
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Genre</h3>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($genres as $genre)
                                    <div class="flex items-center">
                                        <input id="genre-{{ $genre->id }}" name="genre" type="radio" value="{{ $genre->id }}" 
                                            {{ request('genre') == $genre->id ? 'checked' : '' }}
                                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <label for="genre-{{ $genre->id }}" class="ml-2 text-sm text-gray-700">
                                            {{ $genre->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Trope Filter -->
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Tropes</h3>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($tropes as $trope)
                                    <div class="flex items-center">
                                        <input id="trope-{{ $trope->id }}" name="trope" type="radio" value="{{ $trope->id }}" 
                                            {{ request('trope') == $trope->id ? 'checked' : '' }}
                                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <label for="trope-{{ $trope->id }}" class="ml-2 text-sm text-gray-700">
                                            {{ $trope->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Price Range</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="price_min" class="sr-only">Min Price</label>
                                    <input type="number" name="price_min" id="price_min" placeholder="Min" value="{{ request('price_min') }}" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="price_max" class="sr-only">Max Price</label>
                                    <input type="number" name="price_max" id="price_max" placeholder="Max" value="{{ request('price_max') }}" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>

                        <!-- Sort Filter -->
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Sort By</h3>
                            <select name="sort" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title: A to Z</option>
                                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title: Z to A</option>
                            </select>
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                Apply Filters
                            </button>
                            <a href="{{ route('books.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Books Grid -->
            <div class="flex-1">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-serif font-bold text-gray-900">
                        @if(request('genre') && $genres->where('id', request('genre'))->first())
                            {{ $genres->where('id', request('genre'))->first()->name }} Books
                        @elseif(request('trope') && $tropes->where('id', request('trope'))->first())
                            Books with {{ $tropes->where('id', request('trope'))->first()->name }} Trope
                        @else
                            All Books
                        @endif
                    </h1>
                    <p class="text-gray-500">{{ $books->total() }} results</p>
                </div>

                @if($books->isEmpty())
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <p class="text-gray-500">No books found matching your criteria.</p>
                        <a href="{{ route('books.index') }}" class="mt-4 inline-block text-purple-600 hover:text-purple-700">Clear filters and view all books</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($books as $book)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <a href="{{ route('books.show', $book) }}">
                                    <div class="h-64 overflow-hidden">
                                        @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
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
                                    <a href="{{ route('books.show', $book) }}">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $book->title }}</h3>
                                    </a>
                                    <p class="text-sm text-gray-600 mb-2">{{ $book->author }}</p>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-purple-600 font-semibold">RM {{ $book->price }}</span>
                                        <span class="text-xs text-gray-500 px-2 py-1 bg-gray-100 rounded-full">{{ $book->genre->name }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1 mb-4">
                                        @foreach($book->tropes->take(3) as $trope)
                                            <span class="text-xs text-gray-500 px-2 py-1 bg-purple-50 rounded-full">{{ $trope->name }}</span>
                                        @endforeach
                                        @if($book->tropes->count() > 3)
                                            <span class="text-xs text-gray-500 px-2 py-1 bg-purple-50 rounded-full">+{{ $book->tropes->count() - 3 }} more</span>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        <form action="{{ route('cart.add', $book) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 {{ $book->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $book->stock < 1 ? 'disabled' : '' }}>
                                                {{ $book->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $books->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
