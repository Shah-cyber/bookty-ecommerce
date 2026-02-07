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

    <!-- Homepage Skeleton Loader -->
    <div id="home-skeleton" class="animate-pulse">
        <div class="min-h-screen bg-white">
            <!-- Hero Skeleton -->
            <div class="relative min-h-screen bg-white">
                <div class="container mx-auto px-4 sm:px-6 py-16 lg:py-24">
                    <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                        <!-- Left: Text skeleton -->
                        <div class="flex-1 w-full lg:max-w-[45%] space-y-6">
                            <div class="h-8 w-40 bg-white/80 rounded-full"></div>
                            <div class="space-y-3 mt-4">
                                <div class="h-10 w-3/4 bg-white rounded-xl"></div>
                                <div class="h-10 w-2/3 bg-white rounded-xl"></div>
                            </div>
                            <div class="space-y-2 mt-6">
                                <div class="h-4 w-full bg-white/90 rounded-lg"></div>
                                <div class="h-4 w-5/6 bg-white/80 rounded-lg"></div>
                                <div class="h-4 w-2/3 bg-white/70 rounded-lg"></div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-4 mt-8 w-full">
                                <div class="h-12 w-full sm:w-40 bg-primary-300/40 rounded-full"></div>
                                <div class="h-12 w-full sm:w-40 bg-white/80 rounded-full"></div>
                            </div>
                            <div class="mt-10 pt-6 border-t border-primary-300/20 flex flex-wrap gap-8">
                                <div class="space-y-2">
                                    <div class="h-6 w-20 bg-white rounded-lg"></div>
                                    <div class="h-3 w-24 bg-white/80 rounded-full"></div>
                                </div>
                                <div class="space-y-2">
                                    <div class="h-6 w-24 bg-white rounded-lg"></div>
                                    <div class="h-3 w-28 bg-white/80 rounded-full"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Cover carousel skeleton -->
                        <div class="flex-1 w-full">
                            <div class="mx-auto max-w-md lg:max-w-lg">
                                <div class="relative">
                                    <div class="h-80 sm:h-96 bg-gradient-to-br from-primary-50 to-primary-100 rounded-3xl shadow-2xl"></div>
                                    <div class="absolute -right-6 -bottom-6 w-40 h-40 bg-white/80 rounded-3xl shadow-xl"></div>
                                    <div class="absolute -left-6 -top-6 w-32 h-32 bg-white/60 rounded-3xl shadow-lg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured / New Arrivals Skeleton -->
            <div class="py-16 bg-white/60">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="flex items-center justify-between mb-8">
                        <div class="space-y-2">
                            <div class="h-4 w-32 bg-gray-200 rounded-full"></div>
                            <div class="h-7 w-48 bg-gray-300 rounded-lg"></div>
                        </div>
                        <div class="h-10 w-32 bg-gray-200 rounded-full hidden sm:block"></div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 space-y-4">
                                <div class="h-40 md:h-48 bg-gray-200 rounded-xl"></div>
                                <div class="space-y-2">
                                    <div class="h-4 w-5/6 bg-gray-200 rounded-full"></div>
                                    <div class="h-3 w-1/2 bg-gray-200 rounded-full"></div>
                                </div>
                                <div class="h-5 w-2/3 bg-gray-200 rounded-full"></div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Newsletter Skeleton -->
            <div class="py-16 bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800">
                <div class="container mx-auto px-6">
                    <div class="max-w-3xl mx-auto text-center space-y-6">
                        <div class="h-4 w-40 bg-white/30 rounded-full mx-auto"></div>
                        <div class="space-y-3">
                            <div class="h-8 w-56 bg-white/70 rounded-lg mx-auto"></div>
                            <div class="h-8 w-64 bg-white/60 rounded-lg mx-auto"></div>
                        </div>
                        <div class="space-y-2 mt-4">
                            <div class="h-4 w-5/6 bg-white/40 rounded-full mx-auto"></div>
                            <div class="h-4 w-4/6 bg-white/30 rounded-full mx-auto"></div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4 mt-8 max-w-xl mx-auto">
                            <div class="h-12 flex-1 bg-white/80 rounded-2xl"></div>
                            <div class="h-12 w-40 bg-yellow-300/90 rounded-2xl mx-auto sm:mx-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Real Homepage Content -->
    <div id="home-content" class="hidden">

    <div class="min-h-screen bg-white">
        <!-- Hero Section -->
        <div class="relative overflow-x-hidden bg-white min-h-screen">
            <!-- Enhanced Animated Background Elements with multiple layers -->
            <div class="absolute inset-0 overflow-hidden">
                <!-- Layer 1: Large floating blobs -->
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100/40 rounded-full mix-blend-multiply filter blur-3xl opacity-60 float-animation"></div>
                <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-purple-50/40 rounded-full mix-blend-multiply filter blur-3xl opacity-60 float-animation-delayed"></div>
                <div class="absolute top-24 left-16 w-80 h-80 bg-gray-50 rounded-full mix-blend-multiply filter blur-3xl opacity-60 float-animation-slow"></div>

                <!-- Layer 2: Medium accent blobs -->
                <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-gray-100/40 rounded-full mix-blend-multiply filter blur-2xl opacity-40 float-animation"></div>
                <div class="absolute bottom-1/4 right-1/3 w-72 h-72 bg-blue-50/30 rounded-full mix-blend-multiply filter blur-2xl opacity-40 float-animation-delayed"></div>

                <!-- Layer 3: Small sparkle elements -->
                <div class="absolute top-20 left-1/3 w-32 h-32 bg-white/60 rounded-full filter blur-xl opacity-50 animate-pulse"></div>
                <div class="absolute bottom-32 right-1/4 w-24 h-24 bg-white/60 rounded-full filter blur-xl opacity-50 animate-pulse animation-delay-2000"></div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 py-12 sm:py-16 lg:py-20 relative z-10 overflow-visible">
                <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-12 lg:gap-32 xl:gap-40 min-h-[70vh] lg:min-h-[80vh] overflow-visible">
                    <!-- Left Content (dynamic details) -->
                    @php 
                        // Use recommendations for authenticated users (up to 6 books)
                        // Use heroBooks for guest users (3 newest books)
                        $displayHeroBooks = Auth::check() && $recommendations && $recommendations->count() > 0
                            ? $recommendations
                            : $heroBooks;
                        $firstHero = $displayHeroBooks->first(); 
                    @endphp
                    @if($displayHeroBooks->count() > 0)
                        <div class="flex-1 lg:max-w-[42%] xl:max-w-[45%] text-gray-900 order-2 lg:order-1 flex flex-col items-center lg:items-start text-center lg:text-left flex-shrink-0" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="100">
                            <div class="mb-6" data-aos="fade-down" data-aos-delay="200">
                                <span class="inline-flex items-center px-4 py-2 bg-white/80 rounded-full text-sm font-bold backdrop-blur-md border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 hover:scale-105">
                                    <span class="relative flex w-2.5 h-2.5 mr-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                                    </span>
                                    <span id="hero-genre" class="text-fade text-gray-800 tracking-wide uppercase text-xs">
                                        @if(Auth::check() && $recommendations && $recommendations->count() > 0)
                                            Recommended for You
                                        @else
                                            {{ optional($firstHero)->genre?->name ?? 'Featured' }}
                                        @endif
                                    </span>
                                </span>
                            </div>
                            <h1 id="hero-title" class="text-fade text-5xl md:text-6xl lg:text-7xl font-black leading-tight mb-6 font-sans text-gray-900 tracking-tight break-words" style="line-height: 1.1;" data-aos="fade-up" data-aos-delay="300">
                                {{ $firstHero?->title }}
                            </h1>
                            <p id="hero-synopsis" class="text-fade text-lg md:text-xl mb-10 w-full text-gray-500 leading-relaxed font-medium max-w-xl" data-aos="fade-up" data-aos-delay="400">
                                {{ \Illuminate\Support\Str::limit($firstHero?->synopsis ?? 'Discover your next favorite story.', 180) }}
                            </p>
                            <div class="flex flex-col sm:flex-row w-full items-stretch sm:items-center justify-center lg:justify-start gap-4 sm:gap-6" data-aos="fade-up" data-aos-delay="500">
                                <a id="hero-details-link" href="{{ $firstHero ? route('books.show', $firstHero) : '#' }}" class="group relative inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 bg-gray-900 text-white font-bold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 hover:bg-black">
                                    <span class="relative flex items-center">
                                        View Details
                                    </span>
                                    <svg class="w-5 h-5 ml-2 relative group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                                @if($firstHero)
                                    @auth
                                        <button onclick="quickAddToCart({{ $firstHero?->id }})" id="hero-quick-add" class="quick-add-btn group relative inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 border border-gray-200 text-gray-700 font-bold rounded-full bg-white hover:bg-gray-50 transition-all duration-300 shadow-sm hover:shadow-md hover:border-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span class="btn-text relative flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                                Quick Add
                                            </span>
                                            <span class="loading-spinner hidden relative">
                                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-gray-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Adding...
                                            </span>
                                        </button>
                                    @else
                                        <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }))" id="hero-quick-add-guest" class="group relative inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 border border-gray-200 text-gray-700 font-bold rounded-full bg-white hover:bg-gray-50 transition-all duration-300 shadow-sm hover:shadow-md hover:border-gray-300">
                                            <span class="relative flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                                Quick Add
                                            </span>
                                        </button>
                                    @endauth
                                @endif
                            </div>

                            <!-- Enhanced Stats Row -->
                            <div class="w-full mt-16 sm:mt-20 pt-10 border-t border-primary-300/20" data-aos="fade-up" data-aos-delay="600">
                                <div class="flex items-center justify-center lg:justify-start gap-8 sm:gap-12 flex-wrap">
                                    <div class="group text-center transform hover:scale-110 transition-all duration-300" data-aos="zoom-in" data-aos-delay="200">
                                        <div class="relative inline-block mb-2">
                                            <div class="absolute inset-0 bg-primary-300 rounded-2xl blur-xl opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                                            <div class="relative px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-primary-300/20">
                                                <div class="text-4xl font-extrabold text-[#2D2D2D]">10K+</div>
                                    </div>
                                    </div>
                                        <div class="text-primary-800 text-sm font-semibold mt-2 flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1 text-primary-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                            Happy Readers
                                    </div>
                                </div>

                                    <div class="hidden sm:block w-px h-12 bg-primary-300/20"></div>

                                    <div class="group text-center transform hover:scale-110 transition-all duration-300" data-aos="zoom-in" data-aos-delay="400">
                                        <div class="relative inline-block mb-2">
                                            <div class="absolute inset-0 bg-primary-300 rounded-2xl blur-xl opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                                            <div class="relative px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-primary-300/20">
                                                <div class="text-4xl font-extrabold text-[#2D2D2D]">5K+</div>
                                            </div>
                                        </div>
                                        <div class="text-primary-800 text-sm font-semibold mt-2 flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1 text-primary-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                            </svg>
                                            Books Available
                            </div>
                        </div>

                                    <div class="hidden sm:block w-px h-12 bg-primary-300/20"></div>

                                    <div class="group text-center transform hover:scale-110 transition-all duration-300" data-aos="zoom-in" data-aos-delay="600">
                                        <div class="relative inline-block mb-2">
                                            <div class="absolute inset-0 bg-primary-300 rounded-2xl blur-xl opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                                            <div class="relative px-6 py-3 bg-white/80 backdrop-blur-sm rounded-2xl border border-primary-300/20">
                                                <div class="text-4xl font-extrabold text-[#2D2D2D]">4.8/5</div>
                                            </div>
                                        </div>
                                        <div class="text-primary-800 text-sm font-semibold mt-2 flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1 text-primary-300" fill="currentColor" viewBox="0 0 20 20">
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
                                <div class="absolute inset-0 bg-primary-300/20 rounded-3xl blur-3xl scale-110 opacity-50"></div>

                                <!-- Carousel container -->
                                <div id="heroCoverCarousel" class="relative w-full h-full overflow-visible">
                                    @foreach($displayHeroBooks as $i => $book)
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
                                            class="hero-item absolute inset-0 transition-all duration-700 ease-out rounded-3xl shadow-xl ring-1 ring-gray-100/50 overflow-hidden bg-white/80 backdrop-blur-md cursor-pointer group opacity-0"
                                            data-title="{{ $book->title }}"
                                            data-genre="{{ optional($book->genre)->name }}"
                                            data-synopsis="{{ \Illuminate\Support\Str::limit($book->synopsis ?? '', 220) }}"
                                            data-link="{{ route('books.show', $book) }}"
                                            data-book-id="{{ $book->id }}"
                                            style="transform: translateX(0) translateZ(-500px) scale(0.5); filter: brightness(0.9);"
                                        >
                                            @if($coverUrl)
                                                <img src="{{ $coverUrl }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"/>
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100"></div>
                                            @endif

                                            <!-- Condition Badge -->
                                            <div class="absolute top-4 left-4 z-10">
                                                @if(($book->condition ?? 'new') === 'preloved')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-amber-600 shadow-sm border border-white/50">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                        Preloved
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-emerald-600 shadow-sm border border-white/50">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        New
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Hover overlay with book info -->
                                            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 w-full">
                                                    <span class="inline-block px-3 py-1 mb-2 rounded-full bg-rose-100 text-rose-600 text-xs font-bold tracking-wide uppercase">
                                                        {{ $book->genre?->name }}
                                                    </span>
                                                    <h3 class="text-gray-900 font-black text-xl mb-1 line-clamp-2 leading-tight">{{ $book->title }}</h3>
                                                    <p class="text-gray-600 text-sm font-medium line-clamp-1 mb-3">{{ $book->author }}</p>
                                                    
                                                    <div class="flex items-center justify-between w-full border-t border-gray-100 pt-3">
                                                        <span class="text-gray-900 font-bold text-lg">
                                                            RM{{ number_format($book->price, 2) }}
                                                        </span>
                                                        @if($book->is_on_sale)
                                                            <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-md">
                                                                -{{ $book->discount_percent }}%
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Enhanced Navigation Controls -->
                                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2 flex items-center gap-6 group/nav px-6 py-2 transition-all">
                                    <!-- Prev Arrow -->
                                    <button id="carousel-prev" class="p-3 rounded-full bg-white text-gray-400 shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-gray-900 hover:shadow-md transition-all duration-300 opacity-0 group-hover/nav:opacity-100 -translate-x-2 group-hover/nav:translate-x-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Dots -->
                                    <div class="flex gap-3" id="carousel-dots">
                                        @foreach($displayHeroBooks as $i => $book)
                                            <button 
                                                class="carousel-dot w-2 h-2 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-gray-800 w-8 scale-110' : 'bg-gray-300 hover:bg-gray-400' }}"
                                                data-index="{{ $i }}"
                                            ></button>
                                        @endforeach
                                    </div>

                                    <!-- Next Arrow -->
                                    <button id="carousel-next" class="p-3 rounded-full bg-white text-gray-400 shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-gray-900 hover:shadow-md transition-all duration-300 opacity-0 group-hover/nav:opacity-100 translate-x-2 group-hover/nav:translate-x-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty state when no books are available -->
                        <div class="flex-1 lg:max-w-[45%] xl:max-w-[50%] text-gray-900 order-2 lg:order-1 flex flex-col items-center lg:items-start text-center lg:text-left flex-shrink-0" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="100">
                            <div class="mb-6" data-aos="fade-down" data-aos-delay="200">
                                <span class="inline-flex items-center px-5 py-2.5 bg-white/90 rounded-full text-sm font-semibold backdrop-blur-md border border-white/80 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                    <span class="relative flex w-3 h-3 mr-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-300 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-primary-300"></span>
                                    </span>
                                    <span class="text-primary-800 font-medium">⭐ Welcome to Bookty</span>
                                </span>
                            </div>
                            <h1 class="text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-extrabold leading-tight mb-6 font-serif text-[#2D2D2D] drop-shadow-sm break-words" style="line-height: 1.15;" data-aos="fade-up" data-aos-delay="300">
                                Discover Amazing Books
                            </h1>
                            <p class="text-base md:text-lg mb-10 w-full text-primary-800 leading-relaxed" data-aos="fade-up" data-aos-delay="400">
                                Your journey into the world of literature starts here. Browse our collection and find your next favorite read.
                            </p>
                            <div class="flex flex-col sm:flex-row w-full items-stretch sm:items-center justify-center lg:justify-start gap-4 sm:gap-6" data-aos="fade-up" data-aos-delay="500">
                                <a href="{{ route('books.index') }}" class="group relative inline-flex items-center justify-center w-full sm:w-auto px-10 py-4 bg-primary-300 text-white font-bold rounded-full transition-all duration-500 shadow-xl hover:shadow-primary-300/40 hover:scale-105 transform overflow-hidden hover:bg-primary-400">
                                    <span class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
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
                        const prevBtn = document.getElementById('carousel-prev');
                        const nextBtn = document.getElementById('carousel-next');
                        
                        let currentIndex = 0; // Currently centered book
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
                                    textElements.genre.innerText = isRecommended ? '✨ Recommended for You' : (data.genre || 'Featured');
                                }
                                if (textElements.synopsis) textElements.synopsis.textContent = data.synopsis || '';
                                if (textElements.detailsLink) textElements.detailsLink.href = data.link || '#';
                                if (textElements.quickAddBtn && data.bookId) {
                                    textElements.quickAddBtn.setAttribute('onclick', `quickAddToCart(${data.bookId})`);
                                    // Reset button state in case it was changed
                                    const btnText = textElements.quickAddBtn.querySelector('.btn-text');
                                    const loadingSpinner = textElements.quickAddBtn.querySelector('.loading-spinner');
                                    if (btnText) {
                                        btnText.textContent = 'Quick Add';
                                        btnText.classList.remove('hidden');
                                    }
                                    if (loadingSpinner) loadingSpinner.classList.add('hidden');
                                    textElements.quickAddBtn.disabled = false;
                                    textElements.quickAddBtn.classList.remove('success-state');
                                }

                                // Remove fade-out effect after updating content
                                Object.values(textElements).forEach(el => el?.classList.remove('text-fade-out'));
                            }, 500);
                        };

                        const updateDots = (activeIndex) => {
                            // Highlight only the current centered book
                            dots.forEach((dot, i) => {
                                if (i === activeIndex) {
                                    dot.classList.add('bg-gray-800', 'w-8', 'scale-110');
                                    dot.classList.remove('bg-gray-300', 'hover:bg-gray-400');
                                } else {
                                    dot.classList.remove('bg-gray-800', 'w-8', 'scale-110');
                                    dot.classList.add('bg-gray-300', 'hover:bg-gray-400');
                                }
                            });
                        };

                        const updateCarousel = (centerIndex, skipTransition = false) => {
                            if (isTransitioning && !skipTransition) return;
                            if (!skipTransition) isTransitioning = true;

                            currentIndex = centerIndex;
                            const total = slides.length;
                            
                            slides.forEach((slide, i) => {
                                slide.classList.remove('z-30', 'z-20', 'z-10', 'opacity-100', 'opacity-80', 'opacity-60', 'opacity-40', 'opacity-0', 'pointer-events-auto', 'pointer-events-none');

                                // Calculate position relative to center
                                let offset = i - centerIndex;
                                
                                // Handling wrap-around for endless loop logic visually
                                if (offset < -1 && centerIndex === 0 && i === total - 1) offset = -1; // Last item acts as previous
                                if (offset > 1 && centerIndex === total - 1 && i === 0) offset = 1; // First item acts as next

                                if (i === centerIndex) { 
                                    // CENTER - Main book in focus
                                    slide.classList.add('z-30', 'opacity-100', 'pointer-events-auto');
                                    slide.style.transform = 'translateX(0) translateZ(0) scale(1.0)';
                                    slide.style.filter = 'brightness(1)';
                                } else if (offset === -1 || (centerIndex === 0 && i === total - 1)) { 
                                    // LEFT (Previous) - Tucked behind to the left
                                    slide.classList.add('z-20', 'opacity-100', 'pointer-events-auto');
                                    slide.style.transform = 'translateX(-15%) translateZ(-50px) scale(0.85)';
                                    slide.style.filter = 'brightness(0.5)';
                                } else if (offset === 1 || (centerIndex === total - 1 && i === 0)) { 
                                    // RIGHT (Next) - Tucked behind to the right
                                    slide.classList.add('z-20', 'opacity-100', 'pointer-events-auto');
                                    slide.style.transform = 'translateX(15%) translateZ(-50px) scale(0.85)';
                                    slide.style.filter = 'brightness(0.5)';
                                } else {
                                    // HIDDEN - All other books
                                    slide.classList.add('z-10', 'opacity-0', 'pointer-events-none');
                                    slide.style.transform = 'translateX(0) translateZ(-200px) scale(0.5)';
                                    slide.style.filter = 'brightness(0)';
                                }
                            });

                            // Update text content with the center book
                            updateTextContent(slides[centerIndex]);
                            updateDots(centerIndex);

                            if (!skipTransition) {
                                setTimeout(() => {
                                    isTransitioning = false;
                                }, 700);
                            }
                        };

                        const next = () => {
                            const nextIndex = (currentIndex + 1) % slides.length;
                            updateCarousel(nextIndex);
                        };

                        const prev = () => {
                            const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
                            updateCarousel(prevIndex);
                        };

                        const goToBook = (index) => {
                            if (index !== currentIndex && !isTransitioning) {
                                updateCarousel(index);
                                restart();
                            }
                        };

                        const start = () => { 
                            timer = setInterval(next, 6000);
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
                        
                        // Arrow Navigation
                        if (prevBtn) prevBtn.addEventListener('click', () => {
                            prev();
                            restart();
                        });

                        if (nextBtn) nextBtn.addEventListener('click', () => {
                            next();
                            restart();
                        });

                        // Dot navigation - each dot goes to that specific book
                        dots.forEach((dot, index) => {
                            dot.addEventListener('click', () => {
                                goToBook(index);
                            });
                        });

                        // Click on slides to center them
                        slides.forEach((slide, index) => {
                            slide.addEventListener('click', (e) => {
                                if (index !== currentIndex) {
                                    e.preventDefault();
                                    goToBook(index);
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
                        b.classList.remove('bg-primary-300','text-white','border-primary-700');
                        b.classList.add('bg-white','text-gray-900','border-white');
                    });
                    btn.classList.remove('bg-white','text-gray-900','border-white');
                    btn.classList.add('bg-primary-300','text-white','border-primary-700');
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
            <div class="py-24 bg-white border-b border-gray-50 relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-primary-50/50 rounded-full mix-blend-multiply filter blur-3xl opacity-30 translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-rose-50/50 rounded-full mix-blend-multiply filter blur-3xl opacity-30 -translate-x-1/2 translate-y-1/2"></div>
                
                <div class="container mx-auto px-6 relative z-10">
                    <div class="text-center mb-16" data-aos="fade-up">
                        <div class="inline-flex items-center px-4 py-2 bg-white rounded-full text-sm font-bold mb-6 text-gray-800 shadow-sm border border-gray-100">
                            <span class="relative flex h-2 w-2 mr-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                            </span>
                            Personalized for You
                        </div>
                        <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight">
                            Recommended Just for You
                        </h2>
                        <p class="text-gray-500 text-lg max-w-2xl mx-auto font-medium leading-relaxed">
                            Based on your reading preferences, purchase history, and favorite genres, here are books we think you'll love.
                        </p>
                    </div>

                    <!-- Recommendations Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="recommendations-grid">
                        <!-- Loading state -->
                        <div class="col-span-full text-center py-12">
                            <div class="inline-flex items-center px-6 py-3 bg-white rounded-full shadow-md border border-gray-100">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="font-medium text-gray-600">Loading personalized recommendations...</span>
                            </div>
                        </div>
                    </div>

                    <!-- View More Button -->
                    <div class="text-center mt-16">
                        <a href="{{ route('books.index') }}" class="group relative inline-flex items-center justify-center px-8 py-4 bg-gray-900 text-white font-bold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 hover:bg-black overflow-hidden">
                            <span class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <span class="relative flex items-center">
                                View All Books
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        @endauth

        <!-- Genre Gallery with Filters (White Theme) -->
        <div class="py-24 bg-white relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-gray-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-gray-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>

            <div class="container mx-auto px-6 relative z-10">
                <div class="text-center mb-12" data-aos="fade-up">
                    <div class="inline-flex items-center px-3 py-1 bg-white border border-gray-200 rounded-full text-xs font-semibold uppercase tracking-wider mb-6 text-gray-600 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 mr-2 animate-pulse"></span>
                        Browse by Genre
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900 tracking-tight font-serif">
                        Explore Visual Picks
                    </h2>
                    <p class="text-xl text-gray-500 max-w-2xl mx-auto font-light">
                        Curated collections to match your every mood
                    </p>
                </div>

                <!-- Filters -->
                <div class="flex items-center justify-center py-8 flex-wrap gap-4" id="genreFilters">
                    <button type="button"
                        data-filter="all"
                        class="genre-filter-btn border transition-all duration-300 rounded-full text-sm md:text-base font-bold px-6 py-2.5 text-center shadow-sm hover:shadow-md focus:outline-none transform hover:-translate-y-0.5 active-filter bg-gray-900 text-white border-gray-900">
                        All Genres
                    </button>
                    @foreach($genres as $genre)
                        <button type="button"
                            data-filter="{{ $genre->id }}"
                            class="genre-filter-btn border border-gray-200 bg-white text-gray-600 hover:text-gray-900 hover:border-gray-300 transition-all duration-300 rounded-full text-sm md:text-base font-bold px-6 py-2.5 text-center shadow-sm hover:shadow-md focus:outline-none transform hover:-translate-y-0.5">
                            {{ $genre->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Gallery Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="genreGallery">
                    @if($newArrivals->count() > 0)
                        @foreach($newArrivals as $book)
                            <div class="gallery-item" data-genre-id="{{ $book->genre?->id ?? '' }}" data-aos="fade-up">
                                <x-book-card :book="$book" />
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
                        // Active styles - Clean White Theme
                        filterButtons.forEach(b => {
                            b.classList.remove('active-filter', 'bg-gray-900', 'text-white', 'border-gray-900');
                            b.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
                        });
                        
                        // Set Active State
                        btn.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
                        btn.classList.add('active-filter', 'bg-gray-900', 'text-white', 'border-gray-900');

                        applyFilter(btn.dataset.filter);
                    });
                });

                // Initialize
                applyFilter('all');
            });
        </script>

        <!-- Current Promotions Hub - Component -->
        <x-promotions-hub 
            :active-flash-sale="$activeFlashSale ?? null" 
            :active-book-discounts="$activeBookDiscounts ?? null" 
            :active-coupons="$activeCoupons ?? null" 
        />



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carousel = document.getElementById('bookCarousel');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const dotsContainer = document.getElementById('carouselDots');
                const currentSlideElement = document.getElementById('currentSlide');
                const totalSlidesElement = document.getElementById('totalSlides');
                const progressBar = document.getElementById('progressBar');

                // Exit early if essential elements don't exist
                if (!carousel || !prevBtn || !nextBtn || !dotsContainer) {
                    return;
                }

                const totalBooks = {{ $newArrivals->count() }};
                const booksPerPage = 5; // Show 5 books per page
                const totalPages = Math.ceil(totalBooks / booksPerPage);
                let currentPage = 0;

                // Update total slides display
                if (totalSlidesElement) totalSlidesElement.textContent = totalPages;

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
                    if (currentSlideElement) currentSlideElement.textContent = currentPage + 1;
                    const progressPercentage = ((currentPage + 1) / totalPages) * 100;
                    if (progressBar) progressBar.style.width = `${progressPercentage}%`;

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

        <script>
            // Copy coupon code helper for promotions section
            document.addEventListener('DOMContentLoaded', function () {
                const buttons = document.querySelectorAll('.copy-coupon-btn');
                buttons.forEach((btn) => {
                    btn.addEventListener('click', async function () {
                        const code = this.dataset.couponCode || this.querySelector('.coupon-code-text')?.textContent || '';
                        if (!code) return;

                        try {
                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                await navigator.clipboard.writeText(code);
                            } else {
                                const tempInput = document.createElement('input');
                                tempInput.value = code;
                                document.body.appendChild(tempInput);
                                tempInput.select();
                                document.execCommand('copy');
                                document.body.removeChild(tempInput);
                            }

                            const statusEl = this.parentElement.querySelector('.copy-status');
                            if (statusEl) {
                                statusEl.classList.remove('hidden');
                                setTimeout(() => statusEl.classList.add('hidden'), 1500);
                            }
                        } catch (e) {
                            console.error('Failed to copy coupon code', e);
                        }
                    });
                });
            });
        </script>


    <!-- Enhanced Browse By Category (Auto-Scrolling Carousel) -->
    <section class="py-24 bg-white relative overflow-hidden" x-data="categoryCarousel()">
        {{-- Subtle ambient gradients --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-purple-50/60 rounded-full blur-[150px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-50/60 rounded-full blur-[150px] pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            {{-- Section Header --}}
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12" data-aos="fade-up">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-500 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-purple-600"></span>
                        </span>
                        <p class="text-xs font-bold tracking-[0.2em] uppercase text-purple-600">Explore Genres</p>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 font-serif tracking-tight leading-tight mb-4">
                        Find Your Next Adventure
                    </h2>
                    <p class="text-lg text-gray-500 font-light leading-relaxed">
                        Discover stories across every genre, from timeless classics to modern masterpieces.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Navigation Arrows --}}
                    <button @click="scrollLeft()" class="p-3 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-900 transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button @click="scrollRight()" class="p-3 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-900 transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <a href="{{ route('books.index') }}" class="hidden md:inline-flex items-center px-6 py-3 bg-gray-900 text-white text-sm font-bold rounded-full hover:bg-black transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02]">
                        <span>View All</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Category Carousel --}}
            <div class="relative" @mouseenter="pauseAutoScroll()" @mouseleave="resumeAutoScroll()">
                {{-- Gradient Fade Edges --}}
                <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

                {{-- Scrollable Container --}}
                <div x-ref="carousel" class="flex gap-5 overflow-x-auto scrollbar-hide scroll-smooth pb-4 -mx-2 px-2">
                    @foreach($genres as $genre)
                        @php
                            $gradients = [
                                'romance' => 'from-rose-500 to-pink-600',
                                'mystery' => 'from-slate-700 to-gray-900',
                                'fantasy' => 'from-violet-500 to-purple-700',
                                'fiction' => 'from-blue-500 to-indigo-600',
                                'science' => 'from-cyan-500 to-teal-600',
                                'thriller' => 'from-red-600 to-rose-700',
                                'biography' => 'from-amber-500 to-orange-600',
                                'history' => 'from-emerald-500 to-green-700'
                            ];
                            $icons = [
                                'romance' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                                'mystery' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                                'fantasy' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
                                'fiction' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                                'science' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                                'thriller' => 'M13 10V3L4 14h7v7l9-11h-7z',
                                'biography' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                'history' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                            ];
                            $genreLower = strtolower($genre->name);
                            $gradient = $gradients[$genreLower] ?? 'from-gray-700 to-gray-900';
                            $iconPath = $icons[$genreLower] ?? $icons['fiction'];
                        @endphp
                        <a href="{{ route('books.index', ['genre' => $genre->id]) }}" 
                           class="group relative flex-shrink-0 w-[220px] md:w-[260px] bg-white rounded-[2rem] p-6 md:p-8 transition-all duration-500 hover:-translate-y-2 border border-gray-100 hover:border-gray-200 overflow-hidden shadow-sm hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,0.15)]">
                            
                            {{-- Gradient Background on Hover --}}
                            <div class="absolute inset-0 bg-gradient-to-br {{ $gradient }} opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            {{-- Glass Overlay on Hover --}}
                            <div class="absolute inset-0 bg-white/10 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                            <div class="relative z-10 flex flex-col items-center text-center">
                                {{-- Category Icon --}}
                                <div class="inline-flex items-center justify-center h-16 w-16 md:h-20 md:w-20 rounded-2xl bg-gray-50 group-hover:bg-white/20 transition-all duration-500 mb-5 shadow-inner group-hover:shadow-lg group-hover:scale-110">
                                    <svg class="h-7 w-7 md:h-8 md:w-8 text-gray-400 group-hover:text-white transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $iconPath }}"/>
                                    </svg>
                                </div>
                                
                                {{-- Category Info --}}
                                <h3 class="text-base md:text-lg font-bold mb-2 text-gray-900 group-hover:text-white transition-colors duration-300">{{ $genre->name }}</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 group-hover:bg-white/20 group-hover:text-white/90 transition-all duration-300">
                                    {{ $genre->books_count }} books
                                </span>
                            </div>
                            
                            {{-- Arrow indicator on hover --}}
                            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            
            {{-- Mobile View All Button --}}
            <div class="text-center mt-10 md:hidden" data-aos="fade-up">
                <a href="{{ route('books.index') }}" class="inline-flex items-center px-8 py-4 bg-gray-900 text-white font-bold rounded-full hover:bg-black transition-all duration-300 shadow-lg">
                    <span>View All Categories</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Carousel Script --}}
        <script>
            function categoryCarousel() {
                return {
                    autoScrollInterval: null,
                    scrollSpeed: 1,
                    isPaused: false,
                    scrollDirection: 1, // 1 = right, -1 = left
                    
                    init() {
                        this.$nextTick(() => {
                            this.startAutoScroll();
                        });
                    },
                    
                    startAutoScroll() {
                        if (this.autoScrollInterval) return;
                        
                        this.autoScrollInterval = setInterval(() => {
                            if (!this.isPaused) {
                                const carousel = this.$refs.carousel;
                                if (carousel) {
                                    const maxScroll = carousel.scrollWidth - carousel.clientWidth;
                                    
                                    // Only scroll if there's content to scroll
                                    if (maxScroll > 0) {
                                        carousel.scrollLeft += this.scrollSpeed * this.scrollDirection;
                                        
                                        // Bounce back when reaching the end
                                        if (carousel.scrollLeft >= maxScroll - 5) {
                                            this.scrollDirection = -1;
                                        } else if (carousel.scrollLeft <= 5) {
                                            this.scrollDirection = 1;
                                        }
                                    }
                                }
                            }
                        }, 30);
                    },
                    
                    pauseAutoScroll() {
                        this.isPaused = true;
                    },
                    
                    resumeAutoScroll() {
                        this.isPaused = false;
                    },
                    
                    scrollLeft() {
                        const carousel = this.$refs.carousel;
                        if (carousel) {
                            const maxScroll = carousel.scrollWidth - carousel.clientWidth;
                            if (carousel.scrollLeft <= 10 && maxScroll > 0) {
                                carousel.scrollTo({ left: maxScroll, behavior: 'smooth' });
                            } else {
                                carousel.scrollBy({ left: -300, behavior: 'smooth' });
                            }
                        }
                    },
                    
                    scrollRight() {
                        const carousel = this.$refs.carousel;
                        if (carousel) {
                            const maxScroll = carousel.scrollWidth - carousel.clientWidth;
                            if (carousel.scrollLeft >= maxScroll - 10 && maxScroll > 0) {
                                carousel.scrollTo({ left: 0, behavior: 'smooth' });
                            } else {
                                carousel.scrollBy({ left: 300, behavior: 'smooth' });
                            }
                        }
                    }
                }
            }
        </script>

        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    </section>

        <!-- Customer Testimonials -->
        <div class="py-24 bg-gradient-to-br from-primary-50 via-white to-primary-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <div class="inline-flex items-center px-4 py-1.5 bg-white border border-orange-200 rounded-full text-xs font-semibold tracking-wide uppercase text-orange-700 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Customer Love
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-gray-900 via-orange-800 to-yellow-800 bg-clip-text text-transparent">
                        What Our Readers Say
                    </h2>
                    <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                        Real stories from book lovers who discovered their next favorite read on Bookty.
                    </p>
                </div>

                @if($testimonials->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @php
                            $gradients = [
                                'from-purple-400 to-pink-400',
                                'from-indigo-400 to-blue-400',
                                'from-emerald-400 to-teal-400',
                            ];
                            $delays = [200, 400, 600];
                        @endphp

                        @foreach($testimonials as $index => $testimonial)
                            <div
                                class="relative group bg-white/90 backdrop-blur-sm rounded-3xl p-8 shadow-[0_18px_45px_rgba(15,23,42,0.06)] hover:shadow-[0_24px_60px_rgba(15,23,42,0.14)] border border-gray-100/80 transform hover:-translate-y-2 transition-all duration-500"
                                data-aos="fade-up"
                                data-aos-delay="{{ $delays[$index % 3] }}"
                            >
                                <!-- Hover gradient overlay -->
                                <div class="pointer-events-none absolute inset-0 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-gradient-to-br from-primary-50 via-white to-emerald-50"></div>

                                <div class="relative z-10">
                                    <!-- Rating + quote badge -->
                                    <div class="flex items-center justify-between mb-5">
                                        <div class="flex items-center">
                                            <div class="flex items-center space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="ml-3 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-800 border border-yellow-100">
                                                {{ number_format($testimonial->rating ?? 5, 1) }}/5
                                            </span>
                                        </div>

                                        <div class="w-10 h-10 rounded-2xl bg-primary-600 text-white flex items-center justify-center shadow-lg">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7 4a3 3 0 00-3 3v2a4 4 0 004 4v1a1 1 0 001 1h1V9a5 5 0 00-5-5zm8 0a3 3 0 00-3 3v2a4 4 0 004 4v1a1 1 0 001 1h1V9a5 5 0 00-5-5z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <blockquote class="text-gray-800 text-base md:text-lg leading-relaxed mb-6">
                                        “{{ \Illuminate\Support\Str::limit($testimonial->comment, 200) }}”
                                    </blockquote>

                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br {{ $gradients[$index % 3] }} rounded-full flex items-center justify-center text-white font-bold text-lg mr-4 shadow-md">
                                            {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">
                                                {{ $testimonial->user->name }}
                                            </div>
                                            <div class="text-xs uppercase tracking-wide text-gray-500">
                                                Verified Customer
                                            </div>
                                            @if($testimonial->book)
                                                <div class="mt-2 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-50 text-primary-700 border border-primary-100">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                    <span>{{ \Illuminate\Support\Str::limit($testimonial->book->title, 32) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Fallback message when no testimonials -->
                    <div class="text-center py-16">
                        <div class="bg-white/90 backdrop-blur-sm rounded-3xl p-12 shadow-[0_18px_45px_rgba(15,23,42,0.06)] max-w-2xl mx-auto border border-dashed border-gray-200">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <h3 class="text-2xl font-semibold text-gray-900 mb-3">Be the First to Share Your Experience</h3>
                            <p class="text-gray-600 mb-4">
                                Your review helps other readers discover books they'll love and supports our community.
                            </p>
                            <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }))" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white text-sm font-semibold rounded-full hover:from-primary-700 hover:to-primary-800 transition-all duration-300 shadow-lg hover:shadow-primary-500/30">
                                <span class="mr-2">Sign in to leave a review</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Trust Indicators -->
                <div class="mt-20" data-aos="fade-up" data-aos-delay="800">
                    <div class="max-w-4xl mx-auto bg-white/80 backdrop-blur-sm rounded-3xl border border-gray-100 shadow-[0_20px_45px_rgba(15,23,42,0.04)] px-6 py-8 md:px-10">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                            <div class="text-left">
                                <p class="text-xs font-semibold tracking-[0.18em] text-primary-600 uppercase mb-1">
                                    Social Proof
                                </p>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    Readers trust Bookty with their next read
                                </h3>
                            </div>
                            <div class="inline-flex items-center px-3 py-1.5 rounded-full bg-primary-50 text-primary-700 text-xs font-medium border border-primary-100">
                                <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span>{{ $averageRating ? number_format($averageRating, 1) : '5.0' }}/5 average from real customers</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                            <!-- Happy Customers -->
                            <div class="group rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl px-4 py-5 flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary-50 text-primary-600 mb-3 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="text-xl md:text-2xl font-bold text-gray-900">
                                    @if($totalCustomers >= 1000)
                                        {{ number_format($totalCustomers / 1000, 1) }}K+
                                    @else
                                        {{ number_format($totalCustomers) }}+
                                    @endif
                                </div>
                                <div class="mt-1 text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                    Happy Customers
                                </div>
                            </div>

                            <!-- Books Sold -->
                            <div class="group rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl px-4 py-5 flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary-50 text-primary-600 mb-3 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13M5.5 5A3.5 3.5 0 002 8.5V21l3.5-1.75L9 21V8.5A3.5 3.5 0 005.5 5zM18.5 5A3.5 3.5 0 0015 8.5V21l3.5-1.75L22 21V8.5A3.5 3.5 0 0018.5 5z"/>
                                    </svg>
                                </div>
                                <div class="text-xl md:text-2xl font-bold text-gray-900">
                                    @if($totalBooksSold >= 1000)
                                        {{ number_format($totalBooksSold / 1000, 1) }}K+
                                    @else
                                        {{ number_format($totalBooksSold) }}+
                                    @endif
                                </div>
                                <div class="mt-1 text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                    Books Sold
                                </div>
                            </div>

                            <!-- Average Rating -->
                            <div class="group rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl px-4 py-5 flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-pink-50 text-pink-600 mb-3 group-hover:bg-pink-600 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                <div class="text-xl md:text-2xl font-bold text-gray-900">
                                    {{ $averageRating ? number_format($averageRating, 1) : '5.0' }}/5
                                </div>
                                <div class="mt-1 text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                    Average Rating
                                </div>
                            </div>

                            <!-- Satisfaction Rate -->
                            <div class="group rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl px-4 py-5 flex flex-col items-center justify-center transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-orange-50 text-orange-600 mb-3 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828A4 4 0 019.172 14.83M15 10a3 3 0 11-6 0 3 3 0 016 0zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="text-xl md:text-2xl font-bold text-gray-900">
                                    {{ $satisfactionRate }}%
                                </div>
                                <div class="mt-1 text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                    Satisfaction Rate
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced New Arrivals -->
        <div id="featured" class="py-20 bg-gradient-to-br from-primary-50 via-white to-primary-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-100 to-primary-50 rounded-full text-sm font-medium mb-6 text-primary-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Latest Additions
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-gray-900 via-primary-800 to-primary-900 bg-clip-text text-transparent">
                        New Arrivals
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Discover the latest additions to our collection - fresh stories and new adventures await
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                    @if($newArrivals->count() > 0)
                        @foreach($newArrivals->take(8) as $book)
                            <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <x-book-card :book="$book" />
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
                    <a href="{{ route('books.index') }}" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-full hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-xl hover:shadow-purple-500/25 transform hover:scale-105">
                        <span class="mr-2">Explore All Books</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                    </a>
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

    </div> <!-- /#home-content -->

    <!-- Skeleton Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var skeleton = document.getElementById('home-skeleton');
            var content = document.getElementById('home-content');

            if (!skeleton || !content) return;

            setTimeout(function () {
                skeleton.classList.add('hidden');
                content.classList.remove('hidden');
            }, 500);
        });
    </script>

    <!-- Track Book Interactions for Recommendations -->
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Track 'click' interaction when user clicks on hero carousel "View Details" link
            var heroDetailsLink = document.getElementById('hero-details-link');
            if (heroDetailsLink) {
                heroDetailsLink.addEventListener('click', function(e) {
                    var bookId = this.getAttribute('href').match(/\/books\/(\d+)/);
                    if (bookId && bookId[1]) {
                        // Track click interaction via AJAX
                        fetch('/api/track-interaction', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                book_id: parseInt(bookId[1]),
                                action: 'click'
                            }),
                            credentials: 'same-origin'
                        }).catch(function(err) {
                            console.log('Interaction tracking failed:', err);
                        });
                    }
                });
            }

            // Track 'click' interactions on book cards (homepage, search results, etc.)
            document.querySelectorAll('a[href*="/books/"]').forEach(function(link) {
                // Skip if it's the hero link (already tracked above)
                if (link.id === 'hero-details-link') return;
                
                link.addEventListener('click', function(e) {
                    var bookId = this.getAttribute('href').match(/\/books\/(\d+)/);
                    if (bookId && bookId[1]) {
                        // Only track if it's a book detail page link (not admin, not cart, etc.)
                        if (this.getAttribute('href').includes('/books/') && 
                            !this.getAttribute('href').includes('/admin') &&
                            !this.getAttribute('href').includes('/cart')) {
                            fetch('/api/track-interaction', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    book_id: parseInt(bookId[1]),
                                    action: 'click'
                                }),
                                credentials: 'same-origin'
                            }).catch(function(err) {
                                console.log('Interaction tracking failed:', err);
                            });
                        }
                    }
                });
            });
        });
    </script>
    @endauth

@endsection


