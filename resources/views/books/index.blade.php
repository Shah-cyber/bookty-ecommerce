@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <!-- Shop Hero Section -->
        <div class="mb-12 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-gray-900 via-purple-800 to-indigo-800 bg-clip-text text-transparent">
                Discover Your Next Adventure
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Explore our curated collection of books across genres and find your perfect read
            </p>
        </div>

        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden mb-6">
            <button id="filter-toggle" class="w-full flex items-center justify-between px-4 py-3 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-700">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    Filters & Sorting
                </span>
                <svg id="filter-chevron" class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div id="filters-sidebar" 
                 class="w-full lg:w-72 flex-shrink-0 lg:sticky lg:top-24 lg:self-start lg:max-h-[calc(100vh-120px)] hidden lg:block">

              <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <!-- Filters Header -->
                <div class="bg-gradient-to-r from-purple-100/80 to-indigo-100/80 px-6 py-4 border-b border-gray-200">
                  <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">Refine Results</h2>
                    <a href="{{ route('books.index') }}" 
                       class="text-sm text-purple-600 hover:text-purple-800 font-medium transition">
                      Reset All
                    </a>
                  </div>
                </div>

                <form action="{{ route('books.index') }}" method="GET" class="p-6 space-y-6">
                  <!-- Genre Filter -->
                  <div class="filter-section">
                    <button type="button" data-collapse-toggle="genre-filters"
                      class="flex items-center justify-between w-full text-sm font-bold text-gray-900 group">
                      Genre
                      <svg class="w-4 h-4 ml-2 text-gray-500 group-hover:text-purple-600 transition-transform"
                           data-collapse-icon fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                      </svg>
                    </button>
                    <div id="genre-filters" class="space-y-2 mt-3 max-h-48 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-purple-200 scrollbar-track-gray-100 hidden">
                      @foreach($genres as $genre)
                        <label for="genre-{{ $genre->id }}" 
                               class="flex items-center px-2 py-1.5 rounded-md cursor-pointer hover:bg-purple-50 transition">
                          <input id="genre-{{ $genre->id }}" name="genre" type="radio" value="{{ $genre->id }}"
                                 {{ request('genre') == $genre->id ? 'checked' : '' }}
                                 class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                          <span class="ml-2 text-sm text-gray-700">{{ $genre->name }}</span>
                        </label>
                      @endforeach
                    </div>
                  </div>

                  <!-- Trope Filter -->
                  <div class="filter-section border-t border-gray-200 pt-5">
                    <button type="button" data-collapse-toggle="trope-filters"
                      class="flex items-center justify-between w-full text-sm font-bold text-gray-900 group">
                      Tropes
                      <svg class="w-4 h-4 ml-2 text-gray-500 group-hover:text-purple-600 transition-transform"
                           data-collapse-icon fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                      </svg>
                    </button>
                    <div id="trope-filters" class="space-y-2 mt-3 max-h-48 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-purple-200 scrollbar-track-gray-100 hidden">
                      @foreach($tropes as $trope)
                        <label for="trope-{{ $trope->id }}" 
                               class="flex items-center px-2 py-1.5 rounded-md cursor-pointer hover:bg-purple-50 transition">
                          <input id="trope-{{ $trope->id }}" name="trope" type="radio" value="{{ $trope->id }}"
                                 {{ request('trope') == $trope->id ? 'checked' : '' }}
                                 class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                          <span class="ml-2 text-sm text-gray-700">{{ $trope->name }}</span>
                        </label>
                      @endforeach
                    </div>
                  </div>

                  <!-- Price Filter -->
                  <div class="filter-section border-t border-gray-200 pt-5">
                    <button type="button" data-collapse-toggle="price-filters"
                      class="flex items-center justify-between w-full text-sm font-bold text-gray-900 group">
                      Price Range
                      <svg class="w-4 h-4 ml-2 text-gray-500 group-hover:text-purple-600 transition-transform"
                           data-collapse-icon fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                      </svg>
                    </button>
                    <div id="price-filters" class="mt-3 hidden">
                      <div class="flex items-center space-x-4">
                        <div class="relative flex-1">
                          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">RM</span>
                          <input type="number" name="price_min" id="price_min" placeholder="Min"
                                 value="{{ request('price_min') }}" min="0"
                                 class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        </div>
                        <div class="relative flex-1">
                          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">RM</span>
                          <input type="number" name="price_max" id="price_max" placeholder="Max"
                                 value="{{ request('price_max') }}" min="0"
                                 class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Apply Filters Button -->
                  <div class="pt-5 border-t border-gray-200">
                    <button type="submit" 
                      class="w-full py-3 px-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md transition duration-300 flex items-center justify-center">
                      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                      </svg>
                      Apply Filters
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Books Content Area -->
            <div class="flex-1">
                <!-- Results Header -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">
                        @if(request('genre') && $genres->where('id', request('genre'))->first())
                            {{ $genres->where('id', request('genre'))->first()->name }} Books
                        @elseif(request('trope') && $tropes->where('id', request('trope'))->first())
                            Books with {{ $tropes->where('id', request('trope'))->first()->name }} Trope
                        @else
                            All Books
                        @endif
                            </h2>
                            <p class="text-gray-500">Showing {{ $books->count() }} of {{ $books->total() }} books</p>
                        </div>
                        
                        <!-- Desktop Sort Dropdown -->
                        <div class="hidden sm:block relative">
                            <form id="sort-form" action="{{ route('books.index') }}" method="GET">
                                @if(request('genre'))
                                    <input type="hidden" name="genre" value="{{ request('genre') }}">
                                @endif
                                @if(request('trope'))
                                    <input type="hidden" name="trope" value="{{ request('trope') }}">
                                @endif
                                @if(request('price_min'))
                                    <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                                @endif
                                @if(request('price_max'))
                                    <input type="hidden" name="price_max" value="{{ request('price_max') }}">
                                @endif

                                <!-- Sort Dropdown Button -->
                                <button id="sortDropdownButton" type="button"
                                    class="flex items-center justify-between w-48 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    <span>
                                        @switch(request('sort'))
                                            @case('price_asc') Price: Low to High @break
                                            @case('price_desc') Price: High to Low @break
                                            @case('title_asc') Title: A to Z @break
                                            @case('title_desc') Title: Z to A @break
                                            @default Newest Arrivals
                                        @endswitch
                                    </span>
                                    <svg class="w-4 h-4 ml-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="sortDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-48 absolute right-0 mt-2">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="sortDropdownButton">
                                        <li>
                                            <button type="submit" name="sort" value="newest"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 {{ request('sort') == 'newest' ? 'font-semibold text-blue-600' : '' }}">
                                                Newest Arrivals
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="price_asc"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 {{ request('sort') == 'price_asc' ? 'font-semibold text-blue-600' : '' }}">
                                                Price: Low to High
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="price_desc"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 {{ request('sort') == 'price_desc' ? 'font-semibold text-blue-600' : '' }}">
                                                Price: High to Low
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="title_asc"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 {{ request('sort') == 'title_asc' ? 'font-semibold text-blue-600' : '' }}">
                                                Title: A to Z
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="title_desc"
                                                class="w-full text-left px-4 py-2 hover:bg-gray-100 {{ request('sort') == 'title_desc' ? 'font-semibold text-blue-600' : '' }}">
                                                Title: Z to A
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Active Filters -->
                    @if(request('genre') || request('trope') || request('price_min') || request('price_max'))
                        <div class="mt-4 flex flex-wrap gap-2">
                            @if(request('genre') && $genres->where('id', request('genre'))->first())
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Genre: {{ $genres->where('id', request('genre'))->first()->name }}
                                    <a href="{{ route('books.index', request()->except('genre')) }}" class="ml-1 text-purple-600 hover:text-purple-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('trope') && $tropes->where('id', request('trope'))->first())
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    Trope: {{ $tropes->where('id', request('trope'))->first()->name }}
                                    <a href="{{ route('books.index', request()->except('trope')) }}" class="ml-1 text-indigo-600 hover:text-indigo-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('price_min') || request('price_max'))
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Price: 
                                    @if(request('price_min') && request('price_max'))
                                        RM{{ request('price_min') }} - RM{{ request('price_max') }}
                                    @elseif(request('price_min'))
                                        ≥ RM{{ request('price_min') }}
                                    @else
                                        ≤ RM{{ request('price_max') }}
                                    @endif
                                    <a href="{{ route('books.index', request()->except(['price_min', 'price_max'])) }}" class="ml-1 text-green-600 hover:text-green-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('genre') || request('trope') || request('price_min') || request('price_max'))
                                <a href="{{ route('books.index') }}" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200">
                                    Clear All Filters
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                @if($books->isEmpty())
                    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                        <div class="flex flex-col items-center justify-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">No Books Found</h3>
                            <p class="text-gray-500 mb-6 max-w-md">We couldn't find any books matching your current filters. Try adjusting your search criteria.</p>
                            <a href="{{ route('books.index') }}" class="px-5 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition duration-300 inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                View All Books
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Books Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($books as $book)
                            <div class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col h-full">
                                <!-- Book Cover with Overlay Actions -->
                                <div class="relative overflow-hidden">
                                    <a href="{{ route('books.show', $book) }}" class="block">
                                        <div class="aspect-[2/3] w-full bg-gray-50 {{ $book->stock <= 0 ? 'grayscale opacity-90' : '' }}">
                                        @if($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                    
                                    <!-- Genre Badge -->
                                    <div class="absolute top-3 left-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-white/90 backdrop-blur-sm text-gray-700 shadow-sm">
                                            {{ $book->genre->name }}
                                        </span>
                                    </div>
                                    
                                    <!-- Wishlist Button -->
                                    <div class="absolute top-3 right-3">
                                        @auth
                                            <button onclick="event.preventDefault(); toggleWishlist({{ $book->id }}, this)" 
                                                class="wishlist-btn p-2 bg-white/90 rounded-full hover:bg-white transition-colors duration-200 backdrop-blur-sm shadow-sm"
                                                data-book-id="{{ $book->id }}"
                                                data-in-wishlist="{{ Auth::user()->hasBookInWishlist($book->id) ? 'true' : 'false' }}">
                                                @if(Auth::user()->hasBookInWishlist($book->id))
                                                    <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                    </svg>
                                        @endif
                                            </button>
                                        @else
                                            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }))" class="p-2 bg-white/90 rounded-full hover:bg-white transition-colors duration-200 backdrop-blur-sm shadow-sm">
                                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                            </button>
                                        @endauth
                                    </div>
                                    
                                    <!-- Promotions / Stock Badges -->
                                    @if($book->is_on_sale)
                                        <div class="absolute bottom-3 left-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-500 text-white shadow-sm">
                                                -{{ $book->discount_percent }}%
                                            </span>
                                        </div>
                                    @endif

                                    @if($book->stock <= 0)
                                        <div class="absolute bottom-3 right-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 shadow-sm">
                                                Out of Stock
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Overlay Actions -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center p-4">
                                        @if($book->stock > 0)
                                            <button 
                                                type="button" 
                                                class="ajax-add-to-cart w-full px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-900 font-medium rounded-lg hover:bg-white transition-colors duration-200"
                                                data-book-id="{{ $book->id }}"
                                                data-quantity="1"
                                            >
                                                Add to Cart
                                            </button>
                                        @else
                                            <button type="button" class="w-full px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-900 font-medium rounded-lg opacity-50 cursor-not-allowed" disabled>
                                                Out of Stock
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Book Details -->
                                <div class="p-5 flex flex-col flex-grow">
                                    <a href="{{ route('books.show', $book) }}" class="block group-hover:text-purple-700 transition-colors duration-200">
                                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-2">{{ $book->title }}</h3>
                                    </a>
                                    <p class="text-sm text-gray-600 mb-2">by {{ $book->author }}</p>
                                    
                                    <!-- Rating -->
                                    <div class="flex items-center mb-3">
                                        @php
                                            $avgRating = $book->average_rating;
                                            $reviewsCount = $book->reviews_count;
                                        @endphp
                                        <div class="flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= ($avgRating ?: 0) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-500 ml-1">{{ $avgRating ? number_format($avgRating, 1) : 'No' }} ({{ $reviewsCount }})</span>
                                    </div>
                                    
                                    <!-- Tropes -->
                                    @if($book->tropes->isNotEmpty())
                                        <div class="flex flex-wrap gap-1 mb-4">
                                            @foreach($book->tropes->take(2) as $trope)
                                                <span class="text-xs text-gray-500 px-2 py-1 bg-gray-50 rounded-full">{{ $trope->name }}</span>
                                            @endforeach
                                            @if($book->tropes->count() > 2)
                                                <span class="text-xs text-gray-500 px-2 py-1 bg-gray-50 rounded-full">+{{ $book->tropes->count() - 2 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <!-- Price -->
                                    <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                                        @if($book->is_on_sale)
                                            <div class="flex items-baseline space-x-2">
                                                <span class="text-lg font-bold {{ $book->stock <= 0 ? 'text-gray-500' : 'bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent' }}">RM {{ number_format($book->final_price, 2) }}</span>
                                                <span class="text-sm text-gray-500 line-through">RM {{ number_format($book->price, 2) }}</span>
                                            </div>
                                        @else
                                            <span class="text-lg font-bold {{ $book->stock <= 0 ? 'text-gray-500' : 'bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent' }}">RM {{ number_format($book->price, 2) }}</span>
                                        @endif

                                        <!-- Right area kept clean intentionally for minimalist look -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Enhanced Pagination -->
                    <div class="mt-12">
                        {{ $books->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Filter Toggle JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mobile filter toggle
                const filterToggle = document.getElementById('filter-toggle');
                const filtersSidebar = document.getElementById('filters-sidebar');
                const filterChevron = document.getElementById('filter-chevron');
                
                if (filterToggle && filtersSidebar) {
                    filterToggle.addEventListener('click', function() {
                        filtersSidebar.classList.toggle('hidden');
                        filterChevron.classList.toggle('rotate-180');
                    });
                }
                
                // Filter section toggles
                document.querySelectorAll('[data-collapse-toggle]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-collapse-toggle');
                        const target = document.getElementById(targetId);
                        const icon = this.querySelector('[data-collapse-icon]');
                        if (target) {
                            target.classList.toggle('hidden');
                        }
                        if (icon) {
                            icon.classList.toggle('rotate-180');
                        }
                    });
                });

                // Sort dropdown toggle
                const sortBtn = document.getElementById('sortDropdownButton');
                const sortMenu = document.getElementById('sortDropdown');
                if (sortBtn && sortMenu) {
                    sortBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        sortMenu.classList.toggle('hidden');
                    });
                    // Close when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!sortMenu.classList.contains('hidden')) {
                            const clickedInside = sortMenu.contains(e.target) || sortBtn.contains(e.target);
                            if (!clickedInside) {
                                sortMenu.classList.add('hidden');
                            }
                        }
                    });
                    // Close on escape
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            sortMenu.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </div>
@endsection
