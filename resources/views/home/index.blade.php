@extends('layouts.app')

@section('content')
<style>
    /* Import Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap');
    
    body {
        font-family: 'Inter', sans-serif;
    }
    .font-serif {
        font-family: 'Playfair Display', serif;
    }
    
    /* Animation delays for background blobs */
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }

    /* Enhanced floating animation for background blobs */
    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate(10px, -20px) rotate(5deg); }
        50% { transform: translate(-10px, 10px) rotate(-5deg); }
        75% { transform: translate(20px, -10px) rotate(3deg); }
    }

    .float-animation {
        animation: float 20s ease-in-out infinite;
    }
    .float-animation-delayed {
        animation: float 25s ease-in-out infinite reverse;
        animation-delay: 2s;
    }
    .float-animation-slow {
        animation: float 30s ease-in-out infinite;
        animation-delay: 4s;
    }

    /* Carousel 3D perspective with enhanced depth */
    .perspective-container {
        perspective: 1500px;
        perspective-origin: 50% 50%;
    }
    
    #heroCoverCarousel {
        transform-style: preserve-3d;
        position: relative;
    }
    
    .hero-item {
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        will-change: transform, opacity;
    }

    /* Enhanced shadow for 3D effect */
    .hero-item::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 30px;
        background: radial-gradient(ellipse at center, rgba(0,0,0,0.3) 0%, transparent 70%);
        filter: blur(10px);
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-item.z-30::after {
        opacity: 1;
    }

    .hero-item:not(.z-30)::after {
        opacity: 0;
    }

    /* Shimmer effect on hover */
    .hero-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .hero-item:hover::before {
        left: 100%;
    }

    /* Text fade with slide-up animation */
    .text-fade {
        transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), 
                    transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .text-fade-out {
        opacity: 0;
        transform: translateY(20px);
    }

    /* Gradient text animation */
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .animated-gradient {
        background-size: 200% 200%;
        animation: gradient-shift 8s ease infinite;
    }
    
    /* Scroll down indicator with bounce */
    @keyframes scroll-bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); opacity: 0.7; }
        40% { transform: translateY(10px); opacity: 1; }
        60% { transform: translateY(5px); opacity: 0.9; }
    }
    
    .scroll-down-indicator {
        animation: scroll-bounce 2s ease-in-out infinite;
    }

    /* Stats counter animation */
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(168, 85, 247, 0.4); }
        50% { box-shadow: 0 0 30px rgba(168, 85, 247, 0.6); }
    }

    .stat-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }
    
    /* Quick Add Button Enhancement */
    .quick-add-btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    .quick-add-btn.success-state {
        background: linear-gradient(to right, #10b981, #059669) !important;
        color: white !important;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-100">
    <!-- Hero Section -->
    <div class="relative overflow-x-hidden bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-100 min-h-screen">
        <!-- Enhanced Animated Background Elements with multiple layers -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Layer 1: Large floating blobs -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-purple-300 to-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-60 float-animation"></div>
            <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-gradient-to-br from-pink-300 to-pink-100 rounded-full mix-blend-multiply filter blur-3xl opacity-60 float-animation-delayed"></div>
            <div class="absolute top-24 left-16 w-80 h-80 bg-gradient-to-br from-indigo-300 to-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-60 float-animation-slow"></div>
            
            <!-- Layer 2: Medium accent blobs -->
            <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-gradient-to-br from-yellow-200 to-orange-100 rounded-full mix-blend-multiply filter blur-2xl opacity-40 float-animation"></div>
            <div class="absolute bottom-1/4 right-1/3 w-72 h-72 bg-gradient-to-br from-teal-200 to-cyan-100 rounded-full mix-blend-multiply filter blur-2xl opacity-40 float-animation-delayed"></div>
            
            <!-- Layer 3: Small sparkle elements -->
            <div class="absolute top-20 left-1/3 w-32 h-32 bg-white/30 rounded-full filter blur-xl opacity-50 animate-pulse"></div>
            <div class="absolute bottom-32 right-1/4 w-24 h-24 bg-white/30 rounded-full filter blur-xl opacity-50 animate-pulse animation-delay-2000"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 py-12 sm:py-16 lg:py-20 relative z-10 overflow-visible">
            <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-12 lg:gap-32 xl:gap-40 min-h-[70vh] lg:min-h-[80vh] overflow-visible">
                <!-- Left Content (dynamic details) -->
                @php 
                    // Use recommendations for authenticated users, fallback to new arrivals
                    $heroBooks = Auth::check() && $recommendations && $recommendations->count() > 0 
                        ? $recommendations 
                        : $newArrivals->take(6); 
                    $firstHero = $heroBooks->first(); 
                @endphp
                @if($heroBooks->count() > 0)
                <div class="flex-1 lg:max-w-[42%] xl:max-w-[45%] text-gray-900 order-2 lg:order-1 flex flex-col items-center lg:items-start text-center lg:text-left flex-shrink-0" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="100">
                    <div class="mb-6" data-aos="fade-down" data-aos-delay="200">
                        <span class="inline-flex items-center px-5 py-2.5 bg-white/90 rounded-full text-sm font-semibold backdrop-blur-md border border-white/80 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                            <span class="relative flex w-3 h-3 mr-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-gradient-to-r from-yellow-400 to-orange-400"></span>
                            </span>
                            <span id="hero-genre" class="text-fade bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                @if(Auth::check() && $recommendations && $recommendations->count() > 0)
                                    ✨ Recommended for You
                                @else
                                    {{ optional($firstHero)->genre?->name ?? '⭐ Featured' }}
                                @endif
                            </span>
                        </span>
                    </div>
                    <h1 id="hero-title" class="text-fade text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-extrabold leading-tight mb-6 font-serif bg-gradient-to-r from-slate-900 via-purple-800 to-indigo-800 bg-clip-text text-transparent animated-gradient drop-shadow-sm break-words" style="line-height: 1.15;" data-aos="fade-up" data-aos-delay="300">
                        {{ $firstHero?->title }}
                    </h1>
                    <p id="hero-synopsis" class="text-fade text-base md:text-lg mb-10 w-full text-slate-600 leading-relaxed" data-aos="fade-up" data-aos-delay="400">
                        {{ \Illuminate\Support\Str::limit($firstHero?->synopsis ?? 'Discover your next favorite story.', 180) }}
                    </p>
                    <div class="flex flex-col sm:flex-row w-full items-stretch sm:items-center justify-center lg:justify-start gap-4 sm:gap-6" data-aos="fade-up" data-aos-delay="500">
                        <a id="hero-details-link" href="{{ $firstHero ? route('books.show', $firstHero) : '#' }}" class="group relative inline-flex items-center justify-center w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-purple-600 via-pink-600 to-purple-600 text-white font-bold rounded-full transition-all duration-500 shadow-2xl hover:shadow-purple-500/50 hover:scale-105 transform overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-purple-700 via-pink-700 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                            <span class="relative flex items-center">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                VIEW DETAILS
                            </span>
                            <svg class="w-5 h-5 ml-2 relative group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        @if($firstHero)
                        <button onclick="quickAddToCart({{ $firstHero?->id }})" id="hero-quick-add" class="quick-add-btn group relative inline-flex items-center justify-center w-full sm:w-auto px-10 py-4 border-2 border-purple-200 text-purple-700 font-bold rounded-full bg-white/95 backdrop-blur-md hover:bg-white hover:border-purple-300 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <span class="btn-text relative flex items-center">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Quick Add to Cart
                            </span>
                            <span class="loading-spinner hidden relative">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-purple-700 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Adding...
                            </span>
                        </button>
                        @endif
                    </div>
                    
                    <!-- Enhanced Stats Row -->
                    <div class="w-full mt-16 sm:mt-20 pt-10 border-t border-purple-200/60" data-aos="fade-up" data-aos-delay="600">
                        <div class="flex items-center justify-center lg:justify-start gap-8 sm:gap-12 flex-wrap">
                            <div class="group text-center transform hover:scale-110 transition-all duration-300" data-aos="zoom-in" data-aos-delay="200">
                                <div class="relative inline-block mb-2">
                                    <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-400 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                                    <div class="relative px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-purple-100">
                                        <div class="text-4xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent animated-gradient">10K+</div>
                                    </div>
                                </div>
                                <div class="text-slate-600 text-sm font-semibold mt-2 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                    </svg>
                                    Happy Readers
                                </div>
                            </div>
                            
                            <div class="hidden sm:block w-px h-12 bg-gradient-to-b from-transparent via-purple-200 to-transparent"></div>
                            
                            <div class="group text-center transform hover:scale-110 transition-all duration-300" data-aos="zoom-in" data-aos-delay="400">
                                <div class="relative inline-block mb-2">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-blue-400 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                                    <div class="relative px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-indigo-100">
                                        <div class="text-4xl font-extrabold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent animated-gradient">5K+</div>
                                    </div>
                                </div>
                                <div class="text-slate-600 text-sm font-semibold mt-2 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                    </svg>
                                    Books Available
                                </div>
                            </div>
                            
                            <div class="hidden sm:block w-px h-12 bg-gradient-to-b from-transparent via-purple-200 to-transparent"></div>
                            
                            <div class="group text-center transform hover:scale-110 transition-all duration-300" data-aos="zoom-in" data-aos-delay="600">
                                <div class="relative inline-block mb-2">
                                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                                    <div class="relative px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-yellow-100">
                                        <div class="text-4xl font-extrabold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent animated-gradient">4.8/5</div>
                                    </div>
                                </div>
                                <div class="text-slate-600 text-sm font-semibold mt-2 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Average Rating
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Enhanced 3D Portrait cover slider -->
                <div class="flex-1 lg:max-w-[40%] xl:max-w-[35%] w-full order-1 lg:order-2 perspective-container overflow-visible flex-shrink-0 pr-4 lg:pr-6 xl:pr-8" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="relative w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-md xl:max-w-lg mx-auto h-[450px] sm:h-[550px] lg:h-[600px] overflow-visible">
                        <!-- Ambient glow effect behind carousel -->
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-400/30 via-pink-400/30 to-indigo-400/30 rounded-3xl blur-3xl scale-110 opacity-50"></div>
                        
                        <!-- Carousel container -->
                        <div id="heroCoverCarousel" class="relative w-full h-full overflow-visible">
                            @foreach($heroBooks as $i => $book)
                                @php
                                    $coverPath = $book->cover_image;
                                    $coverUrl = null;
                                    try {
                                        if ($coverPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($coverPath)) {
                                            $coverUrl = \Illuminate\Support\Facades\Storage::url($coverPath);
                                        }
                                    } catch (\Throwable $e) {
                                        $coverUrl = null;
                                    }
                                @endphp
                                <div
                                    class="hero-item absolute inset-0 transition-all duration-700 ease-out rounded-3xl shadow-2xl ring-1 ring-white/20 overflow-hidden bg-white backdrop-blur-sm cursor-pointer group opacity-0"
                                    data-title="{{ $book->title }}"
                                    data-genre="{{ optional($book->genre)->name }}"
                                    data-synopsis="{{ \Illuminate\Support\Str::limit($book->synopsis ?? '', 220) }}"
                                    data-link="{{ route('books.show', $book) }}"
                                    data-book-id="{{ $book->id }}"
                                    style="transform: translateX(0) translateZ(-500px) scale(0.5); filter: brightness(0.3);"
                                >
                                    @if($coverUrl)
                                        <img src="{{ $coverUrl }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"/>
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400"></div>
                                    @endif
                                    
                                    <!-- Hover overlay with book info -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                                        <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                            <h3 class="text-white font-bold text-xl mb-2 line-clamp-2">{{ $book->title }}</h3>
                                            <p class="text-white/80 text-sm line-clamp-1">{{ $book->author }}</p>
                                            <div class="mt-3 flex items-center gap-2">
                                                <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-white text-xs font-medium">
                                                    {{ $book->genre?->name }}
                                                </span>
                                                @if($book->is_on_sale)
                                                <span class="px-3 py-1 bg-red-500/90 backdrop-blur-md rounded-full text-white text-xs font-bold">
                                                    -{{ $book->discount_percent }}% OFF
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Navigation dots -->
                        <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 flex gap-2" id="carousel-dots">
                            @foreach($heroBooks as $i => $book)
                            <button 
                                class="carousel-dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-purple-600 w-8' : 'bg-purple-300 hover:bg-purple-400' }}"
                                data-index="{{ $i }}"
                            ></button>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <!-- Empty state when no books are available -->
                <div class="flex-1 lg:max-w-[45%] xl:max-w-[50%] text-gray-900 order-2 lg:order-1 flex flex-col items-center lg:items-start text-center lg:text-left flex-shrink-0" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="100">
                    <div class="mb-6" data-aos="fade-down" data-aos-delay="200">
                        <span class="inline-flex items-center px-5 py-2.5 bg-white/90 rounded-full text-sm font-semibold backdrop-blur-md border border-white/80 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                            <span class="relative flex w-3 h-3 mr-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-gradient-to-r from-yellow-400 to-orange-400"></span>
                            </span>
                            <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">⭐ Welcome to Bookty</span>
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-extrabold leading-tight mb-6 font-serif bg-gradient-to-r from-slate-900 via-purple-800 to-indigo-800 bg-clip-text text-transparent animated-gradient drop-shadow-sm break-words" style="line-height: 1.15;" data-aos="fade-up" data-aos-delay="300">
                        Discover Amazing Books
                    </h1>
                    <p class="text-base md:text-lg mb-10 w-full text-slate-600 leading-relaxed" data-aos="fade-up" data-aos-delay="400">
                        Your journey into the world of literature starts here. Browse our collection and find your next favorite read.
                    </p>
                    <div class="flex flex-col sm:flex-row w-full items-stretch sm:items-center justify-center lg:justify-start gap-4 sm:gap-6" data-aos="fade-up" data-aos-delay="500">
                        <a href="{{ route('books.index') }}" class="group relative inline-flex items-center justify-center w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-purple-600 via-pink-600 to-purple-600 text-white font-bold rounded-full transition-all duration-500 shadow-2xl hover:shadow-purple-500/50 hover:scale-105 transform overflow-hidden">
                            <span class="absolute inset-0 bg-gradient-to-r from-purple-700 via-pink-700 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                            <span class="relative flex items-center">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                BROWSE BOOKS
                            </span>
                            <svg class="w-5 h-5 ml-2 relative group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endif
                                </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const container = document.getElementById('heroCoverCarousel');
                    if (!container) return;
                    const slides = Array.from(container.querySelectorAll('.hero-item'));
                    if (slides.length < 1) return;

                    const textElements = {
                        title: document.getElementById('hero-title'),
                        genre: document.getElementById('hero-genre'),
                        synopsis: document.getElementById('hero-synopsis'),
                        detailsLink: document.getElementById('hero-details-link'),
                        quickAddBtn: document.getElementById('hero-quick-add'),
                    };

                    const dots = Array.from(document.querySelectorAll('.carousel-dot'));
                    let currentIndex = 0;
                    let timer;
                    let isTransitioning = false;

                    const updateTextContent = (slide) => {
                        // Add fade-out effect to all text elements
                        Object.values(textElements).forEach(el => el?.classList.add('text-fade-out'));

                        setTimeout(() => {
                            const data = slide.dataset;
                            if (textElements.title) textElements.title.textContent = data.title || '';
                            if (textElements.genre) {
                                const isRecommended = textElements.genre.textContent.includes('Recommended');
                                textElements.genre.textContent = isRecommended ? '✨ Recommended for You' : (data.genre || '⭐ Featured');
                            }
                            if (textElements.synopsis) textElements.synopsis.textContent = data.synopsis || '';
                            if (textElements.detailsLink) textElements.detailsLink.href = data.link || '#';
                            if (textElements.quickAddBtn && data.bookId) {
                                textElements.quickAddBtn.setAttribute('onclick', `quickAddToCart(${data.bookId})`);
                                // Reset button state in case it was changed
                                const btnText = textElements.quickAddBtn.querySelector('.btn-text');
                                const loadingSpinner = textElements.quickAddBtn.querySelector('.loading-spinner');
                                if (btnText) {
                                    btnText.textContent = 'Quick Add to Cart';
                                    btnText.classList.remove('hidden');
                                }
                                if (loadingSpinner) loadingSpinner.classList.add('hidden');
                                textElements.quickAddBtn.disabled = false;
                                textElements.quickAddBtn.classList.remove('success-state');
                            }
                            
                            // Remove fade-out effect after updating content
                            Object.values(textElements).forEach(el => el?.classList.remove('text-fade-out'));
                        }, 500); // Corresponds to transition duration
                    };

                    const updateDots = (activeIndex) => {
                        dots.forEach((dot, i) => {
                            if (i === activeIndex) {
                                dot.classList.add('bg-purple-600', 'w-8');
                                dot.classList.remove('bg-purple-300', 'w-2.5');
                            } else {
                                dot.classList.remove('bg-purple-600', 'w-8');
                                dot.classList.add('bg-purple-300', 'w-2.5');
                            }
                        });
                    };

                    const updateCarousel = (activeIndex, skipTransition = false) => {
                        if (isTransitioning && !skipTransition) return;
                        if (!skipTransition) isTransitioning = true;

                        const total = slides.length;
                        slides.forEach((slide, i) => {
                            slide.classList.remove('z-30', 'z-20', 'z-10', 'opacity-100', 'opacity-60', 'opacity-30', 'opacity-0', 'pointer-events-auto', 'pointer-events-none');

                            let offset = (i - activeIndex + total) % total;
                            
                            if (offset === 0) { // Front - center stage
                                slide.classList.add('z-30', 'opacity-100', 'pointer-events-auto');
                                slide.style.transform = 'translateX(0) translateZ(0) scale(1.0) rotateY(0deg)';
                                slide.style.filter = 'brightness(1)';
                            } else if (offset === 1) { // Right side
                                slide.classList.add('z-20', 'opacity-60', 'pointer-events-none');
                                slide.style.transform = 'translateX(60%) translateZ(-150px) scale(0.8) rotateY(-35deg)';
                                slide.style.filter = 'brightness(0.7)';
                            } else if (offset === total - 1) { // Left side
                                slide.classList.add('z-20', 'opacity-60', 'pointer-events-none');
                                slide.style.transform = 'translateX(-60%) translateZ(-150px) scale(0.8) rotateY(35deg)';
                                slide.style.filter = 'brightness(0.7)';
                            } else if (offset === 2) { // Far right
                                slide.classList.add('z-10', 'opacity-30', 'pointer-events-none');
                                slide.style.transform = 'translateX(110%) translateZ(-300px) scale(0.6) rotateY(-50deg)';
                                slide.style.filter = 'brightness(0.5)';
                            } else if (offset === total - 2) { // Far left
                                slide.classList.add('z-10', 'opacity-30', 'pointer-events-none');
                                slide.style.transform = 'translateX(-110%) translateZ(-300px) scale(0.6) rotateY(50deg)';
                                slide.style.filter = 'brightness(0.5)';
                            } else { // Hidden
                                slide.classList.add('z-10', 'opacity-0', 'pointer-events-none');
                                slide.style.transform = `translateX(${offset > total / 2 ? '-150%' : '150%'}) translateZ(-400px) scale(0.5)`;
                                slide.style.filter = 'brightness(0.3)';
                            }
                        });
                        
                        updateTextContent(slides[activeIndex]);
                        updateDots(activeIndex);
                        
                        if (!skipTransition) {
                            setTimeout(() => {
                                isTransitioning = false;
                            }, 800);
                        }
                    };

                    const next = () => {
                        currentIndex = (currentIndex + 1) % slides.length;
                        updateCarousel(currentIndex);
                    };

                    const goToSlide = (index) => {
                        if (index !== currentIndex && !isTransitioning) {
                            currentIndex = index;
                            updateCarousel(currentIndex);
                            restart();
                        }
                    };

                    const start = () => { 
                        timer = setInterval(next, 6000); // Increased to 6 seconds
                    };
                    
                    const stop = () => { 
                        if (timer) clearInterval(timer); 
                    };
                    
                    const restart = () => {
                        stop();
                        start();
                    };

                    // Event listeners
                    container.addEventListener('mouseenter', stop);
                    container.addEventListener('mouseleave', start);
                    
                    // Dot navigation
                    dots.forEach((dot, index) => {
                        dot.addEventListener('click', () => goToSlide(index));
                    });

                    // Click on slides to navigate
                    slides.forEach((slide, index) => {
                        slide.addEventListener('click', (e) => {
                            if (index !== currentIndex) {
                                e.preventDefault();
                                goToSlide(index);
                            }
                        });
                    });

                    // Initialize - skip transition for immediate positioning
                    updateCarousel(currentIndex, true);
                    start();
                });
            </script>
        </div>
        
        <!-- Enhanced Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center justify-center gap-2 scroll-down-indicator">
            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Scroll Down</span>
            <div class="flex flex-col items-center gap-1">
                <svg class="w-6 h-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = Array.from(document.querySelectorAll('#genreFilters .genre-filter-btn'));
            const items = Array.from(document.querySelectorAll('#genreGallery .gallery-item'));
            const emptyState = document.getElementById('galleryEmptyState');

            function applyFilter(filter) {
                let visible = 0;
                items.forEach((el) => {
                    const match = filter === 'all' || String(el.dataset.genreId) === String(filter);
                    el.style.display = match ? '' : 'none';
                    if (match) visible++;
                });
                if (emptyState) emptyState.classList.toggle('hidden', visible > 0);
            }

            function setActive(btn) {
                filterButtons.forEach(b => {
                    b.classList.remove('bg-indigo-700','text-white','border-indigo-700');
                    b.classList.add('bg-white','text-gray-900','border-white');
                });
                btn.classList.remove('bg-white','text-gray-900','border-white');
                btn.classList.add('bg-indigo-700','text-white','border-indigo-700');
            }

            filterButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    setActive(btn);
                    applyFilter(btn.dataset.filter);
                });
            });

            // Initialize
            const initial = document.querySelector('#genreFilters .genre-filter-btn[data-filter="all"]');
            if (initial) setActive(initial);
            applyFilter('all');
        });
    </script>
                            
   
    <!-- For You Section (Personalized Recommendations) -->
    @auth
    <div class="py-20 bg-gradient-to-br from-purple-50 to-indigo-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12" data-aos="fade-up">
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 rounded-full text-sm font-medium mb-6 text-purple-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Personalized for You
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Recommended Just for You
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Based on your reading preferences, purchase history, and favorite genres, here are books we think you'll love.
                </p>
            </div>

            <!-- Recommendations Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="recommendations-grid">
                <!-- Loading state -->
                <div class="col-span-full text-center py-12">
                    <div class="inline-flex items-center px-4 py-2 bg-white rounded-lg shadow-sm">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading personalized recommendations...
                    </div>
                </div>
            </div>

            <!-- View More Button -->
            <div class="text-center mt-12">
                <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-purple-400/40">
                    <span>View All Books</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @endauth

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
                @if($newArrivals->count() > 0)
                    @foreach($newArrivals as $book)
                    <div class="gallery-item group relative" data-genre-id="{{ $book->genre?->id ?? '' }}" data-aos="fade-up">
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
                                <div class="text-xs opacity-80">{{ $book->author }} • {{ $book->genre?->name ?? 'Unknown' }}</div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                @else
                    <!-- Empty state for no books -->
                    <div class="col-span-full text-center py-12">
                        <div class="inline-flex items-center px-6 py-3 rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            No books available yet. Check back soon!
                        </div>
                    </div>
                @endif
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
                                    class="ajax-add-to-cart mt-3 w-full py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white text-sm font-medium rounded hover:from-red-700 hover:to-pink-700 transition-colors duration-300 flex items-center justify-center"
                                    data-book-id="{{ $book->id }}"
                                    data-quantity="1">
                                    Add to Cart
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

            @if($testimonials->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php 
                    $gradients = [
                        'from-purple-400 to-pink-400',
                        'from-indigo-400 to-blue-400',
                        'from-emerald-400 to-teal-400'
                    ];
                    $delays = [200, 400, 600];
                @endphp
                
                @foreach($testimonials as $index => $testimonial)
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100" data-aos="fade-up" data-aos-delay="{{ $delays[$index % 3] }}">
                    <div class="flex items-center mb-6">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <blockquote class="text-gray-700 mb-6 leading-relaxed">
                        "{{ \Illuminate\Support\Str::limit($testimonial->comment, 180) }}"
                    </blockquote>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br {{ $gradients[$index % 3] }} rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $testimonial->user->name }}</div>
                            <div class="text-sm text-gray-600">Verified Customer</div>
                            @if($testimonial->book)
                            <div class="text-xs text-purple-600 mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                {{ \Illuminate\Support\Str::limit($testimonial->book->title, 30) }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- Fallback message when no testimonials -->
            <div class="text-center py-16">
                <div class="bg-white rounded-2xl p-12 shadow-lg max-w-2xl mx-auto border border-gray-100">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Be the First to Share Your Experience!</h3>
                    <p class="text-gray-600">
                        We'd love to hear what you think about your recent book purchases. 
                        <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-medium">Sign in</a> 
                        to leave a review.
                    </p>
                </div>
            </div>
            @endif

            <!-- Trust Indicators -->
            <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="800">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center group cursor-pointer transform hover:scale-110 transition-all duration-300">
                        <div class="text-3xl md:text-4xl font-bold text-indigo-600 mb-2 group-hover:text-indigo-700 transition-colors">
                            @if($totalCustomers >= 1000)
                                {{ number_format($totalCustomers / 1000, 1) }}K+
                            @else
                                {{ number_format($totalCustomers) }}+
                            @endif
                        </div>
                        <div class="text-gray-600 font-medium">Happy Customers</div>
                    </div>
                    <div class="text-center group cursor-pointer transform hover:scale-110 transition-all duration-300">
                        <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2 group-hover:text-purple-700 transition-colors">
                            @if($totalBooksSold >= 1000)
                                {{ number_format($totalBooksSold / 1000, 1) }}K+
                            @else
                                {{ number_format($totalBooksSold) }}+
                            @endif
                        </div>
                        <div class="text-gray-600 font-medium">Books Sold</div>
                    </div>
                    <div class="text-center group cursor-pointer transform hover:scale-110 transition-all duration-300">
                        <div class="text-3xl md:text-4xl font-bold text-pink-600 mb-2 group-hover:text-pink-700 transition-colors">
                            {{ $averageRating ? number_format($averageRating, 1) : '5.0' }}/5
                        </div>
                        <div class="text-gray-600 font-medium">Average Rating</div>
                    </div>
                    <div class="text-center group cursor-pointer transform hover:scale-110 transition-all duration-300">
                        <div class="text-3xl md:text-4xl font-bold text-orange-600 mb-2 group-hover:text-orange-700 transition-colors">
                            {{ $satisfactionRate }}%
                        </div>
                        <div class="text-gray-600 font-medium">Satisfaction Rate</div>
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
                @if($newArrivals->count() > 0)
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
                                        <button type="button" 
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
                                <span class="text-xs px-3 py-1 bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-700 rounded-full font-medium">{{ $book->genre?->name ?? 'Unknown' }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Empty state for New Arrivals -->
                    <div class="col-span-full text-center py-12">
                        <div class="inline-flex items-center px-6 py-3 rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            No new arrivals yet. Check back soon!
                        </div>
                    </div>
                @endif
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

    <!-- Load Recommendations Script -->
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load personalized recommendations
            if (window.RecommendationManager) {
                window.RecommendationManager.loadRecommendations('recommendations-grid', 8);
            }
        });
    </script>
    @endauth

@endsection


