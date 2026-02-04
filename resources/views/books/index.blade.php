@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <!-- Shop Hero Section -->
        <div class="mb-12 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-gray-900 via-primary-800 to-primary-900 bg-clip-text text-transparent">
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
                 class="w-full lg:w-80 flex-shrink-0 lg:sticky lg:top-24 lg:self-start lg:max-h-[calc(100vh-120px)] hidden lg:block overflow-y-auto scrollbar-hide pb-10">

              <div class="bg-white rounded-[2rem] shadow-xl p-8 border border-gray-100/50">
                <!-- Filters Header -->
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Filters</h2>
                    <a href="{{ route('books.index') }}" 
                       class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-wider transition">
                      Reset
                    </a>
                </div>

                <form action="{{ route('books.index') }}" method="GET" class="space-y-8">
                  
                  <!-- Price Filter -->
                  <div class="filter-section">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Price Range</h3>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1">
                          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-xs font-bold">RM</span>
                          <input type="number" name="price_min" id="price_min" placeholder="Min"
                                 value="{{ request('price_min') }}" min="0"
                                 class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border-none rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:ring-gray-900 placeholder-gray-400">
                        </div>
                        <span class="text-gray-300 font-bold">-</span>
                        <div class="relative flex-1">
                          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-xs font-bold">RM</span>
                          <input type="number" name="price_max" id="price_max" placeholder="Max"
                                 value="{{ request('price_max') }}" min="0"
                                 class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border-none rounded-xl text-sm font-bold text-gray-900 focus:ring-2 focus:ring-gray-900 placeholder-gray-400">
                        </div>
                    </div>
                  </div>

                  <!-- Genre Filter -->
                  <div class="filter-section border-t border-gray-100 pt-8">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Genres</h3>
                    <div class="flex flex-wrap gap-2">
                      @foreach($genres as $genre)
                        <label for="genre-{{ $genre->id }}" class="cursor-pointer">
                          <input id="genre-{{ $genre->id }}" name="genre" type="radio" value="{{ $genre->id }}"
                                 {{ request('genre') == $genre->id ? 'checked' : '' }}
                                 class="peer sr-only">
                          <span class="inline-block px-4 py-2 rounded-xl bg-gray-50 text-gray-600 text-sm font-bold border border-transparent hover:bg-gray-100 peer-checked:bg-gray-900 peer-checked:text-white peer-checked:shadow-lg transition-all duration-200">
                            {{ $genre->name }}
                          </span>
                        </label>
                      @endforeach
                    </div>
                  </div>

                  <!-- Trope Filter -->
                  <div class="filter-section border-t border-gray-100 pt-8">
                    <button type="button" data-collapse-toggle="trope-filters"
                      class="flex items-center justify-between w-full text-sm font-bold text-gray-900 uppercase tracking-wider group">
                      Tropes
                      <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-900 transition-transform"
                           data-collapse-icon fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                      </svg>
                    </button>
                    <div id="trope-filters" class="mt-4 hidden space-y-1">
                      @foreach($tropes as $trope)
                        <label class="flex items-center group cursor-pointer p-2 rounded-lg hover:bg-gray-50 transition">
                          <input type="radio" name="trope" value="{{ $trope->id }}" 
                                 {{ request('trope') == $trope->id ? 'checked' : '' }}
                                 class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900 rounded-full cursor-pointer">
                          <span class="ml-3 text-sm font-medium text-gray-600 group-hover:text-gray-900">{{ $trope->name }}</span>
                        </label>
                      @endforeach
                    </div>
                  </div>

                  <!-- Author Filter -->
                  <div class="filter-section border-t border-gray-100 pt-8">
                     <button type="button" data-collapse-toggle="author-filters"
                      class="flex items-center justify-between w-full text-sm font-bold text-gray-900 uppercase tracking-wider group">
                      Authors
                      <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-900 transition-transform"
                           data-collapse-icon fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                      </svg>
                    </button>
                    <div id="author-filters" class="mt-4 hidden space-y-1">
                      @foreach($authors as $author)
                        <label class="flex items-center group cursor-pointer p-2 rounded-lg hover:bg-gray-50 transition">
                          <input type="radio" name="author" value="{{ $author }}" 
                                 {{ request('author') == $author ? 'checked' : '' }}
                                 class="w-4 h-4 text-gray-900 border-gray-300 focus:ring-gray-900 rounded-full cursor-pointer">
                          <span class="ml-3 text-sm font-medium text-gray-600 group-hover:text-gray-900">{{ $author }}</span>
                        </label>
                      @endforeach
                    </div>
                  </div>

                  <!-- Apply Filters Button -->
                  <div class="pt-4">
                    <button type="submit" 
                      class="w-full py-4 bg-gray-900 text-white font-bold rounded-2xl shadow-xl hover:bg-black hover:shadow-2xl hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
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
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white rounded-[2rem] p-6 shadow-lg border border-gray-100/50">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">
                        @if(request('genre') && $genres->where('id', request('genre'))->first())
                            {{ $genres->where('id', request('genre'))->first()->name }} Books
                        @elseif(request('trope') && $tropes->where('id', request('trope'))->first())
                            Books with {{ $tropes->where('id', request('trope'))->first()->name }} Trope
                        @elseif(request('author'))
                            Books by {{ request('author') }}
                        @else
                            All Books
                        @endif
                            </h2>
                            <p class="text-gray-500 font-medium">Showing {{ $books->count() }} of {{ $books->total() }} books</p>
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
                                @if(request('author'))
                                    <input type="hidden" name="author" value="{{ request('author') }}">
                                @endif
                                @if(request('price_min'))
                                    <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                                @endif
                                @if(request('price_max'))
                                    <input type="hidden" name="price_max" value="{{ request('price_max') }}">
                                @endif

                                <!-- Sort Dropdown Button -->
                                <button id="sortDropdownButton" type="button"
                                    class="flex items-center justify-between w-52 px-6 py-3 text-sm font-bold text-gray-900 bg-white border border-gray-100 rounded-full shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                    <span>
                                        @switch(request('sort'))
                                            @case('price_asc') Price: Low to High @break
                                            @case('price_desc') Price: High to Low @break
                                            @case('title_asc') Title: A to Z @break
                                            @case('title_desc') Title: Z to A @break
                                            @default Newest Arrivals
                                        @endswitch
                                    </span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="sortDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-2xl shadow-xl border border-gray-100 w-52 absolute right-0 mt-3 overflow-hidden">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="sortDropdownButton">
                                        <li>
                                            <button type="submit" name="sort" value="newest"
                                                class="w-full text-left px-5 py-3 hover:bg-gray-50 font-medium {{ request('sort') == 'newest' ? 'font-bold text-gray-900 bg-gray-50' : '' }}">
                                                Newest Arrivals
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="price_asc"
                                                class="w-full text-left px-5 py-3 hover:bg-gray-50 font-medium {{ request('sort') == 'price_asc' ? 'font-bold text-gray-900 bg-gray-50' : '' }}">
                                                Price: Low to High
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="price_desc"
                                                class="w-full text-left px-5 py-3 hover:bg-gray-50 font-medium {{ request('sort') == 'price_desc' ? 'font-bold text-gray-900 bg-gray-50' : '' }}">
                                                Price: High to Low
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="title_asc"
                                                class="w-full text-left px-5 py-3 hover:bg-gray-50 font-medium {{ request('sort') == 'title_asc' ? 'font-bold text-gray-900 bg-gray-50' : '' }}">
                                                Title: A to Z
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="title_desc"
                                                class="w-full text-left px-5 py-3 hover:bg-gray-50 font-medium {{ request('sort') == 'title_desc' ? 'font-bold text-gray-900 bg-gray-50' : '' }}">
                                                Title: Z to A
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Active Filters -->
                    @if(request('genre') || request('trope') || request('author') || request('price_min') || request('price_max'))
                        <div class="mt-6 flex flex-wrap gap-3">
                            @if(request('genre') && $genres->where('id', request('genre'))->first())
                                <div class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold bg-orange-100 text-orange-800 shadow-sm">
                                    Genre: {{ $genres->where('id', request('genre'))->first()->name }}
                                    <a href="{{ route('books.index', request()->except('genre')) }}" class="ml-2 p-0.5 rounded-full hover:bg-orange-200 text-orange-600 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif

                            @if(request('author'))
                                <div class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold bg-blue-100 text-blue-800 shadow-sm">
                                    Author: {{ request('author') }}
                                    <a href="{{ route('books.index', request()->except('author')) }}" class="ml-2 p-0.5 rounded-full hover:bg-blue-200 text-blue-600 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('trope') && $tropes->where('id', request('trope'))->first())
                                <div class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold bg-purple-100 text-purple-800 shadow-sm">
                                    Trope: {{ $tropes->where('id', request('trope'))->first()->name }}
                                    <a href="{{ route('books.index', request()->except('trope')) }}" class="ml-2 p-0.5 rounded-full hover:bg-purple-200 text-purple-600 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('price_min') || request('price_max'))
                                <div class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 shadow-sm">
                                    Price: 
                                    @if(request('price_min') && request('price_max'))
                                        RM{{ request('price_min') }} - RM{{ request('price_max') }}
                                    @elseif(request('price_min'))
                                        ≥ RM{{ request('price_min') }}
                                    @else
                                        ≤ RM{{ request('price_max') }}
                                    @endif
                                    <a href="{{ route('books.index', request()->except(['price_min', 'price_max'])) }}" class="ml-2 p-0.5 rounded-full hover:bg-emerald-200 text-emerald-600 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('genre') || request('trope') || request('author') || request('price_min') || request('price_max'))
                                <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-900 transition hover:shadow-sm">
                                    Clear All
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                @if($books->isEmpty())
                    <div class="glass-card p-8 rounded-xl text-center">
                        <div class="flex flex-col items-center justify-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">No Books Found</h3>
                            <p class="text-gray-500 mb-6 max-w-md">We couldn't find any books matching your current filters. Try adjusting your search criteria.</p>
                            <a href="{{ route('books.index') }}" class="px-5 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition duration-300 inline-flex items-center">
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
                            <x-book-card :book="$book" />
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
