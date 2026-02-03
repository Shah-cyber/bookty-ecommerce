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
        <div class="min-h-screen bg-[#FAF7F5]">
            <!-- Hero Skeleton -->
            <div class="relative min-h-screen bg-[#FAF7F5]">
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
                                <div class="h-12 w-full sm:w-40 bg-[#9D84B7]/40 rounded-full"></div>
                                <div class="h-12 w-full sm:w-40 bg-white/80 rounded-full"></div>
                            </div>
                            <div class="mt-10 pt-6 border-t border-[#9D84B7]/20 flex flex-wrap gap-8">
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
                                    <div class="h-80 sm:h-96 bg-gradient-to-br from-[#E6D5E9] to-[#C7B3D9] rounded-3xl shadow-2xl"></div>
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
            <div class="py-16 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900">
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

    <div class="min-h-screen bg-gray-50/50">
        <!-- Hero Section - Liquid Glass Theme -->
        <div class="relative overflow-x-hidden bg-gray-50/50 min-h-screen">
            <!-- Liquid Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <!-- Layer 1: Large floating blobs -->
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-gray-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000"></div>
                <div class="absolute top-24 left-16 w-80 h-80 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>

                <!-- Layer 2: Medium accent blobs -->
                <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-slate-100 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob"></div>
                <div class="absolute bottom-1/4 right-1/3 w-72 h-72 bg-gray-200 rounded-full mix-blend-multiply filter blur-2xl opacity-40 animate-blob animation-delay-2000"></div>

                <!-- Layer 3: Small sparkle elements -->
                <div class="absolute top-20 left-1/3 w-32 h-32 bg-white/50 rounded-full filter blur-xl opacity-60 animate-pulse"></div>
                <div class="absolute bottom-32 right-1/4 w-24 h-24 bg-white/50 rounded-full filter blur-xl opacity-60 animate-pulse animation-delay-2000"></div>
            </div>
            
            <!-- Mesh Texture -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMCwgMCwgMCwgMC4wMykiLz48L3N2Zz4=')] opacity-30"></div>

            <div class="container mx-auto px-4 sm:px-6 py-12 sm:py-16 lg:py-20 relative z-10 overflow-visible">
                <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-12 lg:gap-20 xl:gap-28 min-h-[70vh] lg:min-h-[80vh] overflow-visible">
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
                        <div class="flex-1 lg:max-w-[50%] xl:max-w-[48%] text-gray-900 order-2 lg:order-1 flex flex-col items-center lg:items-start text-center lg:text-left flex-shrink-0" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="100">
                            <!-- Glass Pill Badge -->
                            <div class="mb-8" data-aos="fade-down" data-aos-delay="200">
                                <span class="inline-flex items-center py-2 px-6 rounded-full bg-white/80 border border-white/60 backdrop-blur-md text-purple-900 text-xs font-bold tracking-widest uppercase shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <span class="relative flex w-2.5 h-2.5 mr-2.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-purple-500"></span>
                                    </span>
                                    <span id="hero-genre" class="text-fade">
                                        @if(Auth::check() && $recommendations && $recommendations->count() > 0)
                                            ✨ Recommended for You
                                        @else
                                            {{ optional($firstHero)->genre?->name ?? '⭐ Featured' }}
                                        @endif
                                    </span>
                                </span>
                            </div>
                            
                            <!-- Title -->
                            <h1 id="hero-title" class="text-fade text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-bold leading-tight mb-6 font-serif text-gray-900 tracking-tight break-words" style="line-height: 1.1;" data-aos="fade-up" data-aos-delay="300">
                                {{ $firstHero?->title }}
                            </h1>
                            
                            <!-- Synopsis -->
                            <p id="hero-synopsis" class="text-fade text-base md:text-lg mb-10 w-full text-gray-500 leading-relaxed font-light" data-aos="fade-up" data-aos-delay="400">
                                {{ \Illuminate\Support\Str::limit($firstHero?->synopsis ?? 'Discover your next favorite story.', 180) }}
                            </p>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row w-full items-stretch sm:items-center justify-center lg:justify-start gap-4 sm:gap-5" data-aos="fade-up" data-aos-delay="500">
                                <a id="hero-details-link" href="{{ $firstHero ? route('books.show', $firstHero) : '#' }}" class="group inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                                    <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    VIEW DETAILS
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                                @if($firstHero)
                                    <button onclick="quickAddToCart({{ $firstHero?->id }})" id="hero-quick-add" class="quick-add-btn group inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 bg-white/60 backdrop-blur-md border border-white/80 text-gray-700 font-bold rounded-xl shadow-lg hover:bg-white hover:border-gray-200 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span class="btn-text flex items-center">
                                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Quick Add to Cart
                                        </span>
                                        <span class="loading-spinner hidden">
                                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-gray-700 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Adding...
                                        </span>
                                    </button>
                                @endif
                            </div>

                            <!-- Glass Stats Pills -->
                            <div class="w-full mt-16" data-aos="fade-up" data-aos-delay="600">
                                <div class="flex items-center justify-center lg:justify-start gap-4 sm:gap-6 flex-wrap">
                                    <div class="px-6 py-4 bg-white/60 backdrop-blur-md rounded-[2rem] border border-white/60 shadow-lg group hover:bg-white/80 transition-all duration-300">
                                        <div class="text-2xl font-bold text-gray-900 tracking-tight text-center">10K+</div>
                                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Readers</div>
                                    </div>
                                    <div class="px-6 py-4 bg-white/60 backdrop-blur-md rounded-[2rem] border border-white/60 shadow-lg group hover:bg-white/80 transition-all duration-300">
                                        <div class="text-2xl font-bold text-gray-900 tracking-tight text-center">5K+</div>
                                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Books</div>
                                    </div>
                                    <div class="px-6 py-4 bg-white/60 backdrop-blur-md rounded-[2rem] border border-white/60 shadow-lg group hover:bg-white/80 transition-all duration-300">
                                        <div class="text-2xl font-bold text-gray-900 tracking-tight text-center flex items-center justify-center gap-1">
                                            4.8 <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </div>
                                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Rating</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Content - Enhanced 3D Portrait cover slider -->
                        <div class="flex-1 lg:max-w-[45%] xl:max-w-[42%] w-full order-1 lg:order-2 perspective-container overflow-visible flex-shrink-0" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                            <div class="relative w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-md xl:max-w-lg mx-auto h-[450px] sm:h-[550px] lg:h-[600px] overflow-visible">
                                <!-- Ambient glow effect behind carousel -->
                                <div class="absolute inset-0 bg-gray-300/30 rounded-3xl blur-3xl scale-110 opacity-50"></div>

                                <!-- Navigation Arrows - Glass Circle Style -->
                                <!-- Navigation Arrows moved to bottom with dots -->

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
                                            class="hero-item absolute inset-0 transition-all duration-700 ease-out rounded-[2.5rem] shadow-2xl ring-1 ring-white/10 overflow-hidden bg-white/60 backdrop-blur-sm cursor-pointer group opacity-0 border-[6px] border-white/30"
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
                                                <div class="w-full h-full bg-gradient-to-br from-purple-50 to-indigo-50 flex items-center justify-center">
                                                    <svg class="w-20 h-20 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif

                                            <!-- Condition Badge -->
                                            <div class="absolute top-4 left-4 z-10">
                                                @if(($book->condition ?? 'new') === 'preloved')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-amber-500/90 backdrop-blur-sm text-white shadow-lg">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                        Preloved
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-500/90 backdrop-blur-sm text-white shadow-lg">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        New
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Hover overlay with book info -->
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                                    <h3 class="text-white font-bold text-xl mb-2 line-clamp-2">{{ $book->title }}</h3>
                                                    <p class="text-white/80 text-sm line-clamp-1">{{ $book->author }}</p>
                                                    <div class="mt-3 flex items-center gap-2 flex-wrap">
                                                        <!-- Condition Badge in Overlay -->
                                                        @if(($book->condition ?? 'new') === 'preloved')
                                                            <span class="px-3 py-1 bg-amber-500/80 backdrop-blur-md rounded-full text-white text-xs font-medium border border-amber-300/50">
                                                                Preloved
                                                            </span>
                                                        @else
                                                            <span class="px-3 py-1 bg-green-500/80 backdrop-blur-md rounded-full text-white text-xs font-medium border border-green-300/50">
                                                                New
                                                            </span>
                                                        @endif
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
                                <!-- Modern Navigation Controls (Dots + Arrows) -->
                                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2 flex items-center justify-center gap-6 z-50 w-full px-4" id="carousel-controls">
                                    <!-- Prev Button -->
                                    <button id="carousel-prev" class="w-10 h-10 rounded-full bg-white/60 hover:bg-gray-900 backdrop-blur-md border border-white/60 flex items-center justify-center text-gray-600 hover:text-white shadow-md hover:shadow-lg transition-all duration-300 group">
                                        <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>

                                    <!-- Dots -->
                                    <div class="flex gap-2 items-center" id="carousel-dots">
                                        @foreach($displayHeroBooks as $i => $book)
                                            <button 
                                                class="carousel-dot h-2 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-gray-900 w-8' : 'bg-gray-400/50 hover:bg-gray-600 w-2' }}"
                                                data-index="{{ $i }}"
                                            ></button>
                                        @endforeach
                                    </div>

                                    <!-- Next Button -->
                                    <button id="carousel-next" class="w-10 h-10 rounded-full bg-white/60 hover:bg-gray-900 backdrop-blur-md border border-white/60 flex items-center justify-center text-gray-600 hover:text-white shadow-md hover:shadow-lg transition-all duration-300 group">
                                        <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty state when no books are available -->
                        <div class="flex-1 lg:max-w-[50%] xl:max-w-[50%] text-gray-900 order-2 lg:order-1 flex flex-col items-center lg:items-start text-center lg:text-left flex-shrink-0" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="100">
                            <div class="mb-8" data-aos="fade-down" data-aos-delay="200">
                                <span class="inline-flex items-center py-1.5 px-4 rounded-full bg-white/50 border border-white/50 backdrop-blur-sm text-gray-500 text-xs font-bold tracking-widest uppercase shadow-sm">
                                    <span class="relative flex w-2.5 h-2.5 mr-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gray-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-gray-500"></span>
                                    </span>
                                    ⭐ Welcome to Bookty
                                </span>
                            </div>
                            <h1 class="text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-bold leading-tight mb-6 font-serif text-gray-900 tracking-tight break-words" style="line-height: 1.1;" data-aos="fade-up" data-aos-delay="300">
                                Discover Amazing Books
                            </h1>
                            <p class="text-base md:text-lg mb-10 w-full text-gray-500 leading-relaxed font-light" data-aos="fade-up" data-aos-delay="400">
                                Your journey into the world of literature starts here. Browse our collection and find your next favorite read.
                            </p>
                            <div class="flex flex-col sm:flex-row w-full items-stretch sm:items-center justify-center lg:justify-start gap-4 sm:gap-5" data-aos="fade-up" data-aos-delay="500">
                                <a href="{{ route('books.index') }}" class="group inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                                    <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    BROWSE BOOKS
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            }, 500);
                        };

                        const updateDots = (activeIndex) => {
                            // Highlight only the current centered book
                            dots.forEach((dot, i) => {
                                if (i === activeIndex) {
                                    dot.classList.add('bg-gray-900', 'w-8');
                                    dot.classList.remove('bg-gray-400/40', 'w-2.5');
                                } else {
                                    dot.classList.remove('bg-gray-900', 'w-8');
                                    dot.classList.add('bg-gray-400/40', 'w-2.5');
                                }
                            });
                        };

                        const updateCarousel = (centerIndex, skipTransition = false) => {
                            if (isTransitioning && !skipTransition) return;
                            if (!skipTransition) isTransitioning = true;

                            currentIndex = centerIndex;
                            const total = slides.length;
                            
                            slides.forEach((slide, i) => {
                                slide.classList.remove('z-30', 'z-20', 'z-10', 'opacity-100', 'opacity-60', 'opacity-0', 'pointer-events-auto', 'pointer-events-none');

                                // Calculate position relative to center
                                let offset = i - centerIndex;
                                
                                if (offset === 0) { 
                                    // CENTER - Main book in focus
                                    slide.classList.add('z-30', 'opacity-100', 'pointer-events-auto');
                                    slide.style.transform = 'translateX(0) translateZ(0) scale(1.0) rotateY(0deg)';
                                    slide.style.filter = 'brightness(1)';
                                } else if (offset === -1 || (centerIndex === 0 && i === total - 1)) { 
                                    // LEFT - Previous book
                                    slide.classList.add('z-20', 'opacity-60', 'pointer-events-auto');
                                    slide.style.transform = 'translateX(-60%) translateZ(-150px) scale(0.8) rotateY(35deg)';
                                    slide.style.filter = 'brightness(0.7)';
                                } else if (offset === 1 || (centerIndex === total - 1 && i === 0)) { 
                                    // RIGHT - Next book
                                    slide.classList.add('z-20', 'opacity-60', 'pointer-events-auto');
                                    slide.style.transform = 'translateX(60%) translateZ(-150px) scale(0.8) rotateY(-35deg)';
                                    slide.style.filter = 'brightness(0.7)';
                                } else {
                                    // HIDDEN - All other books
                                    slide.classList.add('z-10', 'opacity-0', 'pointer-events-none');
                                    slide.style.transform = 'translateX(0) translateZ(-500px) scale(0.5)';
                                    slide.style.filter = 'brightness(0.3)';
                                }
                            });

                            // Update text content with the center book
                            updateTextContent(slides[centerIndex]);
                            updateDots(centerIndex);

                            if (!skipTransition) {
                                setTimeout(() => {
                                    isTransitioning = false;
                                }, 800);
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

                        // Arrow navigation
                        const prevBtn = document.getElementById('carousel-prev');
                        const nextBtn = document.getElementById('carousel-next');
                        
                        if (prevBtn) {
                            prevBtn.addEventListener('click', () => {
                                prev();
                                restart();
                            });
                        }
                        
                        if (nextBtn) {
                            nextBtn.addEventListener('click', () => {
                                next();
                                restart();
                            });
                        }

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

            <!-- Glass Scroll Indicator -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center justify-center gap-3 scroll-down-indicator">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Scroll Down</span>
                <div class="flex flex-col items-center">
                    <div class="w-6 h-10 rounded-full border-2 border-gray-300 flex items-start justify-center pt-2">
                        <div class="w-1.5 h-3 bg-gray-400 rounded-full animate-bounce"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Genre Filter Script moved to after the section -->


        <!-- For You Section (Personalized Recommendations) - Liquid Glass Theme -->
        @auth
            <div class="relative py-24 overflow-hidden bg-gray-50/50">
                <!-- Liquid Background Elements -->
                <div class="absolute inset-0 opacity-100 overflow-hidden pointer-events-none">
                    <div class="absolute top-10 -right-20 w-80 h-80 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
                    <div class="absolute -bottom-20 left-1/4 w-96 h-96 bg-gray-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                    <div class="absolute top-1/2 left-10 w-64 h-64 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-60 animate-blob animation-delay-4000"></div>
                </div>
                
                <!-- Mesh Texture -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMCwgMCwgMCwgMC4wMykiLz48L3N2Zz4=')] opacity-30"></div>

                <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Section Header -->
                    <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                        <span class="inline-flex items-center py-1.5 px-4 rounded-full bg-white/50 border border-white/50 backdrop-blur-sm text-gray-500 text-xs font-bold tracking-widest uppercase mb-4 shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                            Personalized For You
                        </span>
                        <h2 class="text-4xl md:text-5xl font-bold font-serif mb-6 text-gray-900 tracking-tight">
                            Curated <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-700 to-gray-400">Just for You</span>
                        </h2>
                        <p class="text-lg text-gray-500 leading-relaxed font-light">
                            Based on your reading preferences and purchase history. Handpicked titles we think you'll love.
                        </p>
                    </div>

                    <!-- Recommendations Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8" id="recommendations-grid">
                        <!-- Loading state - Glass Style -->
                        <div class="col-span-full text-center py-16">
                            <div class="inline-flex items-center px-6 py-4 bg-white/60 backdrop-blur-md rounded-2xl shadow-lg border border-white/80">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-gray-600 font-medium">Loading personalized recommendations...</span>
                            </div>
                        </div>
                    </div>

                    <!-- View More Button - Glass Style -->
                    <div class="text-center mt-16" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('books.index') }}" class="group inline-flex items-center px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                            <span>View All Books</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endauth

        <!-- Genre Gallery with Filters - Liquid Glass Theme -->
        <div class="relative py-24 overflow-hidden bg-gray-50/50">
            <!-- Liquid Background Elements -->
            <div class="absolute inset-0 opacity-100 overflow-hidden pointer-events-none">
                <div class="absolute top-20 right-1/4 w-72 h-72 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
                <div class="absolute bottom-10 left-1/3 w-80 h-80 bg-gray-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                <div class="absolute top-1/3 -left-10 w-64 h-64 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-60 animate-blob animation-delay-4000"></div>
            </div>
            
            <!-- Mesh Texture -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMCwgMCwgMCwgMC4wMykiLz48L3N2Zz4=')] opacity-30"></div>

            <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-12" data-aos="fade-up">
                    <span class="inline-flex items-center py-1.5 px-4 rounded-full bg-white/50 border border-white/50 backdrop-blur-sm text-gray-500 text-xs font-bold tracking-widest uppercase mb-4 shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Browse by Genre
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold font-serif mb-6 text-gray-900 tracking-tight">
                        Explore <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-700 to-gray-400">Visual Picks</span>
                    </h2>
                    <p class="text-lg text-gray-500 leading-relaxed font-light">
                        Filter by your favorite genres. Find your next great read.
                    </p>
                </div>

                <!-- Glass Filters -->
                <div class="flex items-center justify-center py-6 flex-wrap gap-3 mb-12" id="genreFilters" data-aos="fade-up" data-aos-delay="100">
                    <button type="button"
                        data-filter="all"
                        class="genre-filter-btn px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 backdrop-blur-md border shadow-sm
                               bg-gray-900 text-white border-gray-900 active-filter">
                        All Genres
                    </button>
                    @foreach($genres as $genre)
                        <button type="button"
                            data-filter="{{ $genre->id }}"
                            class="genre-filter-btn px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 backdrop-blur-md border shadow-sm
                                   bg-white/60 text-gray-700 border-white/80 hover:bg-white hover:border-gray-200 hover:shadow-md">
                            {{ $genre->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Gallery Grid with New Book Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8" id="genreGallery">
                    @if($newArrivals->count() > 0)
                        @foreach($newArrivals as $book)
                            <div class="gallery-item" data-genre-id="{{ $book->genre?->id ?? '' }}" data-aos="fade-up">
                                <x-book-card :book="$book" :showAddToCart="false" />
                            </div>
                        @endforeach
                    @else
                        <!-- Empty state for no books -->
                        <div class="col-span-full text-center py-16">
                            <div class="inline-flex items-center px-6 py-4 bg-white/60 backdrop-blur-md rounded-2xl shadow-lg border border-white/80">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span class="text-gray-600 font-medium">No books available yet. Check back soon!</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Empty state for filtered results -->
                <div id="galleryEmptyState" class="hidden text-center py-16">
                    <div class="inline-flex items-center px-6 py-4 bg-white/60 backdrop-blur-md rounded-2xl shadow-lg border border-white/80">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-600 font-medium">No books found for this genre.</span>
                    </div>
                </div>
                
                <!-- View All Button -->
                <div class="text-center mt-16" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('books.index') }}" class="group inline-flex items-center px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                        <span>Browse All Books</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Genre Filter Styles -->
        <style>
            .genre-filter-btn.active-filter {
                background-color: #111827 !important;
                color: white !important;
                border-color: #111827 !important;
            }
            .genre-filter-btn:not(.active-filter) {
                background-color: rgba(255, 255, 255, 0.6);
                color: #374151;
                border-color: rgba(255, 255, 255, 0.8);
            }
            .genre-filter-btn:not(.active-filter):hover {
                background-color: white;
                border-color: #e5e7eb;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterButtons = document.querySelectorAll('#genreFilters .genre-filter-btn');
                const items = document.querySelectorAll('#genreGallery .gallery-item');
                const emptyState = document.getElementById('galleryEmptyState');

                function applyFilter(filter) {
                    let visibleCount = 0;
                    items.forEach((el) => {
                        const match = filter === 'all' || String(el.dataset.genreId) === String(filter);
                        el.style.display = match ? '' : 'none';
                        if (match) visibleCount++;
                    });
                    if (emptyState) {
                        emptyState.classList.toggle('hidden', visibleCount > 0);
                    }
                }

                filterButtons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        // Remove active from all
                        filterButtons.forEach(b => b.classList.remove('active-filter'));
                        // Add active to clicked
                        btn.classList.add('active-filter');
                        // Apply filter
                        applyFilter(btn.dataset.filter);
                    });
                });

                // Initialize
                applyFilter('all');
            });
        </script>

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

        <!-- Dynamic Promotional Banners - Liquid Glass Design -->
        @if(isset($promotions) && $promotions->count() > 0)
        <div class="relative py-24 overflow-hidden bg-gray-50/50">
            <!-- Liquid Background Elements (Monochromatic) -->
            <div class="absolute inset-0 opacity-100 overflow-hidden pointer-events-none">
                <!-- Blob 1 -->
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-gray-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
                <!-- Blob 2 -->
                <div class="absolute top-0 -right-4 w-72 h-72 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000"></div>
                <!-- Blob 3 -->
                <div class="absolute -bottom-8 left-20 w-80 h-80 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-80 animate-blob animation-delay-4000"></div>
            </div>
            
            <!-- Mesh/Grid Texture -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMCwgMCwgMCwgMC4wMykiLz48L3N2Zz4=')] opacity-30"></div>

            <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-white/50 border border-white/50 backdrop-blur-sm text-gray-500 text-xs font-bold tracking-widest uppercase mb-4 shadow-sm">
                        Exclusive Selection
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold font-serif mb-6 text-gray-900 tracking-tight">
                        Curated Deals & <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-700 to-gray-400">Glass Collections</span>
                    </h2>
                    <p class="text-lg text-gray-500 leading-relaxed font-light">
                        Discover our hand-picked selection of literary treasures. Minimalist design meeting maximum value.
                    </p>
                </div>

                <!-- Smart Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 {{ $promotions->count() === 1 ? 'lg:grid-cols-1 max-w-lg mx-auto' : ($promotions->count() === 2 ? 'lg:grid-cols-2 max-w-4xl mx-auto' : ($promotions->count() === 3 ? 'lg:grid-cols-3' : 'lg:grid-cols-3 xl:grid-cols-4')) }} gap-6 lg:gap-8">
                    @foreach($promotions as $index => $promo)
                        @php
                            // Calculate time remaining
                            $now = now();
                            $endsAt = $promo['ends_at'];
                            $hasExpiry = $endsAt !== null;
                            $daysLeft = $hasExpiry ? max(0, $now->diff($endsAt)->days) : 0;
                            $hoursLeft = $hasExpiry ? $now->diff($endsAt)->h : 0;
                            $minsLeft = $hasExpiry ? $now->diff($endsAt)->i : 0;
                            
                            // Calculate usage percentage for coupons
                            $usagePercent = ($promo['max_uses'] ?? 0) > 0 
                                ? min(100, round(($promo['current_uses'] ?? 0) / $promo['max_uses'] * 100)) 
                                : 0;
                        @endphp
                        
                        <!-- Glass Card -->
                        <div class="group relative flex flex-col h-full" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 100) }}">
                            <div class="glass-card relative flex flex-col flex-1 h-full rounded-[2rem] p-6 lg:p-7 overflow-hidden transition-all duration-500">
                                
                                <!-- Shine Effect on Hover -->
                                <div class="absolute -top-[100%] -left-[100%] w-[200%] h-[200%] bg-gradient-to-br from-white/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none rotate-45 transform translate-y-10"></div>

                                <!-- Header: Badge & Status -->
                                <div class="flex justify-between items-start mb-5 relative z-10">
                                    @if($promo['type'] === 'flash_sale')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-900 text-white text-[10px] font-bold tracking-wider uppercase shadow-md">
                                            <svg class="w-3 h-3 mr-1.5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                                            FLASH SALE
                                        </span>
                                        <span class="animate-pulse flex h-2.5 w-2.5 rounded-full bg-gray-900 box-content border-4 border-gray-200" title="Ending Soon"></span>
                                    @elseif($promo['type'] === 'coupon')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-gray-200 text-gray-600 text-[10px] font-bold tracking-wider uppercase shadow-sm">
                                            <svg class="w-3 h-3 mr-1.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm4.707 3.707a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L8.414 9H10a3 3 0 013 3v1a1 1 0 102 0v-1a5 5 0 00-5-5H8.414l1.293-1.293z" clip-rule="evenodd"></path></svg>
                                            COUPON
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-gray-200 text-gray-600 text-[10px] font-bold tracking-wider uppercase shadow-sm">
                                            <svg class="w-3 h-3 mr-1.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
                                            BOOK DEAL
                                        </span>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="relative z-10 flex-1">
                                    <h3 class="text-2xl font-bold font-serif leading-tight mb-2 text-gray-900 group-hover:text-black transition-colors">
                                        {{ Str::limit($promo['subtitle'] ?: $promo['title'], 30) }}
                                    </h3>
                                    <p class="text-sm font-medium text-gray-600 mb-4 line-clamp-2">
                                        @if($promo['description'])
                                            {{ Str::limit($promo['description'], 60) }}
                                        @else
                                            {{ $promo['title'] }}
                                        @endif
                                    </p>
                                    
                                    <!-- Info Tags -->
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @if(isset($promo['books_count']) && $promo['books_count'] > 0)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] bg-gray-100 border border-gray-200 text-gray-600 font-semibold">{{ $promo['books_count'] }} Books</span>
                                        @endif
                                        @if($promo['free_shipping'] ?? false)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] bg-gray-100 border border-gray-200 text-gray-600 font-semibold">Free Ship</span>
                                        @endif
                                        @if($promo['min_purchase'] > 0)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] bg-gray-100 border border-gray-200 text-gray-600 font-semibold">Min: RM {{ number_format($promo['min_purchase'], 0) }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Coupon Code Box (only for coupons) -->
                                @if($promo['code'])
                                    <div class="relative z-10 my-4 group/code">
                                        <div class="flex items-stretch rounded-xl overflow-hidden bg-white/60 border border-gray-200 shadow-inner">
                                            <div class="flex-1 px-3 py-3 border-r border-dashed border-gray-300 flex flex-col justify-center items-center">
                                                <span class="text-[9px] uppercase tracking-wider text-gray-400 mb-0.5">Code</span>
                                                <span class="font-mono text-lg font-bold tracking-widest text-gray-800">{{ $promo['code'] }}</span>
                                            </div>
                                            <button onclick="copyCode('{{ $promo['code'] }}')" class="px-4 hover:bg-gray-100 transition-colors flex items-center justify-center text-gray-500 hover:text-gray-900 cursor-pointer" title="Copy">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <!-- CTA Button -->
                                <div class="mt-auto relative z-10">
                                    @if($promo['type'] === 'flash_sale')
                                        <a href="{{ $promo['link'] }}" class="block w-full py-3.5 px-4 bg-gray-900 text-white text-center text-sm font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                                            Shop Collection
                                        </a>
                                    @else
                                        <a href="{{ $promo['link'] }}" class="block w-full py-3.5 px-4 bg-white border border-gray-200 text-gray-900 text-center text-sm font-bold rounded-xl shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-300">
                                            {{ Str::limit($promo['link_text'], 25) }}
                                        </a>
                                    @endif
                                    
                                    <!-- Timer & Progress Bar (Flash Sale style) -->
                                    @if($hasExpiry || ($promo['max_uses'] ?? 0) > 0)
                                        <div class="mt-5 pt-4 border-t border-gray-200/60">
                                            @if($hasExpiry)
                                                <div class="flex items-center justify-between text-xs mb-3 countdown-timer" data-ends-at="{{ $endsAt->toIso8601String() }}">
                                                    <span class="text-gray-500 font-medium">Ends in:</span>
                                                    <div class="flex gap-1 font-mono text-gray-800">
                                                        @if($daysLeft > 0)
                                                            <span class="bg-white/60 border border-gray-200 rounded px-1.5 min-w-[28px] text-center shadow-sm countdown-days-box">{{ $daysLeft }}d</span>
                                                        @endif
                                                        <span class="bg-white/60 border border-gray-200 rounded px-1.5 min-w-[28px] text-center shadow-sm countdown-hours">{{ str_pad($hoursLeft, 2, '0', STR_PAD_LEFT) }}h</span>
                                                        <span class="bg-white/60 border border-gray-200 rounded px-1.5 min-w-[28px] text-center shadow-sm countdown-mins">{{ str_pad($minsLeft, 2, '0', STR_PAD_LEFT) }}m</span>
                                                        <span class="bg-white/60 border border-gray-200 rounded px-1.5 min-w-[28px] text-center shadow-sm countdown-secs text-amber-600">00s</span>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if(($promo['max_uses'] ?? 0) > 0)
                                                <div class="relative pt-1">
                                                    <div class="flex mb-1 items-center justify-between">
                                                        <div class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">{{ $usagePercent }}% Sold</div>
                                                    </div>
                                                    <div class="overflow-hidden h-1.5 text-xs flex rounded-full bg-gray-200 shadow-inner">
                                                        <div style="width: {{ $usagePercent }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gray-800 transition-all duration-1000"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Bottom Banner / Shipping Notice -->
                <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="inline-flex items-center p-2 bg-white/40 backdrop-blur-md rounded-full shadow-lg border border-white/50">
                        <span class="px-4 py-1.5 bg-gray-900 text-white text-xs font-bold rounded-full shadow-md flex items-center tracking-wide">
                            <svg class="w-3.5 h-3.5 mr-2 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            BONUS
                        </span>
                        <span class="px-4 py-1.5 text-sm font-medium text-gray-600">
                            Free shipping on orders over <span class="font-bold text-gray-900">RM 50</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Liquid Glass Styles -->
        <style>
            .animation-delay-2000 { animation-delay: 2s; }
            .animation-delay-4000 { animation-delay: 4s; }
            
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 10s infinite;
            }
            
            .glass-card {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.6) 0%, rgba(255, 255, 255, 0.2) 100%);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.8);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
            }
            .glass-card:hover {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.3) 100%);
                border-color: rgba(255, 255, 255, 1);
                box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.1);
            }
        </style>
        
        <!-- Copy Code Script -->
        <script>
            function copyCode(code) {
                navigator.clipboard.writeText(code).then(function() {
                    // Show toast notification
                    const toast = document.createElement('div');
                    toast.className = 'fixed bottom-4 right-4 z-50 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl shadow-2xl transform transition-all duration-300 flex items-center gap-2';
                    toast.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Code "' + code + '" copied!';
                    document.body.appendChild(toast);
                    
                    setTimeout(function() {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateY(20px)';
                        setTimeout(function() {
                            toast.remove();
                        }, 300);
                    }, 2000);
                });
            }
            
            // Live Countdown Timer for Liquid Glass Design
            function updateCountdownTimers() {
                const timers = document.querySelectorAll('.countdown-timer');
                
                timers.forEach(function(timer) {
                    const endsAt = new Date(timer.dataset.endsAt);
                    const now = new Date();
                    const diff = endsAt - now;
                    
                    const daysBoxEl = timer.querySelector('.countdown-days-box');
                    const hoursEl = timer.querySelector('.countdown-hours');
                    const minsEl = timer.querySelector('.countdown-mins');
                    const secsEl = timer.querySelector('.countdown-secs');
                    
                    if (diff <= 0) {
                        // Timer expired
                        if (daysBoxEl) daysBoxEl.textContent = '0d';
                        if (hoursEl) hoursEl.textContent = '00h';
                        if (minsEl) minsEl.textContent = '00m';
                        if (secsEl) secsEl.textContent = '00s';
                        timer.classList.add('opacity-50');
                        return;
                    }
                    
                    // Calculate time units
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const secs = Math.floor((diff % (1000 * 60)) / 1000);
                    
                    // Update display with subtle animation
                    if (daysBoxEl) {
                        const newDays = days + 'd';
                        if (daysBoxEl.textContent !== newDays) {
                            daysBoxEl.textContent = newDays;
                            daysBoxEl.classList.add('scale-105');
                            setTimeout(() => daysBoxEl.classList.remove('scale-105'), 150);
                        }
                    }
                    
                    if (hoursEl) {
                        const newHours = String(hours).padStart(2, '0') + 'h';
                        if (hoursEl.textContent !== newHours) {
                            hoursEl.textContent = newHours;
                            hoursEl.classList.add('scale-105');
                            setTimeout(() => hoursEl.classList.remove('scale-105'), 150);
                        }
                    }
                    
                    if (minsEl) {
                        const newMins = String(mins).padStart(2, '0') + 'm';
                        if (minsEl.textContent !== newMins) {
                            minsEl.textContent = newMins;
                            minsEl.classList.add('scale-105');
                            setTimeout(() => minsEl.classList.remove('scale-105'), 150);
                        }
                    }
                    
                    // Seconds always update
                    if (secsEl) {
                        secsEl.textContent = String(secs).padStart(2, '0') + 's';
                        secsEl.classList.add('scale-105');
                        setTimeout(() => secsEl.classList.remove('scale-105'), 150);
                    }
                });
            }
            
            // Initialize countdown timers
            document.addEventListener('DOMContentLoaded', function() {
                updateCountdownTimers(); // Initial update
                setInterval(updateCountdownTimers, 1000); // Update every second
            });
        </script>
        
        <!-- Countdown Animation Styles -->
        <style>
            .countdown-days-box, .countdown-hours, .countdown-mins, .countdown-secs {
                transition: transform 0.15s ease-out;
            }
        </style>
        @endif

        <!-- Browse By Category - Liquid Glass Theme -->
        <div class="relative py-24 overflow-hidden bg-gray-50/50">
            <!-- Liquid Background Elements -->
            <div class="absolute inset-0 opacity-100 overflow-hidden pointer-events-none">
                <div class="absolute top-20 right-1/4 w-72 h-72 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
                <div class="absolute bottom-10 left-1/3 w-80 h-80 bg-gray-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                <div class="absolute top-1/3 -left-10 w-64 h-64 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-60 animate-blob animation-delay-4000"></div>
            </div>

            <!-- Mesh Texture -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMCwgMCwgMCwgMC4wMykiLz48L3N2Zz4=')] opacity-30"></div>

            <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-12" data-aos="fade-up">
                    <span class="inline-flex items-center py-1.5 px-4 rounded-full bg-white/50 border border-white/50 backdrop-blur-sm text-gray-500 text-xs font-bold tracking-widest uppercase mb-4 shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Browse Categories
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold font-serif mb-6 text-gray-900 tracking-tight">
                        Find Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-700 to-gray-400">Genre</span>
                    </h2>
                    <p class="text-lg text-gray-500 leading-relaxed font-light">
                        Explore our diverse collection organized by your favorite genres.
                    </p>
                </div>

                <!-- Category Cards Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($genres as $genre)
                        <a href="{{ route('books.index', ['genre' => $genre->id]) }}" class="group bg-white/60 backdrop-blur-md rounded-[2.5rem] p-3 shadow-lg border border-white/80 hover:bg-white hover:border-white hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 h-full flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <div class="h-full bg-gradient-to-br from-white/80 to-white/40 rounded-[2rem] p-6 flex flex-col items-center justify-center text-center border border-white/50 group-hover:border-white/0 transition-all duration-300">
                                <!-- Category Icon -->
                                <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-white text-gray-700 group-hover:bg-gray-900 group-hover:text-white transition-all duration-300 mb-5 shadow-sm group-hover:shadow-lg group-hover:scale-110">
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
                                    <svg class="h-9 w-9 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $iconPath }}"/>
                                    </svg>
                                </div>

                                <!-- Category Info -->
                                <div>
                                    <h3 class="text-xl font-bold mb-1 text-gray-900 group-hover:text-purple-700 transition-colors duration-300 font-serif tracking-tight">{{ $genre->name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 group-hover:bg-purple-50 group-hover:text-purple-600 transition-colors duration-300">
                                        {{ $genre->books_count }} books
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- View All Books Button -->
                <div class="text-center mt-16" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('books.index') }}" class="group inline-flex items-center px-8 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                        <span>View All Books</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Customer Testimonials - Liquid Glass Theme -->
        <div class="relative py-24 overflow-hidden bg-gray-50/50">
            <!-- Liquid Background Elements -->
            <div class="absolute inset-0 opacity-100 overflow-hidden pointer-events-none">
                <div class="absolute top-20 right-1/4 w-72 h-72 bg-slate-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
                <div class="absolute bottom-10 left-1/3 w-80 h-80 bg-gray-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                <div class="absolute top-1/3 -left-10 w-64 h-64 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-60 animate-blob animation-delay-4000"></div>
            </div>

            <!-- Mesh Texture -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMCwgMCwgMCwgMC4wMykiLz48L3N2Zz4=')] opacity-30"></div>

            <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
                    <span class="inline-flex items-center py-1.5 px-4 rounded-full bg-white/50 border border-white/50 backdrop-blur-sm text-gray-500 text-xs font-bold tracking-widest uppercase mb-4 shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Customer Reviews
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold font-serif mb-6 text-gray-900 tracking-tight">
                        What Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-700 to-gray-400">Readers Say</span>
                    </h2>
                    <p class="text-lg text-gray-500 leading-relaxed font-light">
                        Don't just take our word for it — hear from our community of book lovers.
                    </p>
                </div>

                @if($testimonials->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        @php
                            $avatarBg = ['bg-slate-100/80', 'bg-gray-100/80', 'bg-stone-100/80'];
                            $delays = [100, 200, 300];
                        @endphp

                        @foreach($testimonials as $index => $testimonial)
                            <article class="group relative bg-white/60 backdrop-blur-md rounded-[2.5rem] p-3 shadow-lg border border-white/80 hover:bg-white hover:border-white hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 h-full flex flex-col" data-aos="fade-up" data-aos-delay="{{ $delays[$index % 3] }}">
                                <div class="h-full bg-gradient-to-b from-white/90 to-white/50 rounded-[2rem] p-8 flex flex-col border border-white/50 relative overflow-hidden">
                                    <!-- Decorative elements -->
                                    <span class="absolute top-4 right-6 text-8xl font-serif text-gray-100/80 leading-none select-none group-hover:text-purple-100/50 transition-colors duration-300">"</span>
                                    
                                    <!-- Stars -->
                                    <div class="relative flex items-center gap-0.5 mb-5" aria-label="Rating: {{ $testimonial->rating }} out of 5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 flex-shrink-0 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-xs font-bold text-gray-400 uppercase tracking-wide">Verified</span>
                                    </div>

                                    <!-- Quote -->
                                    <blockquote class="relative text-gray-700 mb-6 leading-relaxed text-base flex-1">
                                        {{ \Illuminate\Support\Str::limit($testimonial->comment, 180) }}
                                    </blockquote>

                                    <!-- Author -->
                                    <div class="relative flex items-center gap-4 pt-5 border-t border-gray-100">
                                        <div class="w-12 h-12 rounded-full {{ $avatarBg[$index % 3] }} backdrop-blur-sm border border-white/80 flex items-center justify-center text-gray-700 font-bold text-lg flex-shrink-0 group-hover:bg-gray-900 group-hover:text-white transition-all duration-300 shadow-sm">
                                            {{ strtoupper(substr($testimonial->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-900 truncate font-serif">{{ $testimonial->user->name ?? 'Anonymous' }}</p>
                                            @if($testimonial->book)
                                                <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1 truncate">
                                                    <span>on</span>
                                                    <span class="font-medium text-purple-600 truncate">{{ \Illuminate\Support\Str::limit($testimonial->book->title, 28) }}</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <!-- Empty state - liquid glass -->
                    <div class="text-center py-16" data-aos="fade-up">
                        <div class="inline-flex flex-col items-center px-8 py-12 bg-white/60 backdrop-blur-md rounded-2xl shadow-lg border border-white/80 max-w-xl">
                            <div class="w-16 h-16 rounded-full bg-white/80 border border-white/80 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Be the first to share your experience</h3>
                            <p class="text-gray-500 leading-relaxed mb-6">
                                We'd love to hear what you think about your recent purchases.
                            </p>
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-black transition-colors duration-300">
                                Sign in to leave a review
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Trust Indicators - Liquid Glass Cards -->
                <div class="mt-16" data-aos="fade-up" data-aos-delay="200">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                        <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-3 shadow-lg border border-white/80 hover:bg-white hover:border-white hover:shadow-xl transition-all duration-300 text-center group">
                            <div class="bg-gradient-to-br from-white/90 to-white/50 rounded-[2rem] p-6 h-full flex flex-col justify-center border border-white/50">
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mb-1 group-hover:scale-110 transition-transform duration-300">
                                    @if($totalCustomers >= 1000)
                                        {{ number_format($totalCustomers / 1000, 1) }}K+
                                    @else
                                        {{ number_format($totalCustomers) }}+
                                    @endif
                                </p>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Happy Customers</p>
                            </div>
                        </div>
                        <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-3 shadow-lg border border-white/80 hover:bg-white hover:border-white hover:shadow-xl transition-all duration-300 text-center group">
                            <div class="bg-gradient-to-br from-white/90 to-white/50 rounded-[2rem] p-6 h-full flex flex-col justify-center border border-white/50">
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mb-1 group-hover:scale-110 transition-transform duration-300">
                                    @if($totalBooksSold >= 1000)
                                        {{ number_format($totalBooksSold / 1000, 1) }}K+
                                    @else
                                        {{ number_format($totalBooksSold) }}+
                                    @endif
                                </p>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Books Sold</p>
                            </div>
                        </div>
                        <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-3 shadow-lg border border-white/80 hover:bg-white hover:border-white hover:shadow-xl transition-all duration-300 text-center group">
                            <div class="bg-gradient-to-br from-white/90 to-white/50 rounded-[2rem] p-6 h-full flex flex-col justify-center border border-white/50">
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mb-1 group-hover:scale-110 transition-transform duration-300">
                                    {{ $averageRating ? number_format($averageRating, 1) : '5.0' }}<span class="text-gray-400 font-normal text-lg">/5</span>
                                </p>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Average Rating</p>
                            </div>
                        </div>
                        <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-3 shadow-lg border border-white/80 hover:bg-white hover:border-white hover:shadow-xl transition-all duration-300 text-center group">
                            <div class="bg-gradient-to-br from-white/90 to-white/50 rounded-[2rem] p-6 h-full flex flex-col justify-center border border-white/50">
                                <p class="text-2xl md:text-3xl font-bold text-gray-900 mb-1 group-hover:scale-110 transition-transform duration-300">{{ $satisfactionRate }}%</p>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Satisfaction Rate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced New Arrivals - Liquid Glass Theme -->
        <div id="featured" class="relative py-24 overflow-hidden bg-gray-50/50">
            <!-- Liquid Background Elements -->
            <div class="absolute inset-0 opacity-100 overflow-hidden pointer-events-none">
                <div class="absolute top-20 left-1/4 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
                <div class="absolute bottom-10 right-1/3 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                <div class="absolute top-1/3 right-10 w-64 h-64 bg-pink-100 rounded-full mix-blend-overlay filter blur-3xl opacity-60 animate-blob animation-delay-4000"></div>
            </div>

            <!-- Mesh Texture -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMCwgMCwgMCwgMC4wMykiLz48L3N2Zz4=')] opacity-30"></div>

            <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                    <span class="inline-flex items-center py-1.5 px-4 rounded-full bg-white/50 border border-white/50 backdrop-blur-sm text-purple-700 text-xs font-bold tracking-widest uppercase mb-4 shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Latest Additions
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold font-serif mb-6 text-gray-900 tracking-tight">
                        Fresh <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">New Arrivals</span>
                    </h2>
                    <p class="text-lg text-gray-500 leading-relaxed font-light">
                        Discover the latest additions to our collection — fresh stories and new adventures await.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                    @if($newArrivals->count() > 0)
                        @foreach($newArrivals->take(8) as $book)
                            <!-- Liquid Glass Card Frame -->
                            <div class="group relative bg-white/60 backdrop-blur-md rounded-[2.5rem] p-3 shadow-lg border border-white/80 hover:bg-white hover:border-white hover:shadow-2xl hover:shadow-purple-900/10 transition-all duration-500 transform hover:-translate-y-2 h-full flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                
                                <!-- Inner Content -->
                                <div class="relative w-full aspect-[3/4] rounded-[2rem] overflow-hidden shadow-inner">
                                    <a href="{{ route('books.show', $book) }}" class="block w-full h-full">
                                        @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-purple-50 to-indigo-50 flex items-center justify-center group-hover:from-purple-100 group-hover:to-indigo-100 transition-colors duration-500">
                                                <svg class="h-16 w-16 text-purple-200 group-hover:text-purple-300 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>

                                    <!-- Liquid Glass Badges -->
                                    <div class="absolute top-3 left-3 flex flex-col gap-2 z-10">
                                        @if(($book->condition ?? 'new') === 'preloved')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-white/90 backdrop-blur-md text-amber-700 shadow-lg border border-white/50">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                Preloved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-white/90 backdrop-blur-md text-emerald-700 shadow-lg border border-white/50">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                New
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Wishlist Button - Glass Style -->
                                    <div class="absolute top-3 right-3 z-20">
                                        @auth
                                            <button type="button" 
                                                class="wishlist-btn p-2.5 bg-white/80 rounded-full hover:bg-white text-gray-600 hover:text-pink-600 transition-all duration-300 backdrop-blur-md shadow-lg border border-white/50 hover:scale-110"
                                                data-book-id="{{ $book->id }}"
                                                data-in-wishlist="{{ Auth::user()->hasBookInWishlist($book->id) ? 'true' : 'false' }}"
                                                title="Add to Wishlist">
                                                @if(Auth::user()->hasBookInWishlist($book->id))
                                                    <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                    </svg>
                                                @endif
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" class="block p-2.5 bg-white/80 rounded-full hover:bg-white text-gray-600 hover:text-pink-600 transition-all duration-300 backdrop-blur-md shadow-lg border border-white/50 hover:scale-110" title="Sign in to Wishlist">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                            </a>
                                        @endauth
                                    </div>

                                    <!-- Quick Add Button (Bottom of Image) -->
                                    <div class="absolute bottom-3 left-3 right-3 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
                                        <button onclick="quickAddToCart({{ $book->id }})" class="quick-add-btn w-full py-2.5 bg-white/95 backdrop-blur-md text-gray-900 text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-white shadow-xl hover:shadow-2xl border border-white/60 transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2">
                                            <span class="btn-text">Quick Add</span>
                                            <span class="loading-spinner hidden">
                                                <svg class="animate-spin h-3 w-3 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Adding
                                            </span>
                                        </button>
                                    </div>
                                    
                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                </div>

                                <!-- Card Details -->
                                <div class="px-3 pt-5 pb-2 flex-grow flex flex-col">
                                    <div class="mb-2">
                                        <span class="text-[10px] font-bold tracking-widest uppercase text-purple-600 bg-purple-50/50 border border-purple-100 px-2 py-1 rounded-md">{{ $book->genre?->name ?? 'Mixed' }}</span>
                                    </div>

                                    <a href="{{ route('books.show', $book) }}" class="block mb-1">
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-700 transition-colors duration-200 line-clamp-1 font-serif tracking-tight">{{ $book->title }}</h3>
                                    </a>
                                    <p class="text-gray-500 text-xs font-medium mb-3 truncate">by {{ $book->author }}</p>

                                    <!-- Rating Stars -->
                                    <div class="flex items-center gap-1 mb-auto">
                                        @php $avgRating = $book->average_rating; @endphp
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= ($avgRating ?: 0) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>

                                    <!-- Price / Action -->
                                    <div class="flex items-center justify-between mt-4">
                                        <div>
                                            @if($book->is_on_sale)
                                                <div class="flex flex-col items-start leading-none">
                                                    <span class="text-[10px] text-gray-400 line-through mb-1">RM {{ number_format($book->price, 2) }}</span>
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="text-lg font-bold text-gray-900">RM {{ number_format($book->final_price, 2) }}</span>
                                                        <span class="text-[9px] font-bold text-red-600 bg-red-50 border border-red-100 px-1 py-0.5 rounded">-{{ $book->discount_percent }}%</span>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-lg font-bold text-gray-900">RM {{ number_format($book->price, 2) }}</span>
                                            @endif
                                        </div>
                                        
                                        <button onclick="quickAddToCart({{ $book->id }})" class="quick-add-btn p-2.5 rounded-full bg-gray-900 text-white hover:bg-purple-600 hover:shadow-lg transition-all duration-300 group-hover:scale-110 shadow-md flex items-center justify-center">
                                            <span class="btn-text">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                            </span>
                                            <span class="loading-spinner hidden">
                                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Empty state with Liquid Glass style -->
                        <div class="col-span-full text-center py-12">
                            <div class="inline-flex items-center px-6 py-4 rounded-2xl bg-white/60 backdrop-blur-md border border-white/80 text-gray-500 shadow-sm">
                                <svg class="w-5 h-5 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                No new arrivals yet. Check back soon!
                            </div>
                        </div>
                    @endif
        </div>        </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('books.index') }}" class="group inline-flex items-center px-10 py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                        <span class="mr-2">Explore Full Collection</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Enhanced Newsletter -->
        <!-- Compact Liquid Newsletter -->
        <!-- Compact Liquid Newsletter - Light Theme -->
        <div class="py-12 relative overflow-hidden bg-gray-50/50">
            <!-- Liquid Background Elements -->
            <div class="absolute inset-0 opacity-100 overflow-hidden pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            </div>
            
            <!-- Mesh Texture -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMCwgMCwgMCwgMC4wMykiLz48L3N2Zz4=')] opacity-30"></div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="bg-white/60 backdrop-blur-md rounded-[2.5rem] p-8 md:p-10 border border-white/80 shadow-lg relative overflow-hidden group">
                    <div class="grid lg:grid-cols-2 gap-8 items-center">
                        <!-- Content Side -->
                        <div class="text-left">
                            <div class="inline-flex items-center px-3 py-1 bg-white/80 backdrop-blur-sm rounded-full text-xs font-bold text-purple-700 border border-white/60 mb-4 shadow-sm">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                Weekly Digest
                            </div>
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 tracking-tight font-serif">
                                Unlock Your Next
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">Favorite Story</span>
                            </h2>
                            <p class="text-gray-600 text-lg mb-6 leading-relaxed max-w-md font-light">
                                Join 10,000+ readers getting curated picks and exclusive deals directly to their inbox.
                            </p>

                            <!-- Compact Benefits -->
                            <div class="flex flex-wrap gap-4 text-sm text-gray-500 font-medium">
                                <div class="flex items-center bg-white/50 rounded-lg px-3 py-2 border border-white/50">
                                    <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Curated Picks
                                </div>
                                <div class="flex items-center bg-white/50 rounded-lg px-3 py-2 border border-white/50">
                                    <svg class="w-4 h-4 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Early Access
                                </div>
                                <div class="flex items-center bg-white/50 rounded-lg px-3 py-2 border border-white/50">
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                                    Special Deals
                                </div>
                            </div>
                        </div>

                        <!-- Form Side -->
                        <div class="bg-white/40 backdrop-blur-sm rounded-2xl p-6 border border-white/50">
                            <form class="flex flex-col gap-3">
                                <div class="relative">
                                    <input type="email" placeholder="Enter your email address" class="w-full px-5 py-3.5 bg-white/80 backdrop-blur text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/20 border-white/60 placeholder-gray-400 font-medium transition-all shadow-sm">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                </div>
                                <button type="submit" class="group w-full py-3.5 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 flex items-center justify-center">
                                    <span>Subscribe Free</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </button>
                                <p class="text-center text-xs text-gray-500 mt-2">
                                    No spam, unsubscribe anytime.
                                </p>
                            </form>
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


