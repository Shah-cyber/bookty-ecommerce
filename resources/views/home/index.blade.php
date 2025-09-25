@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-800 min-h-screen">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse animation-delay-2000"></div>
            <div class="absolute top-20 left-20 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse animation-delay-4000"></div>
        </div>
        
        <div class="container mx-auto px-6 py-20 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-16 min-h-[80vh]">
                <!-- Left Content -->
                <div class="flex-1 text-white" data-aos="fade-right" data-aos-duration="1000">
                    <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-10 rounded-full text-sm font-medium mb-8 backdrop-blur-md border border-white border-opacity-20">
                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></span>
                        ✨ LIMITED TIME OFFER
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-8 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">
                        Discover Your<br>
                        <span class="text-yellow-300">Next Favorite</span><br>
                        Story
                    </h1>
                    <p class="text-xl md:text-2xl mb-10 max-w-2xl text-purple-100 leading-relaxed">
                        Immerse yourself in thousands of captivating books. From bestsellers to hidden gems, find your perfect read today.
                    </p>
                    <div class="flex flex-wrap gap-6">
                        <a href="{{ route('books.index') }}" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-full transition-all duration-300 shadow-2xl hover:shadow-purple-500/25 hover:scale-105 transform">
                            <span class="mr-2">EXPLORE BOOKS</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <button class="inline-flex items-center px-8 py-4 border-2 border-white border-opacity-30 text-white font-semibold rounded-full transition-all duration-300 hover:bg-white hover:text-purple-900 backdrop-blur-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            WATCH TRAILER
                        </button>
                    </div>
                    
                    <!-- Stats Row -->
                    <div class="flex flex-wrap gap-8 mt-16 pt-8 border-t border-white border-opacity-20">
                        <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                            <div class="text-3xl font-bold text-yellow-300">10K+</div>
                            <div class="text-purple-200 text-sm">Happy Readers</div>
                        </div>
                        <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                            <div class="text-3xl font-bold text-yellow-300">5K+</div>
                            <div class="text-purple-200 text-sm">Books Available</div>
                        </div>
                        <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                            <div class="text-3xl font-bold text-yellow-300">98%</div>
                            <div class="text-purple-200 text-sm">Satisfaction Rate</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Modern Book Showcase -->
                <div class="flex-1 relative" data-aos="fade-left" data-aos-duration="1000">
                    <div class="relative max-w-lg mx-auto">
                        <!-- Floating Books Animation -->
                        <div class="relative h-[500px] w-full">
                            <!-- Main Featured Book -->
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                                <div class="w-48 h-64 bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl shadow-2xl transform rotate-6 hover:rotate-0 transition-transform duration-500">
                                    <div class="p-6 h-full flex flex-col justify-between text-white">
                                        <div>
                                            <div class="w-8 h-1 bg-white rounded mb-4"></div>
                                            <div class="w-12 h-1 bg-white rounded opacity-75 mb-2"></div>
                                            <div class="w-16 h-1 bg-white rounded opacity-50"></div>
                                        </div>
                                        <div>
                                            <div class="text-lg font-bold mb-2">Featured</div>
                                            <div class="text-sm opacity-75">Book Collection</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Book 1 -->
                            <div class="absolute top-20 right-4 w-32 h-40 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl shadow-xl transform -rotate-12 animate-float">
                                <div class="p-4 h-full flex flex-col justify-between text-white text-xs">
                                    <div class="w-6 h-0.5 bg-white rounded"></div>
                                    <div class="space-y-1">
                                        <div class="w-4 h-0.5 bg-white rounded opacity-75"></div>
                                        <div class="w-6 h-0.5 bg-white rounded opacity-50"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Book 2 -->
                            <div class="absolute bottom-16 left-8 w-28 h-36 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl shadow-xl transform rotate-12 animate-float-delayed">
                                <div class="p-3 h-full flex flex-col justify-between text-white text-xs">
                                    <div class="w-5 h-0.5 bg-white rounded"></div>
                                    <div class="space-y-1">
                                        <div class="w-3 h-0.5 bg-white rounded opacity-75"></div>
                                        <div class="w-5 h-0.5 bg-white rounded opacity-50"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Book 3 -->
                            <div class="absolute top-32 left-12 w-24 h-32 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg shadow-lg transform -rotate-6 animate-float-slow">
                                <div class="p-2 h-full flex flex-col justify-between text-white text-xs">
                                    <div class="w-4 h-0.5 bg-white rounded"></div>
                                    <div class="w-3 h-0.5 bg-white rounded opacity-50"></div>
                                </div>
                            </div>
                            
                            <!-- Decorative Elements -->
                            <div class="absolute -top-4 -left-4 w-6 h-6 bg-yellow-400 rounded-full animate-ping"></div>
                            <div class="absolute -bottom-2 -right-2 w-4 h-4 bg-pink-400 rounded-full animate-pulse"></div>
                            <div class="absolute top-1/3 -left-8 w-2 h-2 bg-purple-400 rounded-full animate-bounce"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>

    <!-- Genre Gallery with Filters (Flowbite-style) -->
    <div class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-10" data-aos="fade-up">
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-full text-sm font-medium mb-6 text-indigo-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Browse by Genre (Gallery)
                </div>
                <h2 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-gray-900 via-indigo-800 to-purple-800 bg-clip-text text-transparent">
                    Explore Visual Picks
                </h2>
                <p class="text-gray-600 mt-2">Use the filters to view books by genre</p>
            </div>

            <!-- Filters -->
            <div class="flex items-center justify-center py-4 md:py-6 flex-wrap gap-3" id="genreFilters">
                <button type="button"
                    data-filter="all"
                    class="genre-filter-btn text-indigo-700 hover:text-white border border-indigo-600 bg-white hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 rounded-full text-sm md:text-base font-medium px-4 md:px-5 py-2.5 text-center active-filter">
                    All genres
                </button>
                @foreach($genres as $genre)
                    <button type="button"
                        data-filter="{{ $genre->id }}"
                        class="genre-filter-btn text-gray-900 border border-white hover:border-gray-200 bg-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-full text-sm md:text-base font-medium px-4 md:px-5 py-2.5 text-center">
                        {{ $genre->name }}
                    </button>
                @endforeach
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="genreGallery">
                @foreach($newArrivals as $book)
                    <div class="gallery-item group relative" data-genre-id="{{ $book->genre->id }}" data-aos="fade-up">
                        <a href="{{ route('books.show', $book) }}" class="block">
                            @if($book->cover_image)
                                <img class="h-auto w-full rounded-lg object-cover aspect-[3/4]" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                            @else
                                <div class="h-full w-full rounded-lg bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 aspect-[3/4] flex items-center justify-center">
                                    <svg class="h-12 w-12 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            @endif
                            <!-- Overlay -->
                            <div class="pointer-events-none absolute inset-0 rounded-lg bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <!-- Caption -->
                            <div class="pointer-events-none absolute bottom-0 left-0 right-0 p-3 text-white">
                                <div class="text-sm font-semibold line-clamp-1">{{ $book->title }}</div>
                                <div class="text-xs opacity-80">{{ $book->author }} • {{ $book->genre->name }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Empty state -->
            <div id="galleryEmptyState" class="hidden text-center py-12">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                    No books found for this genre.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.genre-filter-btn');
            const items = document.querySelectorAll('#genreGallery .gallery-item');
            const emptyState = document.getElementById('galleryEmptyState');

            function applyFilter(filter) {
                let visibleCount = 0;
                items.forEach((el) => {
                    const match = filter === 'all' || String(el.dataset.genreId) === String(filter);
                    el.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });
                emptyState.classList.toggle('hidden', visibleCount > 0);
            }

            filterButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    // Active styles
                    filterButtons.forEach(b => b.classList.remove('active-filter', 'text-white', 'bg-indigo-700', 'border-indigo-700'));
                    btn.classList.add('active-filter', 'text-white', 'bg-indigo-700', 'border-indigo-700');

                    applyFilter(btn.dataset.filter);
                });
            });

            // Initialize
            applyFilter('all');
        });
    </script>

    <!-- Flash Sale Section -->
    @if(isset($activeFlashSale) && $activeFlashSale)
    <div class="py-16 bg-gray-50 relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="mb-8" data-aos="fade-up">
                <x-flash-sale-countdown :end-time="$activeFlashSale->ends_at->toIso8601String()" :title="$activeFlashSale->name" class="mb-6">
                    <p class="text-sm">{{ $activeFlashSale->description }}</p>
                </x-flash-sale-countdown>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-6">
                    @foreach($activeFlashSale->books->take(5) as $book)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden group transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="relative">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-purple-200 to-indigo-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-0 right-0 bg-red-600 text-white px-2 py-1 text-xs font-bold">
                                    @if($activeFlashSale->discount_type === 'fixed')
                                        -RM {{ $activeFlashSale->discount_value }}
                                    @else
                                        -{{ $activeFlashSale->discount_value }}%
                                    @endif
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-600 mb-2">by {{ $book->author }}</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-lg font-bold text-red-600">RM {{ number_format($book->final_price, 2) }}</span>
                                        <span class="ml-2 text-sm text-gray-500 line-through">RM {{ number_format($book->price, 2) }}</span>
                                    </div>
                                </div>
                                <button 
                                    onclick="quickAddToCart({{ $book->id }})"
                                    class="mt-3 w-full py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white text-sm font-medium rounded hover:from-red-700 hover:to-pink-700 transition-colors duration-300 flex items-center justify-center">
                                    <span class="btn-text">Add to Cart</span>
                                    <span class="loading-spinner hidden">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-6">
                    <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white font-medium rounded-lg hover:from-red-700 hover:to-pink-700 transition-colors duration-300">
                        View All Flash Sale Items
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Featured Collection -->
    {{-- <div class="py-20 bg-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #7c3aed 0%, transparent 50%), radial-gradient(circle at 75% 75%, #ec4899 0%, transparent 50%);"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 rounded-full text-sm font-medium mb-6 text-purple-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    Featured Collection
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-purple-800 to-pink-800 bg-clip-text text-transparent">
                    Handpicked Just for You
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Discover our carefully curated selection of trending books and timeless classics
                </p>
            </div>

            <!-- Modern Carousel Controls -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex space-x-4">
                    <button id="prevBtn" class="group p-3 bg-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-purple-200">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button id="nextBtn" class="group p-3 bg-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-purple-200">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Progress Indicator -->
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <span id="currentSlide">1</span>
                    <div class="w-12 h-1 bg-gray-200 rounded-full overflow-hidden">
                        <div id="progressBar" class="h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full transition-all duration-300" style="width: 33.33%"></div>
                    </div>
                    <span id="totalSlides">3</span>
                </div>
            </div>

            <!-- Enhanced Book Carousel -->
            <div class="relative overflow-hidden rounded-2xl">
                <div id="bookCarousel" class="flex transition-transform duration-700 ease-out" style="width: {{ ceil($newArrivals->count() / 5) * 100 }}%;">
                    @foreach($newArrivals as $index => $book)
                        <div class="w-1/5 px-3 flex-shrink-0">
                            <div class="group cursor-pointer" data-aos="fade-up" data-aos-delay="{{ ($index % 5) * 100 }}">
                                <div class="relative mb-4 overflow-hidden rounded-xl bg-white shadow-lg group-hover:shadow-2xl transition-all duration-500 transform group-hover:-translate-y-2">
                                    <a href="{{ route('books.show', $book) }}" class="block">
                                        @if($book->cover_image)
                                            <div class="aspect-[3/4] w-full overflow-hidden">
                                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            </div>
                                        @else
                                            <div class="aspect-[3/4] w-full bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100 flex items-center justify-center">
                                                <svg class="h-16 w-16 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                        
                                        <!-- Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        
                                        <!-- New Badge -->
                                        <div class="absolute top-3 right-3">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-lg">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                </svg>
                                                New
                                            </span>
                                        </div>
                                        
                                        <!-- Quick Actions -->
                                        <div class="absolute bottom-3 left-3 right-3 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                            <div class="flex justify-between items-center">
                                                @auth
                                                    <button onclick="event.preventDefault(); toggleWishlist({{ $book->id }}, this)" 
                                                        class="wishlist-btn p-2 bg-white/90 rounded-full hover:bg-white transition-colors duration-200 backdrop-blur-sm"
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
                                                    <a href="{{ route('login') }}" class="p-2 bg-white/90 rounded-full hover:bg-white transition-colors duration-200 backdrop-blur-sm">
                                                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                        </svg>
                                                    </a>
                                                @endauth
                                                <button onclick="quickAddToCart({{ $book->id }})" class="quick-add-btn px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-sm font-medium rounded-full hover:shadow-lg transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                                                    <span class="btn-text">Add to Cart</span>
                                                    <span class="loading-spinner hidden">
                                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        Adding...
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Book Info -->
                                    <div class="px-2">
                                        <h3 class="font-bold text-gray-900 mb-1 text-sm leading-tight line-clamp-2 group-hover:text-purple-600 transition-colors duration-200">{{ $book->title }}</h3>
                                        <p class="text-gray-600 text-xs mb-2">by {{ $book->author }}</p>
                                    <div class="flex items-center justify-between">
                                            @if($book->is_on_sale)
                                                <div class="flex items-center">
                                                    <span class="text-lg font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">RM {{ number_format($book->final_price, 2) }}</span>
                                                    <span class="ml-2 text-xs text-gray-500 line-through">RM {{ number_format($book->price, 2) }}</span>
                                                    <span class="ml-1 text-xs bg-red-100 text-red-800 px-1 py-0.5 rounded">-{{ $book->discount_percent }}%</span>
                                                </div>
                                            @else
                                                <span class="text-lg font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">RM {{ number_format($book->price, 2) }}</span>
                                            @endif
                                            <span class="text-xs px-2 py-1 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 rounded-full font-medium">{{ $book->genre->name }}</span>
                                        </div>
                                        
                                        <!-- Rating Stars -->
                                        <div class="flex items-center mt-2">
                                            @php
                                                $avgRating = $book->average_rating;
                                                $reviewsCount = $book->reviews_count;
                                            @endphp
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= ($avgRating ?: 0) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                            <span class="text-xs text-gray-500 ml-1">({{ $avgRating ? number_format($avgRating, 1) : '0' }})</span>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Enhanced Carousel Dots -->
            <div class="flex justify-center mt-8 space-x-3" id="carouselDots">
                <!-- Dots will be generated by JavaScript -->
            </div>
        </div>
    </div> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('bookCarousel');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const dotsContainer = document.getElementById('carouselDots');
            const currentSlideElement = document.getElementById('currentSlide');
            const totalSlidesElement = document.getElementById('totalSlides');
            const progressBar = document.getElementById('progressBar');
            
            const totalBooks = {{ $newArrivals->count() }};
            const booksPerPage = 5; // Show 5 books per page
            const totalPages = Math.ceil(totalBooks / booksPerPage);
            let currentPage = 0;

            // Update total slides display
            totalSlidesElement.textContent = totalPages;

            // Generate dots based on number of pages
            function generateDots() {
                dotsContainer.innerHTML = '';
                
                for (let i = 0; i < totalPages; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'w-3 h-3 rounded-full cursor-pointer transition-all duration-300';
                    dot.style.backgroundColor = i === 0 ? '#7d4b94' : '#f5eceb';
                    dot.onclick = () => {
                        clearInterval(autoPlayInterval);
                        goToPage(i);
                    };
                    dotsContainer.appendChild(dot);
                }
            }

            function updateCarousel() {
                // Move by 100% per page (each page shows 5 books)
                const movePercentage = currentPage * 100;
                carousel.style.transform = `translateX(-${movePercentage}%)`;
                
                // Update dots
                const dots = dotsContainer.children;
                for (let i = 0; i < dots.length; i++) {
                    if (i === currentPage) {
                        dots[i].style.backgroundColor = '#7d4b94';
                        dots[i].style.transform = 'scale(1.2)';
                    } else {
                        dots[i].style.backgroundColor = '#f5eceb';
                        dots[i].style.transform = 'scale(1)';
                    }
                }
                
                // Update progress indicator
                currentSlideElement.textContent = currentPage + 1;
                const progressPercentage = ((currentPage + 1) / totalPages) * 100;
                progressBar.style.width = `${progressPercentage}%`;
                
                // Update button states
                if (currentPage === 0) {
                    prevBtn.style.opacity = '0.5';
                    prevBtn.style.cursor = 'not-allowed';
                    prevBtn.disabled = true;
                } else {
                    prevBtn.style.opacity = '1';
                    prevBtn.style.cursor = 'pointer';
                    prevBtn.disabled = false;
                }
                
                if (currentPage === totalPages - 1) {
                    nextBtn.style.opacity = '0.5';
                    nextBtn.style.cursor = 'not-allowed';
                    nextBtn.disabled = true;
                } else {
                    nextBtn.style.opacity = '1';
                    nextBtn.style.cursor = 'pointer';
                    nextBtn.disabled = false;
                }
            }

            function goToPage(page) {
                if (page >= 0 && page < totalPages) {
                    currentPage = page;
                    updateCarousel();
                }
            }

            prevBtn.addEventListener('click', function() {
                if (currentPage > 0) {
                    currentPage--;
                    updateCarousel();
                }
            });

            nextBtn.addEventListener('click', function() {
                if (currentPage < totalPages - 1) {
                    currentPage++;
                    updateCarousel();
                }
            });

            // Auto-play carousel - moves to next set of 6 books every 8 seconds
            let autoPlayInterval = setInterval(function() {
                if (currentPage < totalPages - 1) {
                    currentPage++;
                } else {
                    currentPage = 0; // Loop back to first page
                }
                updateCarousel();
            }, 8000); // Change every 8 seconds

            // Pause auto-play when user hovers over carousel
            carousel.addEventListener('mouseenter', function() {
                clearInterval(autoPlayInterval);
            });

            // Resume auto-play when user stops hovering
            carousel.addEventListener('mouseleave', function() {
                autoPlayInterval = setInterval(function() {
                    if (currentPage < totalPages - 1) {
                        currentPage++;
                    } else {
                        currentPage = 0;
                    }
                    updateCarousel();
                }, 8000);
            });

            // Also pause when hovering over navigation buttons
            [prevBtn, nextBtn].forEach(btn => {
                btn.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
                btn.addEventListener('mouseleave', () => {
                    autoPlayInterval = setInterval(function() {
                        if (currentPage < totalPages - 1) {
                            currentPage++;
                        } else {
                            currentPage = 0;
                        }
                        updateCarousel();
                    }, 8000);
                });
            });

            // Initialize
            generateDots();
            updateCarousel();
        });
    </script>

    <!-- Enhanced Promotional Banners -->
    <div class="py-20 bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-purple-800 to-pink-800 bg-clip-text text-transparent">
                    Limited Time Offers
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Don't miss out on these incredible deals and exclusive collections
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Enhanced Sale Banner 1 -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 p-8 text-white transform hover:scale-105 transition-all duration-500 shadow-2xl hover:shadow-purple-500/25" data-aos="fade-right" data-aos-delay="200">
                    <!-- Animated Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 animate-gradient"></div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-pink-500/20 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <!-- Badge -->
                        <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-md rounded-full text-sm font-bold mb-6 border border-white/30">
                            <svg class="w-4 h-4 mr-2 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            BESTSELLER SALE
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                            Up to <span class="text-yellow-300">25% OFF</span><br>
                            Featured Books
                        </h3>
                        <p class="text-lg mb-6 text-purple-100 leading-relaxed">
                            Dive into our handpicked collection of award-winning novels and bestsellers
                        </p>
                        
                        <!-- CTA Button -->
                        <a href="{{ route('books.index') }}" class="group/btn inline-flex items-center px-8 py-4 bg-white text-purple-700 font-bold rounded-full hover:bg-yellow-300 hover:text-purple-900 transition-all duration-300 transform hover:scale-105 shadow-xl">
                            <span class="mr-2">Explore Deals</span>
                            <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        
                        <!-- Timer -->
                        <div class="mt-6 flex items-center space-x-4 text-sm">
                            <span class="text-purple-200">Ends in:</span>
                            <div class="flex space-x-2">
                                <div class="bg-white/20 backdrop-blur-md px-2 py-1 rounded text-center">
                                    <div class="font-bold">23</div>
                                    <div class="text-xs text-purple-200">Days</div>
                                </div>
                                <div class="bg-white/20 backdrop-blur-md px-2 py-1 rounded text-center">
                                    <div class="font-bold">14</div>
                                    <div class="text-xs text-purple-200">Hours</div>
                                </div>
                                <div class="bg-white/20 backdrop-blur-md px-2 py-1 rounded text-center">
                                    <div class="font-bold">35</div>
                                    <div class="text-xs text-purple-200">Mins</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Sale Banner 2 -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-blue-700 to-purple-600 p-8 text-white transform hover:scale-105 transition-all duration-500 shadow-2xl hover:shadow-blue-500/25" data-aos="fade-left" data-aos-delay="400">
                    <!-- Animated Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-blue-700 to-purple-600 animate-gradient"></div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -left-4 w-20 h-20 bg-white/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="absolute -bottom-6 -right-6 w-28 h-28 bg-indigo-400/20 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700"></div>
                    
                    <div class="relative z-10">
                        <!-- Badge -->
                        <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-md rounded-full text-sm font-bold mb-6 border border-white/30">
                            <svg class="w-4 h-4 mr-2 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            NEW ARRIVALS
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                            Get <span class="text-blue-300">45% OFF</span><br>
                            New Releases
                        </h3>
                        <p class="text-lg mb-6 text-blue-100 leading-relaxed">
                            Be among the first to discover the latest literary masterpieces
                        </p>
                        
                        <!-- CTA Button -->
                        <a href="{{ route('books.index') }}" class="group/btn inline-flex items-center px-8 py-4 bg-white text-indigo-700 font-bold rounded-full hover:bg-blue-300 hover:text-indigo-900 transition-all duration-300 transform hover:scale-105 shadow-xl">
                            <span class="mr-2">Shop New Releases</span>
                            <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        
                        <!-- Progress Bar -->
                        <div class="mt-6">
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="text-blue-200">Limited Stock</span>
                                <span class="text-blue-200">67% Claimed</span>
                            </div>
                            <div class="w-full bg-white/20 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-300 to-white h-2 rounded-full" style="width: 67%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Special Offer Strip -->
            <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="600">
                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-orange-500 text-yellow-900 font-bold rounded-full shadow-lg animate-pulse">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                    🎉 Free shipping on orders over RM 50! 🎉
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Browse By Category -->
    <div class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-full text-sm font-medium mb-6 text-indigo-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Browse Categories
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-indigo-800 to-purple-800 bg-clip-text text-transparent">
                    Find Your Genre
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore our diverse collection organized by your favorite genres and interests
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($genres as $genre)
                    <a href="{{ route('books.index', ['genre' => $genre->id]) }}" class="group relative overflow-hidden bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 text-center transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-gray-100 hover:border-purple-200" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <!-- Hover Background Effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Category Icon -->
                        <div class="relative z-10 inline-flex items-center justify-center h-20 w-20 rounded-2xl mb-6 transition-all duration-500 bg-gradient-to-br from-indigo-100 to-purple-100 group-hover:from-indigo-500 group-hover:to-purple-500 group-hover:scale-110">
                            @php
                                $icons = [
                                    'romance' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                                    'mystery' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                                    'fantasy' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                    'fiction' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                                    'science' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                                    'thriller' => 'M13 10V3L4 14h7v7l9-11h-7z',
                                    'biography' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                    'history' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                                ];
                                $genreLower = strtolower($genre->name);
                                $iconPath = $icons[$genreLower] ?? $icons['fiction'];
                            @endphp
                            <svg class="h-10 w-10 text-indigo-600 group-hover:text-white transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                            </svg>
                        </div>
                        
                        <!-- Category Info -->
                        <div class="relative z-10">
                            <h3 class="text-lg font-bold mb-2 text-gray-900 group-hover:text-purple-700 transition-colors duration-300">{{ $genre->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 group-hover:text-gray-700 transition-colors duration-300">{{ $genre->books_count }} books available</p>
                            
                            <!-- Explore Button -->
                            <div class="inline-flex items-center text-sm font-medium text-indigo-600 group-hover:text-purple-600 transition-colors duration-300">
                                <span class="mr-1">Explore</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Decorative Corner -->
                        <div class="absolute top-0 right-0 w-0 h-0 border-l-[20px] border-l-transparent border-t-[20px] border-t-gradient-to-r from-purple-400 to-pink-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute top-0 right-0 w-0 h-0 border-l-[20px] border-l-transparent border-t-[20px] border-t-purple-400 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </a>
                @endforeach
            </div>
            
            <!-- View All Categories Button -->
            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="800">
                <a href="{{ route('books.index') }}" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-full hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-xl hover:shadow-indigo-500/25 transform hover:scale-105">
                    <span class="mr-2">View All Books</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Customer Testimonials -->
    <div class="py-20 bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-100 to-orange-100 rounded-full text-sm font-medium mb-6 text-orange-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Customer Reviews
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-orange-800 to-yellow-800 bg-clip-text text-transparent">
                    What Our Readers Say
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Don't just take our word for it - hear from our community of book lovers
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <blockquote class="text-gray-700 mb-6 leading-relaxed">
                        "Bookty has completely transformed my reading experience. The selection is incredible and the delivery is always fast. I've discovered so many amazing books!"
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            S
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Sarah Chen</div>
                            <div class="text-sm text-gray-600">Book Enthusiast</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100" data-aos="fade-up" data-aos-delay="400">
                    <div class="flex items-center mb-6">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <blockquote class="text-gray-700 mb-6 leading-relaxed">
                        "As a teacher, I love how easy it is to find educational and inspiring books for my students. The categorization is perfect and the prices are unbeatable."
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-blue-400 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            M
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Marcus Rodriguez</div>
                            <div class="text-sm text-gray-600">Educator</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100" data-aos="fade-up" data-aos-delay="600">
                    <div class="flex items-center mb-6">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <blockquote class="text-gray-700 mb-6 leading-relaxed">
                        "The personalized recommendations are spot on! I've found my new favorite authors through Bookty. It's like having a personal librarian."
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-400 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            E
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Emily Watson</div>
                            <div class="text-sm text-gray-600">Avid Reader</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Indicators -->
            <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="800">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">10K+</div>
                        <div class="text-gray-600">Happy Customers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">50K+</div>
                        <div class="text-gray-600">Books Sold</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-pink-600 mb-2">4.9/5</div>
                        <div class="text-gray-600">Average Rating</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-orange-600 mb-2">98%</div>
                        <div class="text-gray-600">Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced New Arrivals -->
    <div id="featured" class="py-20 bg-gradient-to-br from-purple-50 via-white to-indigo-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-100 to-indigo-100 rounded-full text-sm font-medium mb-6 text-purple-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Latest Additions
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-purple-800 to-indigo-800 bg-clip-text text-transparent">
                    New Arrivals
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Discover the latest additions to our collection - fresh stories and new adventures await
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                @foreach($newArrivals->take(8) as $book)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="relative overflow-hidden">
                            <a href="{{ route('books.show', $book) }}" class="block">
                                @if($book->cover_image)
                                    <div class="aspect-[3/4] w-full">
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                @else
                                    <div class="aspect-[3/4] w-full bg-gradient-to-br from-purple-100 via-indigo-50 to-pink-100 flex items-center justify-center">
                                        <svg class="h-20 w-20 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                                
                                <!-- New Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        New
                                    </span>
                                </div>
                                
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <!-- Wishlist Button (Top Right) -->
                                <div class="absolute top-4 right-4 z-10">
                                    @auth
                                        <button onclick="event.preventDefault(); toggleWishlist({{ $book->id }}, this)" 
                                            class="wishlist-btn p-2 bg-white/90 rounded-full hover:bg-white transition-colors duration-200 backdrop-blur-sm shadow-md"
                                            data-book-id="{{ $book->id }}"
                                            data-in-wishlist="{{ Auth::user()->hasBookInWishlist($book->id) ? 'true' : 'false' }}">
                                            @if(Auth::user()->hasBookInWishlist($book->id))
                                                <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                            @endif
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="p-2 bg-white/90 rounded-full hover:bg-white transition-colors duration-200 backdrop-blur-sm shadow-md">
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </a>
                                    @endauth
                                </div>
                                
                                <!-- Quick Add to Cart -->
                                <div class="absolute bottom-4 left-4 right-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                    <button onclick="quickAddToCart({{ $book->id }})" class="quick-add-btn w-full py-2 bg-white/90 backdrop-blur-sm text-gray-900 font-medium rounded-lg hover:bg-white transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span class="btn-text">Quick Add to Cart</span>
                                        <span class="loading-spinner hidden">
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-900 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Adding...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        
                        <div class="p-6">
                            <a href="{{ route('books.show', $book) }}">
                                <h3 class="text-lg font-bold mb-2 text-gray-900 group-hover:text-purple-600 transition-colors duration-200 line-clamp-2">{{ $book->title }}</h3>
                            </a>
                            <p class="text-gray-600 text-sm mb-3">by {{ $book->author }}</p>
                            
                            <!-- Rating -->
                            <div class="flex items-center mb-4">
                                @php
                                    $avgRating = $book->average_rating;
                                    $reviewsCount = $book->reviews_count;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= ($avgRating ?: 0) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                <span class="text-sm text-gray-500 ml-2">({{ $avgRating ? number_format($avgRating, 1) : '0' }})</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                @if($book->is_on_sale)
                                    <div class="flex items-center">
                                        <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">RM {{ number_format($book->final_price, 2) }}</span>
                                        <span class="ml-2 text-sm text-gray-500 line-through">RM {{ number_format($book->price, 2) }}</span>
                                        <span class="ml-2 text-xs bg-red-100 text-red-800 px-1.5 py-0.5 rounded-md">-{{ $book->discount_percent }}%</span>
                                    </div>
                                @else
                                    <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">RM {{ number_format($book->price, 2) }}</span>
                                @endif
                                <span class="text-xs px-3 py-1 bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-700 rounded-full font-medium">{{ $book->genre->name }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
    </div>

            <div class="text-center" data-aos="fade-up" data-aos-delay="800">
                <a href="{{ route('books.index') }}" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-full hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-xl hover:shadow-purple-500/25 transform hover:scale-105">
                    <span class="mr-2">Explore All Books</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Enhanced Newsletter -->
    <div class="py-20 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse animation-delay-4000"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Header -->
                <div class="mb-12" data-aos="fade-up">
                    <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-sm font-medium mb-8 text-purple-200 border border-white/20">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Stay Connected
                    </div>
                    <h2 class="text-4xl md:text-6xl font-bold mb-6 text-white leading-tight">
                        Never Miss a
                        <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent"> Great Read</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-purple-100 leading-relaxed max-w-3xl mx-auto">
                        Join over 10,000 book lovers and get personalized recommendations, exclusive deals, and early access to new releases.
                    </p>
                </div>

                <!-- Newsletter Form -->
                <div class="mb-12" data-aos="fade-up" data-aos-delay="200">
                    <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                        <div class="flex-1 relative">
                            <input type="email" placeholder="Enter your email address" class="w-full px-6 py-4 text-gray-900 bg-white/95 backdrop-blur-md rounded-2xl focus:outline-none focus:ring-4 focus:ring-purple-500/50 focus:bg-white transition-all duration-300 text-lg placeholder-gray-500">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-6">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                        </div>
                        <button type="submit" class="group px-8 py-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 font-bold rounded-2xl hover:from-yellow-500 hover:to-orange-600 transition-all duration-300 shadow-2xl hover:shadow-yellow-500/25 transform hover:scale-105">
                            <span class="flex items-center">
                                Subscribe Now
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                    </button>
                </form>
                    
                    <!-- Privacy Notice -->
                    <p class="text-purple-200 text-sm mt-4">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        We respect your privacy. Unsubscribe at any time.
                    </p>
                </div>

                <!-- Benefits -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Personalized Picks</h3>
                        <p class="text-purple-200">Get book recommendations tailored to your reading preferences</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Exclusive Deals</h3>
                        <p class="text-purple-200">Access subscriber-only discounts and special offers</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Early Access</h3>
                        <p class="text-purple-200">Be the first to discover new releases and bestsellers</p>
                    </div>
                </div>

                <!-- Social Proof -->
                <div class="mt-16 pt-8 border-t border-white/20" data-aos="fade-up" data-aos-delay="600">
                    <div class="flex items-center justify-center space-x-8">
                        <div class="flex items-center text-purple-200">
                            <svg class="w-5 h-5 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm">10K+ Subscribers</span>
                        </div>
                        <div class="flex items-center text-purple-200">
                            <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm">Weekly Updates</span>
                        </div>
                        <div class="flex items-center text-purple-200">
                            <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="text-sm">No Spam Ever</span>
                        </div>
                    </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Wishlist JavaScript -->
    <script>
        function toggleWishlist(bookId, button) {
            // Show loading state
            const originalContent = button.innerHTML;
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin h-4 w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
            
            // Determine if the book is in the wishlist
            const isInWishlist = button.dataset.inWishlist === 'true';
            
            // Determine the endpoint
            const endpoint = isInWishlist ? 
                `/wishlist/remove/${bookId}` : 
                `/wishlist/add/${bookId}`;
            
            // Prepare the request
            const method = isInWishlist ? 'DELETE' : 'POST';
            
            // Send the AJAX request
            fetch(endpoint, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Update all wishlist buttons for this book
                const allButtons = document.querySelectorAll(`.wishlist-btn[data-book-id="${bookId}"]`);
                
                allButtons.forEach(btn => {
                    if (isInWishlist) {
                        // Book was removed from wishlist
                        btn.dataset.inWishlist = 'false';
                        btn.innerHTML = `
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        `;
                    } else {
                        // Book was added to wishlist
                        btn.dataset.inWishlist = 'true';
                        btn.innerHTML = `
                            <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        `;
                    }
                    btn.disabled = false;
                });
                
                // Update wishlist count in the header if it exists
                if (data.wishlist_count !== undefined) {
                    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                    wishlistCountElements.forEach(element => {
                        if (data.wishlist_count > 0) {
                            element.textContent = data.wishlist_count;
                            element.classList.remove('hidden');
                        } else {
                            element.classList.add('hidden');
                        }
                    });
                }
                
                // Show a toast notification
                if (window.showToast) {
                    window.showToast(data.message, isInWishlist ? 'info' : 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = originalContent;
                button.disabled = false;
                
                if (window.showToast) {
                    window.showToast('An error occurred. Please try again.', 'error');
                }
            });
        }
    </script>
@endsection

