@extends('layouts.app')

@section('content')
    <style>
        /* Enhanced Liquid Glass Theme Styles */
        .glass-panel {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(16px) saturate(150%);
            -webkit-backdrop-filter: blur(16px) saturate(150%);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 
                0 4px 24px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }
        .glass-sidebar {
            background: rgba(248, 250, 252, 0.7);
            backdrop-filter: blur(20px) saturate(150%);
            -webkit-backdrop-filter: blur(20px) saturate(150%);
            border-left: 1px solid rgba(255, 255, 255, 0.6);
        }
        .glass-button {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        .glass-button:hover {
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        .book-cover-shadow {
            box-shadow: 
                0 20px 40px -12px rgba(0, 0, 0, 0.3),
                0 8px 16px -6px rgba(0, 0, 0, 0.2);
        }
        .ambient-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.5;
            pointer-events: none;
            z-index: 0;
        }
    </style>

    <div class="min-h-screen py-8" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);">
        <!-- Ambient Background Glows for Glass Effect -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="ambient-glow w-[500px] h-[500px] bg-violet-300/40" style="top: -200px; left: -150px;"></div>
            <div class="ambient-glow w-[400px] h-[400px] bg-sky-300/30" style="top: 30%; right: -100px;"></div>
            <div class="ambient-glow w-[350px] h-[350px] bg-rose-300/25" style="bottom: -100px; left: 30%;"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Breadcrumb Navigation -->
            <nav class="mb-8 flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Home</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('books.index') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Books</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-medium truncate max-w-xs">{{ $book->title }}</span>
            </nav>

            {{-- Flash messages are now handled by JavaScript toast notifications --}}

            <!-- Main Book Detail Card -->
            <div class="glass-panel rounded-3xl overflow-hidden">
                <div class="lg:flex">

                <!-- Book Cover Section (Smaller) -->
                <div class="lg:w-1/4 p-6 lg:p-8">
                    <div class="sticky top-8">
                        <!-- Book Cover with Enhanced Shadow -->
                        <div class="relative rounded-2xl overflow-hidden book-cover-shadow group">
                            @if($book->cover_image)
                                <img
                                    src="{{ asset('storage/' . $book->cover_image) }}"
                                    alt="{{ $book->title }}"
                                    class="w-full h-auto object-cover transform transition-transform duration-700 ease-out group-hover:scale-[1.02]"
                                >
                            @else
                                <div class="w-full aspect-[3/4] bg-gray-100 flex items-center justify-center rounded-2xl">
                                    <svg class="h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Floating Badges -->
                            <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
                                <div class="flex flex-col gap-2">
                                    @if($book->is_on_sale)
                                        <span class="glass-button inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold text-gray-900">
                                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                            {{ $book->discount_percent }}% OFF
                                        </span>
                                    @endif
                                    <span class="glass-button inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold
                                        {{ ($book->condition ?? 'new') === 'preloved' ? 'text-amber-800' : 'text-emerald-800' }}">
                                        {{ $book->condition_label ?? 'New' }}
                                    </span>
                                </div>

                                <!-- Wishlist Button -->
                                <div class="pointer-events-auto">
                                    @auth
                                        <button
                                            id="wishlist-button"
                                            class="wishlist-btn glass-button h-11 w-11 flex items-center justify-center rounded-full text-gray-600 hover:text-red-500 transition-all duration-300"
                                            data-book-id="{{ $book->id }}"
                                            data-in-wishlist="{{ Auth::user()->hasBookInWishlist($book->id) ? 'true' : 'false' }}"
                                            aria-label="{{ Auth::user()->hasBookInWishlist($book->id) ? 'Remove from wishlist' : 'Add to wishlist' }}"
                                        >
                                            <svg
                                                class="w-5 h-5 {{ Auth::user()->hasBookInWishlist($book->id) ? 'fill-current text-red-500' : 'fill-none' }}"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </button>
                                    @else
                                        <button
                                            type="button"
                                            onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'}))"
                                            class="glass-button h-11 w-11 flex items-center justify-center rounded-full text-gray-600 hover:text-red-500 transition-all duration-300"
                                            aria-label="Sign in to save"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        <!-- Purchase Panel -->
                        <div class="mt-6 glass-card rounded-2xl p-5">
                            <!-- Price & Stock -->
                            <div class="mb-5">
                                @if($book->is_on_sale)
                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                        <span class="text-2xl font-bold text-gray-900">
                                            RM {{ number_format($book->final_price, 2) }}
                                        </span>
                                        <span class="text-sm text-gray-400 line-through">
                                            RM {{ number_format($book->price, 2) }}
                                        </span>
                                        <span class="px-1.5 py-0.5 text-xs font-bold rounded bg-red-100 text-red-600">
                                            -{{ $book->discount_percent }}%
                                        </span>
                                    </div>
                                @else
                                    <span class="text-2xl font-bold text-gray-900 block mb-1">
                                        RM {{ number_format($book->price, 2) }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="inline-flex items-center gap-1 {{ $book->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $book->stock > 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                        {{ $book->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                    <span class="text-gray-400">•</span>
                                    <span class="text-gray-500">{{ $book->stock > 0 ? 'Ready to ship' : 'Currently unavailable' }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                @if($book->stock > 0)
                                    <button
                                        type="button"
                                        class="w-full py-3.5 px-6 rounded-xl bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl ajax-add-to-cart"
                                        data-book-id="{{ $book->id }}"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        Add to Cart
                                    </button>
                                @else
                                    <button
                                        type="button"
                                        class="w-full py-3.5 px-6 rounded-xl bg-gray-100 text-gray-400 text-sm font-semibold cursor-not-allowed border border-gray-200"
                                        disabled
                                    >
                                        Out of Stock
                                    </button>
                                @endif

                                @auth
                                    <button
                                        type="button"
                                        id="wishlist-button-secondary"
                                        class="wishlist-btn w-full py-3 px-6 rounded-xl glass-button text-sm font-medium flex items-center justify-center gap-2
                                            {{ Auth::user()->hasBookInWishlist($book->id) ? 'text-red-600' : 'text-gray-700' }}"
                                        data-book-id="{{ $book->id }}"
                                        data-in-wishlist="{{ Auth::user()->hasBookInWishlist($book->id) ? 'true' : 'false' }}"
                                    >
                                        @if(Auth::user()->hasBookInWishlist($book->id))
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Saved to Wishlist</span>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            <span>Add to Wishlist</span>
                                        @endif
                                    </button>
                                @else
                                    <button
                                        type="button"
                                        onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'}))"
                                        class="w-full py-3 px-6 rounded-xl glass-button text-gray-700 text-sm font-medium flex items-center justify-center gap-2"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Sign in to Save
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book Details Section -->
                <div class="lg:w-1/2 p-6 lg:p-8 border-l border-white/30">
                    <!-- Title & Author -->
                    <div class="mb-5">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight mb-2">{{ $book->title }}</h1>
                        <p class="text-base text-gray-500">by <span class="text-gray-700 font-medium">{{ $book->author }}</span></p>
                    </div>

                    <!-- Tags/Badges -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        @if(($book->condition ?? 'new') === 'preloved')
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                Preloved
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                New
                            </span>
                        @endif
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-50 text-purple-700 border border-purple-200">
                            {{ $book->genre->name }}
                        </span>
                        @foreach($book->tropes as $trope)
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                {{ $trope->name }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Synopsis Card -->
                    <div class="glass-card rounded-xl p-5 mb-6">
                        <h2 class="text-base font-bold text-gray-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            Synopsis
                        </h2>
                        <div class="relative">
                            <div id="synopsis-content" class="text-gray-600 text-sm leading-relaxed max-h-24 overflow-hidden transition-all duration-500 ease-in-out">
                                <p>{{ $book->synopsis }}</p>
                            </div>
                            <div id="synopsis-fade" class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-t from-white/80 to-transparent pointer-events-none"></div>
                        </div>
                        <button id="toggle-synopsis" class="text-gray-900 hover:text-gray-700 font-medium mt-2 text-xs inline-flex items-center gap-1">
                            Read More
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Book Details Grid -->
                    <div class="glass-card rounded-xl p-5">
                        <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Book Details
                        </h2>
                        <dl class="grid grid-cols-2 gap-3">
                            <div class="p-3 rounded-lg bg-gray-50/60">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-0.5">Author</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $book->author }}</dd>
                            </div>
                            <div class="p-3 rounded-lg bg-gray-50/60">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-0.5">Genre</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $book->genre->name }}</dd>
                            </div>
                            <div class="p-3 rounded-lg bg-gray-50/60">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-0.5">Condition</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $book->condition_label ?? 'New' }}</dd>
                            </div>
                            <div class="p-3 rounded-lg bg-gray-50/60">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-0.5">Tropes</dt>
                                <dd class="text-sm font-semibold text-gray-900 truncate">{{ $book->tropes->pluck('name')->join(', ') ?: 'None' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Similar Books Sidebar -->
                <div class="lg:w-1/4 p-6 glass-sidebar">
                    <div class="sticky top-8">
                        <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Similar Books
                        </h3>
                        
                        <div id="similar-books-list" class="space-y-3">
                            <!-- Loading state -->
                            <div class="text-center py-6">
                                <div class="inline-flex items-center px-3 py-2 glass-card rounded-lg">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-xs text-gray-600">Loading...</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- View All Button -->
                        <div class="mt-5">
                            <a href="{{ route('books.index') }}" class="block w-full text-center px-4 py-2.5 bg-gray-900 text-white text-xs font-semibold rounded-xl hover:bg-gray-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                View All Books
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reviews Section -->
        <div class="mt-12 glass-panel rounded-3xl p-8 lg:p-10">
            <div class="max-w-7xl mx-auto">
                <div class="flex max-lg:flex-col gap-10 lg:gap-16">
                    <!-- Left Sidebar - Review Statistics -->
                    <div class="lg:w-80 shrink-0">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Customer Reviews</h2>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="flex items-center gap-0.5 text-amber-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $reviewStats['average'])
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z"/>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] text-gray-300 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-slate-900 font-semibold text-sm">{{ $reviewStats['average'] }} out of 5</p>
                            </div>
                            <p class="mt-4 text-slate-600 text-sm">global ratings ({{ $reviewStats['total'] }} reviews)</p>
                        </div>
                        
                        <!-- Rating Breakdown -->
                        <div class="space-y-1 mt-6">
                            @for ($rating = 5; $rating >= 1; $rating--)
                                <div class="flex items-center">
                                    <div class="min-w-9">
                                        <p class="text-sm text-slate-900">{{ $rating }}.0</p>
                                    </div>
                                    <div class="bg-gray-300 rounded w-full h-3">
                                        <div class="h-full rounded bg-orange-500" style="width: {{ $reviewStats['percentages'][$rating] }}%"></div>
                                    </div>
                                    <div class="min-w-14">
                                        <p class="text-sm text-slate-900 ml-4">{{ $reviewStats['percentages'][$rating] }}%</p>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <hr class="border-gray-300 my-6" />

                        <!-- Write Review Section -->
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 !leading-tight mb-4">Review this product</h3>
                            <p class="mt-4 text-slate-600 text-sm">Share your thoughts with other customers</p>
                            @auth
                                @if($canReview && !$hasReviewed && $orderItem)
                                    <button type="button" id="writeReviewBtn" class="cursor-pointer px-4 py-2 text-white font-medium text-sm rounded-md mt-6 bg-orange-500 hover:bg-orange-600">Write a customer review</button>
                                @elseif($hasReviewed)
                                    <div class="mt-6 px-4 py-2 bg-green-100 text-green-800 rounded-md text-sm">
                                        ✓ You've already reviewed this book. Thank you!
                                    </div>
                                @else
                                    <div class="mt-6 px-4 py-2 bg-gray-100 text-gray-600 rounded-md text-sm">
                                        Only customers who purchased this book can leave a review.
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="cursor-pointer px-4 py-2 text-white font-medium text-sm rounded-md mt-6 bg-orange-500 hover:bg-orange-600 inline-block">Sign in to write a review</a>
                            @endauth
                        </div>
                    </div>

                    <!-- Right Side - Reviews -->
                    <div class="flex-1">
                        <!-- Reviews with Images Gallery -->
                        @if($reviewsWithImages->count() > 0)
                            @php
                                // Build the complete array of all review images first
                                $allReviewImages = [];
                                foreach($reviewsWithImages as $reviewWithImage) {
                                    foreach($reviewWithImage->image_urls as $imageUrl) {
                                        $allReviewImages[] = $imageUrl;
                                    }
                                }
                                $totalImages = count($allReviewImages);
                            @endphp
                            <div class="group">
                                <h3 class="text-lg font-semibold text-slate-900 !leading-tight mb-4">Reviews with Images</h3>
                                <div class="relative">
                                    <!-- Gallery Container -->
                                    <div id="review-gallery" class="flex items-center gap-4 overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                        @php $imageIndex = 0; @endphp
                                        @foreach($reviewsWithImages as $reviewWithImage)
                                            @foreach($reviewWithImage->image_urls as $imageUrl)
                                                <img src="{{ $imageUrl }}" 
                                                     class="bg-gray-100 object-cover p-2 w-[232px] h-[232px] cursor-pointer hover:opacity-90 hover:scale-105 transition-all duration-300 rounded-lg flex-shrink-0" 
                                                     alt="customer-review-image" 
                                                     onclick="openImageModal('{{ $imageUrl }}', {{ $imageIndex }}, {!! json_encode($allReviewImages) !!})" />
                                                @php $imageIndex++; @endphp
                                            @endforeach
                                        @endforeach
                                    </div>
                                    
                                    <!-- Gallery Navigation Buttons (show only if more than 4 images) -->
                                    @if($totalImages > 4)
                                        <button id="gallery-prev" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow-lg rounded-full p-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <button id="gallery-next" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow-lg rounded-full p-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    
                                    <!-- Gallery Indicators -->
                                    @if($totalImages > 1)
                                        <div class="flex justify-center mt-4 gap-2">
                                            <span class="text-sm text-gray-500">{{ $totalImages }} photos from customer reviews</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Individual Reviews -->
                        <div id="reviews-container" data-reviews-url="{{ route('books.reviews', $book) }}" class="divide-y divide-gray-300 {{ $reviewsWithImages->count() > 0 ? 'mt-8' : '' }}">
                            @include('books.partials.reviews-list')
                        </div>
                    </div>
                </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // function to initialize pagination links
            function initPagination() {
                document.querySelectorAll('.ajax-pagination-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const href = this.getAttribute('href');
                        const container = document.getElementById('reviews-container');
                        const reviewsBaseUrl = container.dataset.reviewsUrl;
                        
                        // Construct the correct AJAX URL
                        // We always want to hit the reviews endpoint
                        // Extract query parameters (like page=2) from the link href
                        let targetUrl = href;
                        try {
                            const urlObj = new URL(href);
                            const params = new URLSearchParams(urlObj.search);
                            // If reviewsBaseUrl already has query params, we need to handle that, but typically it doesn't
                            // We just append the params from the clicked link
                            targetUrl = `${reviewsBaseUrl}?${params.toString()}`;
                        } catch (err) {
                            console.error('Invalid URL:', href);
                            // Fallback to trying to append /reviews if relative (unlikely)
                            if (!href.includes('/reviews')) {
                                targetUrl = href.replace(window.location.pathname, window.location.pathname + '/reviews');
                            }
                        }
                        
                        loadReviews(targetUrl);
                    });
                });
            }

            // function to load reviews via AJAX
            function loadReviews(url) {
                // Show loading state
                const container = document.getElementById('reviews-container');
                container.style.opacity = '0.5';
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(html => {
                    container.innerHTML = html;
                    container.style.opacity = '1';
                    
                    // Re-initialize pagination links for the new content
                    initPagination();
                    
                    // Scroll to top of reviews container
                    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                })
                .catch(error => {
                    console.error('Error loading reviews:', error);
                    container.style.opacity = '1';
                    alert('Failed to load reviews. Please try again.');
                });
            }

            // Initial initialization
            initPagination();
        });
    </script>
            </div>
        </div>
        
        <!-- Write Review Modal -->
        @auth
            @if($canReview && !$hasReviewed && $orderItem)
                <div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Write a Review</h3>
                                <button type="button" id="closeReviewModal" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('books.reviews.store', $book) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order_item_id" value="{{ $orderItem->id }}">
                                
                                <div class="mb-4">
                                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                    <div class="flex items-center space-x-2 star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer star-rating-item" data-rating="{{ $i }}">
                                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only star-input" required {{ old('rating') == $i ? 'checked' : '' }}>
                                                <svg class="w-6 h-6 text-gray-300 star-svg transition-colors duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                </svg>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                                    <textarea name="comment" id="comment" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" placeholder="Share your experience with this book...">{{ old('comment') }}</textarea>
                                </div>
                                
                                <!-- Image Upload Section -->
                                <div class="mb-4">
                                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Add Photos (Optional)</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" id="image-upload-area">
                                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden" onchange="handleImageUpload(event)">
                                        <div class="space-y-2">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="text-sm text-gray-600">
                                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                                    <span>Upload photos</span>
                                                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="sr-only" onchange="handleImageUpload(event)">
                                                </label>
                                                <span class="pl-1">or drag and drop</span>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB each (max 5 photos)</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Preview Gallery -->
                                    <div id="image-preview-gallery" class="mt-4 gap-4 hidden">
                                        <!-- Preview images will be inserted here -->
                                    </div>
                                </div>
                                
                                <div class="flex justify-end space-x-3">
                                    <button type="button" id="cancelReview" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
        
        <!-- Related Books -->
        @if($relatedBooks->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-serif font-bold text-gray-900 mb-6">You May Also Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedBooks as $relatedBook)
                        <x-book-card :book="$relatedBook" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Report Abuse Modal -->
    <div id="reportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Report Review</h3>
                <form id="reportForm">
                    @csrf
                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for reporting</label>
                        <select id="reason" name="reason" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" required>
                            <option value="">Select a reason</option>
                            <option value="spam">Spam</option>
                            <option value="inappropriate">Inappropriate content</option>
                            <option value="offensive">Offensive language</option>
                            <option value="fake">Fake review</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Additional details (optional)</label>
                        <textarea id="description" name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" placeholder="Please provide more details about why you're reporting this review..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelReport" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                            Report Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Gallery Modal (Shopee-style) -->
    <div id="imageModal" class="fixed inset-0 z-[100] hidden">
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/95"></div>
        
        <!-- Modal Container -->
        <div class="relative w-full h-full flex flex-col">
            <!-- Header -->
            <div class="shrink-0 flex items-center justify-between px-6 py-4">
                <div class="flex items-center gap-3">
                    <span class="text-white font-medium">Review Photos</span>
                    <span id="imageCounter" class="text-white/60 text-sm">1 / 5</span>
                </div>
                <button type="button" id="closeImageModal" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Main Image Area -->
            <div class="flex-1 relative flex items-center justify-center px-16 py-4 min-h-0">
                <!-- Previous Button -->
                <button id="prevImage" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all z-10">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <!-- Main Image -->
                <img id="modalMainImage" src="" alt="Review image" class="max-w-full max-h-full object-contain rounded-lg transition-opacity duration-300">
                
                <!-- Next Button -->
                <button id="nextImage" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all z-10">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Thumbnail Strip -->
            <div class="shrink-0 px-6 py-4 bg-black/50">
                <div id="thumbnails" class="flex items-center justify-center gap-2 overflow-x-auto scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent py-1">
                    <!-- Thumbnails will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Synopsis toggle functionality
            const synopsisContent = document.getElementById('synopsis-content');
            const synopsisFade = document.getElementById('synopsis-fade');
            const toggleSynopsisBtn = document.getElementById('toggle-synopsis');

            if (synopsisContent && toggleSynopsisBtn && synopsisFade) {
                // Check if content actually overflows, if not hide the button and fade
                setTimeout(() => {
                    if (synopsisContent.scrollHeight <= synopsisContent.clientHeight) {
                        toggleSynopsisBtn.style.display = 'none';
                        synopsisFade.style.display = 'none';
                        synopsisContent.classList.remove('max-h-28');
                    }
                }, 100);

                toggleSynopsisBtn.addEventListener('click', function() {
                    const isCollapsed = synopsisContent.classList.contains('max-h-28');
                    
                    if (isCollapsed) {
                        // Expand
                        synopsisContent.style.maxHeight = synopsisContent.scrollHeight + 'px';
                        synopsisContent.classList.remove('max-h-28');
                        synopsisFade.classList.add('hidden');
                        this.textContent = 'Read Less';
                    } else {
                        // Collapse
                        synopsisContent.style.maxHeight = null;
                        synopsisContent.classList.add('max-h-28');
                        synopsisFade.classList.remove('hidden');
                        this.textContent = 'Read More';
                    }
                });
            }

            // Gallery Navigation functionality
            const galleryContainer = document.getElementById('review-gallery');
            const galleryPrevBtn = document.getElementById('gallery-prev');
            const galleryNextBtn = document.getElementById('gallery-next');
            
            if (galleryContainer && galleryPrevBtn && galleryNextBtn) {
                const scrollAmount = 240; // Width of one image plus gap
                
                galleryPrevBtn.addEventListener('click', function() {
                    galleryContainer.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                });
                
                galleryNextBtn.addEventListener('click', function() {
                    galleryContainer.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                });
                
                // Update button visibility based on scroll position
                function updateGalleryButtons() {
                    const isAtStart = galleryContainer.scrollLeft <= 0;
                    const isAtEnd = galleryContainer.scrollLeft >= (galleryContainer.scrollWidth - galleryContainer.clientWidth);
                    
                    galleryPrevBtn.style.opacity = isAtStart ? '0.3' : '1';
                    galleryNextBtn.style.opacity = isAtEnd ? '0.3' : '1';
                    galleryPrevBtn.style.pointerEvents = isAtStart ? 'none' : 'auto';
                    galleryNextBtn.style.pointerEvents = isAtEnd ? 'none' : 'auto';
                }
                
                // Listen for scroll events to update button states
                galleryContainer.addEventListener('scroll', updateGalleryButtons);
                
                // Initial button state
                updateGalleryButtons();
            }

            // Review Modal functionality
            const reviewModal = document.getElementById('reviewModal');
            const writeReviewBtn = document.getElementById('writeReviewBtn');
            const closeReviewModal = document.getElementById('closeReviewModal');
            const cancelReview = document.getElementById('cancelReview');
            
            if (writeReviewBtn && reviewModal) {
                writeReviewBtn.addEventListener('click', function() {
                    reviewModal.classList.remove('hidden');
                });
            }
            
            if (closeReviewModal && reviewModal) {
                closeReviewModal.addEventListener('click', function() {
                    reviewModal.classList.add('hidden');
                });
            }
            
            if (cancelReview && reviewModal) {
                cancelReview.addEventListener('click', function() {
                    reviewModal.classList.add('hidden');
                });
            }
            
            // Close modal when clicking outside
            if (reviewModal) {
                reviewModal.addEventListener('click', function(e) {
                    if (e.target === reviewModal) {
                        reviewModal.classList.add('hidden');
                    }
                });
            }
            
            // Star Rating functionality for review modal
            const starContainer = document.querySelector('.star-rating');
            if (starContainer) {
                const stars = document.querySelectorAll('.star-rating-item');
                const inputs = document.querySelectorAll('.star-input');
                
                // Check if there's a pre-selected value (e.g., from validation errors)
                let selectedRating = 0;
                inputs.forEach(input => {
                    if (input.checked) {
                        selectedRating = parseInt(input.value);
                        updateStars(selectedRating);
                    }
                });
                
                // Add click event for each star
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = parseInt(this.dataset.rating);
                        
                        // Select the correct radio button
                        const input = this.querySelector('input');
                        input.checked = true;
                        
                        // Update the UI
                        updateStars(rating);
                    });
                    
                    // Add hover effect
                    star.addEventListener('mouseenter', function() {
                        const rating = parseInt(this.dataset.rating);
                        hoverStars(rating);
                    });
                });
                
                // Reset stars on mouse leave if no selection
                starContainer.addEventListener('mouseleave', function() {
                    updateStars(selectedRating);
                });
                
                // Function to update stars based on rating
                function updateStars(rating) {
                    selectedRating = rating;
                    stars.forEach(star => {
                        const starRating = parseInt(star.dataset.rating);
                        const starSvg = star.querySelector('.star-svg');
                        
                        if (starRating <= rating) {
                            starSvg.classList.add('text-yellow-300');
                            starSvg.classList.remove('text-gray-300');
                        } else {
                            starSvg.classList.remove('text-yellow-400');
                            starSvg.classList.remove('text-yellow-300');
                            starSvg.classList.add('text-gray-300');
                        }
                    });
                }
                
                // Function for hover effect
                function hoverStars(rating) {
                    stars.forEach(star => {
                        const starRating = parseInt(star.dataset.rating);
                        const starSvg = star.querySelector('.star-svg');
                        
                        if (starRating <= rating) {
                            starSvg.classList.add('text-yellow-400');
                            starSvg.classList.remove('text-gray-300');
                        } else {
                            starSvg.classList.remove('text-yellow-400');
                            starSvg.classList.add('text-gray-300');
                        }
                    });
                }
            }
            
            // Image Upload JavaScript
            let uploadedImages = [];
            const maxImages = 5;
            
            function handleImageUpload(event) {
                const files = Array.from(event.target.files);
                
                // Validate file count
                if (uploadedImages.length + files.length > maxImages) {
                    alert(`You can only upload up to ${maxImages} images.`);
                    return;
                }
                
                // Validate file types and sizes
                const validFiles = files.filter(file => {
                    const isValidType = file.type.startsWith('image/');
                    const isValidSize = file.size <= 2 * 1024 * 1024; // 2MB
                    
                    if (!isValidType) {
                        alert(`${file.name} is not a valid image file.`);
                        return false;
                    }
                    
                    if (!isValidSize) {
                        alert(`${file.name} is too large. Please choose files smaller than 2MB.`);
                        return false;
                    }
                    
                    return true;
                });
                
                // Add valid files to uploadedImages array
                validFiles.forEach(file => {
                    uploadedImages.push(file);
                });
                
                // Update preview gallery
                updateImagePreview();
                
                // Update the file input with current files for form submission
                updateFileInput();
            }
            
            function updateImagePreview() {
                const gallery = document.getElementById('image-preview-gallery');
                
                if (uploadedImages.length === 0) {
                    gallery.classList.add('hidden');
                    gallery.classList.remove('grid', 'grid-cols-2', 'md:grid-cols-3', 'lg:grid-cols-5');
                    return;
                }
                
                gallery.classList.remove('hidden');
                gallery.classList.add('grid', 'grid-cols-2', 'md:grid-cols-3', 'lg:grid-cols-5');
                gallery.innerHTML = '';
                
                uploadedImages.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageDiv = document.createElement('div');
                        imageDiv.className = 'relative group';
                        imageDiv.innerHTML = `
                            <img src=\"${e.target.result}\" alt=\"Preview ${index + 1}\" class=\"w-full h-24 object-cover rounded-lg\">
                            <button type=\"button\" onclick=\"removeImage(${index})\" class=\"absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors\">
                                ×
                            </button>
                        `;
                        gallery.appendChild(imageDiv);
                    };
                    reader.readAsDataURL(file);
                });
            }
            
            function removeImage(index) {
                uploadedImages.splice(index, 1);
                updateImagePreview();
                updateFileInput();
            }
            
            function updateFileInput() {
                // Create a new DataTransfer object to update the file input
                const dt = new DataTransfer();
                
                // Add all current files to the DataTransfer object
                uploadedImages.forEach(file => {
                    dt.items.add(file);
                });
                
                // Update both file inputs with the new FileList
                const fileInput1 = document.getElementById('images');
                const fileInput2 = document.querySelector('input[name=\"images[]\"]');
                
                if (fileInput1) {
                    fileInput1.files = dt.files;
                }
                if (fileInput2 && fileInput2 !== fileInput1) {
                    fileInput2.files = dt.files;
                }
            }
            
            // Drag and drop functionality
            const uploadArea = document.getElementById('image-upload-area');
            if (uploadArea) {
                uploadArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    uploadArea.classList.add('border-purple-400', 'bg-purple-50');
                });
                
                uploadArea.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    uploadArea.classList.remove('border-purple-400', 'bg-purple-50');
                });
                
                uploadArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    uploadArea.classList.remove('border-purple-400', 'bg-purple-50');
                    
                    const files = Array.from(e.dataTransfer.files);
                    const imageFiles = files.filter(file => file.type.startsWith('image/'));
                    
                    if (imageFiles.length > 0) {
                        // Add files to our uploadedImages array
                        const validFiles = imageFiles.filter(file => {
                            const isValidType = file.type.startsWith('image/');
                            const isValidSize = file.size <= 2 * 1024 * 1024; // 2MB
                            
                            if (!isValidType) {
                                alert(`${file.name} is not a valid image file.`);
                                return false;
                            }
                            
                            if (!isValidSize) {
                                alert(`${file.name} is too large. Please choose files smaller than 2MB.`);
                                return false;
                            }
                            
                            return true;
                        });
                        
                        if (uploadedImages.length + validFiles.length > maxImages) {
                            alert(`You can only upload up to ${maxImages} images.`);
                            return;
                        }
                        
                        validFiles.forEach(file => {
                            uploadedImages.push(file);
                        });
                        
                        updateImagePreview();
                        updateFileInput();
                    }
                });
            }
            
            // Make functions global so they can be called from HTML
            window.handleImageUpload = handleImageUpload;
            window.removeImage = removeImage;
            
            // Helpful button functionality
            document.querySelectorAll('.helpful-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const reviewId = this.dataset.reviewId;
                    const isHelpful = this.dataset.isHelpful === 'true';
                    
                    fetch(`/reviews/${reviewId}/helpful`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    })
                    .then(async (response) => {
                        // If backend returned a redirect/html, treat as success fallback
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        const ct = response.headers.get('content-type') || '';
                        if (ct.includes('application/json')) {
                            return response.json();
                        }
                        // Fallback: reload to reflect state if no JSON
                        window.location.reload();
                        return { success: false };
                    })
                    .then(data => {
                        if (data.success) {
                            // Update button appearance
                            if (data.is_helpful) {
                                this.classList.add('bg-blue-100', 'text-blue-700', 'border-blue-300');
                                this.classList.remove('hover:bg-gray-100', 'hover:text-blue-700');
                                this.textContent = 'Helpful ✓';
                                this.dataset.isHelpful = 'true';
                            } else {
                                this.classList.remove('bg-blue-100', 'text-blue-700', 'border-blue-300');
                                this.classList.add('hover:bg-gray-100', 'hover:text-blue-700');
                                this.textContent = 'Helpful';
                                this.dataset.isHelpful = 'false';
                            }
                            
                            // Update helpful count
                            const helpfulCountElement = this.closest('div').querySelector('p');
                            if (helpfulCountElement) {
                                helpfulCountElement.textContent = `${data.helpful_count} people found this helpful`;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                });
            });

            // Report button functionality
            let currentReviewId = null;
            const reportModal = document.getElementById('reportModal');
            const reportForm = document.getElementById('reportForm');
            const cancelReport = document.getElementById('cancelReport');

            document.querySelectorAll('.report-btn').forEach(button => {
                button.addEventListener('click', function() {
                    currentReviewId = this.dataset.reviewId;
                    reportModal.classList.remove('hidden');
                });
            });

            cancelReport.addEventListener('click', function() {
                reportModal.classList.add('hidden');
                reportForm.reset();
            });

            // Close modal when clicking outside
            reportModal.addEventListener('click', function(e) {
                if (e.target === reportModal) {
                    reportModal.classList.add('hidden');
                    reportForm.reset();
                }
            });

            reportForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch(`/reviews/${currentReviewId}/report`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(async (response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    const ct = response.headers.get('content-type') || '';
                    if (ct.includes('application/json')) {
                        return response.json();
                    }
                    // Fallback non-JSON: assume success
                    return { success: true, message: 'Review reported successfully.' };
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        reportModal.classList.add('hidden');
                        reportForm.reset();
                        
                        // Disable the report button for this review
                        const reportBtn = document.querySelector(`[data-review-id="${currentReviewId}"].report-btn`);
                        reportBtn.textContent = 'Reported';
                        reportBtn.disabled = true;
                        reportBtn.classList.add('text-gray-400', 'cursor-not-allowed');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            });

            // Image Modal functionality
            let currentImageIndex = 0;
            let currentImages = [];
            
            function openImageModal(imageUrl, index, images) {
                currentImages = images;
                currentImageIndex = index;
                
                const modal = document.getElementById('imageModal');
                const mainImage = document.getElementById('modalMainImage');
                const thumbnails = document.getElementById('thumbnails');
                const imageCounter = document.getElementById('imageCounter');
                
                // Set main image
                mainImage.src = imageUrl;
                
                // Update counter
                imageCounter.textContent = `${index + 1} / ${images.length}`;
                
                // Create thumbnails
                thumbnails.innerHTML = '';
                images.forEach((img, idx) => {
                    const thumbnail = document.createElement('img');
                    thumbnail.src = img;
                    thumbnail.className = `w-16 h-16 object-cover rounded-lg cursor-pointer transition-all duration-200 ${idx === index ? 'ring-2 ring-white ring-offset-2 ring-offset-black opacity-100' : 'opacity-50 hover:opacity-80'}`;
                    thumbnail.onclick = () => switchImage(idx);
                    thumbnails.appendChild(thumbnail);
                });
                
                // Show/hide navigation arrows
                const prevBtn = document.getElementById('prevImage');
                const nextBtn = document.getElementById('nextImage');
                
                prevBtn.style.display = images.length > 1 ? 'flex' : 'none';
                nextBtn.style.display = images.length > 1 ? 'flex' : 'none';
                
                // Lock body scroll
                document.body.style.overflow = 'hidden';
                
                modal.classList.remove('hidden');
            }
            
            function switchImage(index) {
                currentImageIndex = index;
                const mainImage = document.getElementById('modalMainImage');
                const thumbnails = document.getElementById('thumbnails');
                const imageCounter = document.getElementById('imageCounter');
                
                // Fade effect
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = currentImages[index];
                    mainImage.style.opacity = '1';
                }, 150);
                
                // Update counter
                imageCounter.textContent = `${index + 1} / ${currentImages.length}`;
                
                // Update thumbnail selection
                Array.from(thumbnails.children).forEach((thumb, idx) => {
                    thumb.className = `w-16 h-16 object-cover rounded-lg cursor-pointer transition-all duration-200 ${idx === index ? 'ring-2 ring-white ring-offset-2 ring-offset-black opacity-100' : 'opacity-50 hover:opacity-80'}`;
                });
            }
            
            function nextImage() {
                if (currentImageIndex < currentImages.length - 1) {
                    switchImage(currentImageIndex + 1);
                } else {
                    // Loop to first image
                    switchImage(0);
                }
            }
            
            function prevImage() {
                if (currentImageIndex > 0) {
                    switchImage(currentImageIndex - 1);
                } else {
                    // Loop to last image
                    switchImage(currentImages.length - 1);
                }
            }
            
            function closeImageModal() {
                document.getElementById('imageModal').classList.add('hidden');
                document.body.style.overflow = '';
            }
            
            // Make image modal functions global
            window.openImageModal = openImageModal;
            window.switchImage = switchImage;
            window.closeImageModal = closeImageModal;
            
            // Modal event listeners
            document.getElementById('closeImageModal').addEventListener('click', closeImageModal);
            
            document.getElementById('nextImage').addEventListener('click', nextImage);
            document.getElementById('prevImage').addEventListener('click', prevImage);
            
            // Close modal when clicking on background (not on content)
            document.getElementById('imageModal').addEventListener('click', function(e) {
                if (e.target === this || e.target.classList.contains('bg-black/95')) {
                    closeImageModal();
                }
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                const modal = document.getElementById('imageModal');
                if (!modal.classList.contains('hidden')) {
                    if (e.key === 'Escape') {
                        closeImageModal();
                    } else if (e.key === 'ArrowLeft') {
                        prevImage();
                    } else if (e.key === 'ArrowRight') {
                        nextImage();
                    }
                }
            });
        });

        // Load similar books when page loads
        document.addEventListener('DOMContentLoaded', function() {
            if (window.RecommendationManager) {
                window.RecommendationManager.loadSimilarBooks({{ $book->id }}, 'similar-books-list', 6);
            }
        });
    </script>
@endsection
