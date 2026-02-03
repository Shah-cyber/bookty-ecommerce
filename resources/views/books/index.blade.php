@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen bg-gray-50/50">
        <!-- Background Elements -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-200/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-indigo-200/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
        </div>

        <div class="relative container mx-auto px-4 py-12">
            <!-- Shop Hero Section -->
            <div class="mb-12 text-center">
                <span class="inline-flex items-center py-1.5 px-4 rounded-full bg-white/50 border border-white/50 backdrop-blur-sm text-gray-500 text-xs font-bold tracking-widest uppercase mb-4 shadow-sm">
                    Shop
                </span>
                <h1 class="text-4xl md:text-5xl font-bold font-serif mb-4 text-gray-900 tracking-tight">
                    Discover Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">Next Adventure</span>
                </h1>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto font-light leading-relaxed">
                    Explore our curated collection of books across genres and find your perfect read
                </p>
            </div>

            <!-- Mobile Filter Toggle -->
            <div class="lg:hidden mb-6">
                <button id="filter-toggle" class="w-full flex items-center justify-between px-6 py-4 bg-white/70 backdrop-blur-xl rounded-2xl shadow-sm border border-white/60 text-gray-700 font-bold transition-all duration-300 hover:bg-white/90">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                  <div class="bg-white/60 backdrop-blur-xl rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/60 overflow-hidden">
                    <!-- Filters Header -->
                    <div class="px-6 py-5 border-b border-gray-100/50 flex items-center justify-between bg-white/40">
                        <h2 class="text-lg font-bold text-gray-900">Refine Results</h2>
                        <a href="{{ route('books.index') }}" 
                           class="text-xs font-bold text-purple-600 hover:text-purple-800 uppercase tracking-wider transition">
                          Reset All
                        </a>
                    </div>

                    <form action="{{ route('books.index') }}" method="GET" class="p-6 space-y-6">
                      <!-- Author Filter -->
                      <div class="filter-section">
                        <button type="button" data-collapse-toggle="author-filters"
                          class="flex items-center justify-between w-full text-sm font-bold text-gray-900 group">
                          Authors
                          <svg class="w-4 h-4 ml-2 text-gray-400 group-hover:text-purple-600 transition-transform"
                               data-collapse-icon fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                          </svg>
                        </button>
                        <div id="author-filters" class="space-y-2 mt-3 max-h-48 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-purple-200 scrollbar-track-gray-100 hidden">
                          @foreach($authors as $author)
                            <label for="author-{{ Str::slug($author) }}" 
                                   class="flex items-center px-3 py-2 rounded-xl cursor-pointer hover:bg-white/50 transition border border-transparent hover:border-white/60">
                              <input id="author-{{ \Illuminate\Support\Str::slug($author) }}" name="author" type="radio" value="{{ $author }}"
                                     {{ request('author') == $author ? 'checked' : '' }}
                                     class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded-full bg-white/50">
                              <span class="ml-2 text-sm text-gray-600 font-medium">{{ $author }}</span>
                            </label>
                          @endforeach
                        </div>
                      </div>

                      <!-- Genre Filter -->
                      <div class="filter-section pt-5 border-t border-gray-100/50">
                        <button type="button" data-collapse-toggle="genre-filters"
                          class="flex items-center justify-between w-full text-sm font-bold text-gray-900 group">
                          Genre
                          <svg class="w-4 h-4 ml-2 text-gray-400 group-hover:text-purple-600 transition-transform"
                               data-collapse-icon fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                          </svg>
                        </button>
                        <div id="genre-filters" class="space-y-2 mt-3 max-h-48 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-purple-200 scrollbar-track-gray-100 hidden">
                          @foreach($genres as $genre)
                            <label for="genre-{{ $genre->id }}" 
                                   class="flex items-center px-3 py-2 rounded-xl cursor-pointer hover:bg-white/50 transition border border-transparent hover:border-white/60">
                              <input id="genre-{{ $genre->id }}" name="genre" type="radio" value="{{ $genre->id }}"
                                     {{ request('genre') == $genre->id ? 'checked' : '' }}
                                     class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded-full bg-white/50">
                              <span class="ml-2 text-sm text-gray-600 font-medium">{{ $genre->name }}</span>
                            </label>
                          @endforeach
                        </div>
                      </div>

                      <!-- Trope Filter -->
                      <div class="filter-section border-t border-gray-100/50 pt-5">
                        <button type="button" data-collapse-toggle="trope-filters"
                          class="flex items-center justify-between w-full text-sm font-bold text-gray-900 group">
                          Tropes
                          <svg class="w-4 h-4 ml-2 text-gray-400 group-hover:text-purple-600 transition-transform"
                               data-collapse-icon fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                          </svg>
                        </button>
                        <div id="trope-filters" class="space-y-2 mt-3 max-h-48 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-purple-200 scrollbar-track-gray-100 hidden">
                          @foreach($tropes as $trope)
                            <label for="trope-{{ $trope->id }}" 
                                   class="flex items-center px-3 py-2 rounded-xl cursor-pointer hover:bg-white/50 transition border border-transparent hover:border-white/60">
                              <input id="trope-{{ $trope->id }}" name="trope" type="radio" value="{{ $trope->id }}"
                                     {{ request('trope') == $trope->id ? 'checked' : '' }}
                                     class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded-full bg-white/50">
                              <span class="ml-2 text-sm text-gray-600 font-medium">{{ $trope->name }}</span>
                            </label>
                          @endforeach
                        </div>
                      </div>

                      <!-- Price Filter -->
                      <div class="filter-section border-t border-gray-100/50 pt-5">
                        <button type="button" data-collapse-toggle="price-filters"
                          class="flex items-center justify-between w-full text-sm font-bold text-gray-900 group">
                          Price Range
                          <svg class="w-4 h-4 ml-2 text-gray-400 group-hover:text-purple-600 transition-transform"
                               data-collapse-icon fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                          </svg>
                        </button>
                        <div id="price-filters" class="mt-3 hidden">
                          <div class="flex items-center space-x-3">
                            <div class="relative flex-1">
                              <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-xs font-bold">RM</span>
                              <input type="number" name="price_min" id="price_min" placeholder="Min"
                                     value="{{ request('price_min') }}" min="0"
                                     class="w-full pl-9 pr-3 py-2 bg-white/50 border border-gray-200 rounded-xl text-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            </div>
                            <div class="relative flex-1">
                              <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-xs font-bold">RM</span>
                              <input type="number" name="price_max" id="price_max" placeholder="Max"
                                     value="{{ request('price_max') }}" min="0"
                                     class="w-full pl-9 pr-3 py-2 bg-white/50 border border-gray-200 rounded-xl text-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Apply Filters Button -->
                      <div class="pt-5 border-t border-gray-100/50">
                        <button type="submit" 
                          class="w-full py-3 px-4 bg-gray-900 hover:bg-black text-white font-bold rounded-xl shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center justify-center">
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
                    <div class="bg-white/60 backdrop-blur-xl rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/60 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold font-serif text-gray-900 mb-1">
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
                            <p class="text-sm font-medium text-gray-500">Showing {{ $books->count() }} of {{ $books->total() }} books</p>
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
                                    class="flex items-center justify-between w-56 px-4 py-3 text-sm font-bold text-gray-700 bg-white/50 border border-gray-200/60 rounded-xl shadow-sm hover:bg-white transition-all duration-200 focus:ring-2 focus:ring-purple-500/20 focus:outline-none">
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
                                <div id="sortDropdown" class="z-20 hidden bg-white/90 backdrop-blur-xl divide-y divide-gray-100 rounded-xl shadow-xl border border-white/60 w-56 absolute right-0 mt-2 overflow-hidden">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="sortDropdownButton">
                                        <li>
                                            <button type="submit" name="sort" value="newest"
                                                class="w-full text-left px-4 py-2 hover:bg-purple-50 font-medium {{ request('sort') == 'newest' ? 'text-purple-600 bg-purple-50/50' : '' }}">
                                                Newest Arrivals
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="price_asc"
                                                class="w-full text-left px-4 py-2 hover:bg-purple-50 font-medium {{ request('sort') == 'price_asc' ? 'text-purple-600 bg-purple-50/50' : '' }}">
                                                Price: Low to High
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="price_desc"
                                                class="w-full text-left px-4 py-2 hover:bg-purple-50 font-medium {{ request('sort') == 'price_desc' ? 'text-purple-600 bg-purple-50/50' : '' }}">
                                                Price: High to Low
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="title_asc"
                                                class="w-full text-left px-4 py-2 hover:bg-purple-50 font-medium {{ request('sort') == 'title_asc' ? 'text-purple-600 bg-purple-50/50' : '' }}">
                                                Title: A to Z
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="sort" value="title_desc"
                                                class="w-full text-left px-4 py-2 hover:bg-purple-50 font-medium {{ request('sort') == 'title_desc' ? 'text-purple-600 bg-purple-50/50' : '' }}">
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
                        <div class="mb-8 flex flex-wrap gap-3">
                            @if(request('genre') && $genres->where('id', request('genre'))->first())
                                <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-purple-100/50 backdrop-blur-sm border border-purple-200 text-purple-800 shadow-sm">
                                    Genre: {{ $genres->where('id', request('genre'))->first()->name }}
                                    <a href="{{ route('books.index', request()->except('genre')) }}" class="ml-2 text-purple-600 hover:text-purple-900 bg-white/50 rounded-full p-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif

                            @if(request('author'))
                                <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-blue-100/50 backdrop-blur-sm border border-blue-200 text-blue-800 shadow-sm">
                                    Author: {{ request('author') }}
                                    <a href="{{ route('books.index', request()->except('author')) }}" class="ml-2 text-blue-600 hover:text-blue-900 bg-white/50 rounded-full p-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('trope') && $tropes->where('id', request('trope'))->first())
                                <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-100/50 backdrop-blur-sm border border-indigo-200 text-indigo-800 shadow-sm">
                                    Trope: {{ $tropes->where('id', request('trope'))->first()->name }}
                                    <a href="{{ route('books.index', request()->except('trope')) }}" class="ml-2 text-indigo-600 hover:text-indigo-900 bg-white/50 rounded-full p-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('price_min') || request('price_max'))
                                <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-green-100/50 backdrop-blur-sm border border-green-200 text-green-800 shadow-sm">
                                    Price: 
                                    @if(request('price_min') && request('price_max'))
                                        RM{{ request('price_min') }} - RM{{ request('price_max') }}
                                    @elseif(request('price_min'))
                                        ≥ RM{{ request('price_min') }}
                                    @else
                                        ≤ RM{{ request('price_max') }}
                                    @endif
                                    <a href="{{ route('books.index', request()->except(['price_min', 'price_max'])) }}" class="ml-2 text-green-600 hover:text-green-900 bg-white/50 rounded-full p-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                            
                            @if(request('genre') || request('trope') || request('author') || request('price_min') || request('price_max'))
                                <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white/50 text-gray-600 hover:bg-white hover:text-red-500 border border-transparent hover:border-red-100 transition-all shadow-sm">
                                    Clear All
                                </a>
                            @endif
                        </div>
                    @endif

                    @if($books->isEmpty())
                        <div class="bg-white/60 backdrop-blur-xl p-8 rounded-[2rem] shadow-sm border border-white/60 text-center">
                            <div class="flex flex-col items-center justify-center py-12">
                                <div class="w-20 h-20 bg-gray-100/50 rounded-full flex items-center justify-center mb-6">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">No Books Found</h3>
                                <p class="text-gray-500 mb-8 max-w-md font-light">We couldn't find any books matching your current filters. Try adjusting your search criteria.</p>
                                <a href="{{ route('books.index') }}" class="px-8 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition duration-300 inline-flex items-center shadow-lg hover:scale-105">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    View All Books
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Books Grid - New Card Design -->
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
