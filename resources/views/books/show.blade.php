@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen bg-gray-50/50">
        <!-- Background Elements -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-200/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-indigo-200/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
        </div>

        <div class="relative container mx-auto px-4 py-8">
            <div class="mb-6">
                <a href="{{ route('books.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-purple-600 transition-colors group">
                    <span class="w-8 h-8 rounded-full bg-white/50 flex items-center justify-center mr-2 group-hover:bg-purple-100/50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </span>
                    Back to Shop
                </a>
            </div>

            {{-- Flash messages are now handled by JavaScript toast notifications --}}

            <!-- Main Content Grid -->
            <div class="lg:flex gap-8 items-start">
                
                <!-- Left Column: Book Cover (25%) -->
                <div class="lg:w-3/12 mb-8 lg:mb-0"> <!-- Decreased width -->
                    <div class="sticky top-24">
                        <div class="bg-white/60 backdrop-blur-xl rounded-[2rem] p-6 border border-white/60 shadow-lg">
                            <div class="relative group rounded-2xl shadow-xl overflow-hidden aspect-[2/3]">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 flex items-center justify-center">
                                        <svg class="h-20 w-20 text-purple-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Zoom Icon Overlay -->
                                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center pointer-events-none">
                                    <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Buttons Section -->
                            <div class="mt-6 space-y-3">
                                <div class="flex items-center justify-between mb-4 px-2">
                                    <div class="flex flex-col">
                                        @if($book->is_on_sale)
                                            <span class="text-2xl font-bold text-gray-900">RM {{ number_format($book->final_price, 0) }}</span>
                                            <span class="text-xs text-gray-400 line-through">RM {{ number_format($book->price, 0) }}</span>
                                        @else
                                            <span class="text-2xl font-bold text-gray-900">RM {{ number_format($book->price, 0) }}</span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $book->stock > 0 ? 'bg-green-100/50 text-green-700' : 'bg-red-100/50 text-red-700' }}">
                                            {{ $book->stock > 0 ? 'In Stock' : 'No Stock' }}
                                        </span>
                                    </div>
                                </div>

                                @if($book->stock > 0)
                                    <button 
                                        type="button" 
                                        class="ajax-add-to-cart w-full py-3.5 bg-gray-900 hover:bg-black text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center justify-center"
                                        data-book-id="{{ $book->id }}"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                @else
                                    <button type="button" class="w-full py-3.5 bg-white/50 text-gray-400 border border-gray-200 font-bold rounded-xl cursor-not-allowed" disabled>
                                        Out of Stock
                                    </button>
                                @endif
                                
                                @auth
                                    <button 
                                        type="button" 
                                        id="wishlist-button"
                                        class="wishlist-btn w-full py-3 {{ Auth::user()->hasBookInWishlist($book->id) ? 'bg-pink-50 text-pink-600 border-pink-200' : 'bg-white text-gray-700 border-gray-200' }} border font-bold rounded-xl hover:bg-gray-50 transition-all duration-300 flex items-center justify-center gap-2"
                                        data-book-id="{{ $book->id }}"
                                        data-in-wishlist="{{ Auth::user()->hasBookInWishlist($book->id) ? 'true' : 'false' }}"
                                    >
                                        @if(Auth::user()->hasBookInWishlist($book->id))
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-xs">Saved</span>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            <span class="text-xs">Wishlist</span>
                                        @endif
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Middle Column: Details (50%) -->
                <div class="lg:w-6/12 mb-8 lg:mb-0">
                    <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] p-8 lg:p-10 border border-white/60 shadow-sm h-full">
                         <!-- Badges Row -->
                         <div class="flex flex-wrap gap-2 mb-6">
                            @if(($book->condition ?? 'new') === 'preloved')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-amber-100/80 text-amber-800 border border-amber-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Preloved
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-green-100/80 text-green-800 border border-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Brand New
                                </span>
                            @endif
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-purple-100/80 text-purple-800 border border-purple-200">
                                {{ $book->genre->name }}
                            </span>
                        </div>

                        <h1 class="text-4xl lg:text-5xl font-bold font-serif text-slate-900 leading-tight mb-3">{{ $book->title }}</h1>
                        <p class="text-lg text-slate-500 mb-8 font-medium">by <a href="{{ route('books.index', ['author' => $book->author]) }}" class="text-purple-600 hover:text-purple-800 transition-colors border-b border-purple-200 hover:border-purple-600">{{ $book->author }}</a></p>

                        <!-- Tropes -->
                        @if($book->tropes->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-8">
                                @foreach($book->tropes as $trope)
                                    <a href="{{ route('books.index', ['trope' => $trope->id]) }}" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-white/50 border border-gray-200 text-gray-600 hover:bg-white hover:text-purple-600 hover:border-purple-200 transition-all shadow-sm">
                                        #{{ $trope->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-10">
                            <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
                                <span class="w-1 h-6 bg-purple-400 rounded-full mr-3"></span>
                                Synopsis
                            </h2>
                            <div class="relative group">
                                <div id="synopsis-content" class="prose prose-purple prose-lg text-slate-600 leading-relaxed max-h-60 overflow-hidden transition-all duration-500 ease-in-out">
                                    <p>{{ $book->synopsis }}</p>
                                </div>
                                <div id="synopsis-fade" class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-white/90 via-white/50 to-transparent pointer-events-none group-hover:via-white/30 transition-all"></div>
                                <button id="toggle-synopsis" class="text-purple-600 hover:text-purple-900 font-bold mt-4 text-sm uppercase tracking-wide flex items-center bg-purple-50 px-4 py-2 rounded-lg hover:bg-purple-100 transition-colors w-fit">
                                    Read Full Synopsis
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="bg-gray-50/50 rounded-2xl p-8 border border-gray-100">
                            <h2 class="text-lg font-bold text-slate-900 mb-6">Product Details</h2>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                                <div class="pb-4 border-b border-gray-100">
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Title</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $book->title }}</dd>
                                </div>
                                <div class="pb-4 border-b border-gray-100">
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Author</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $book->author }}</dd>
                                </div>
                                 <div class="pb-4 border-b border-gray-100">
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">ISBN / Code</dt>
                                    <dd class="text-sm font-medium text-gray-900 text-gray-400 italic">N/A</dd>
                                </div>
                                 <div class="pb-4 border-b border-gray-100">
                                    <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Format</dt>
                                    <dd class="text-sm font-medium text-gray-900">Physical Book</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Similar Books Sidebar (25%) -->
                 <div class="lg:w-3/12">
                    <div class="sticky top-24">
                         <div class="bg-white/60 backdrop-blur-xl rounded-[2rem] p-6 border border-white/60 shadow-lg">
                            <h3 class="text-lg font-bold font-serif text-slate-900 mb-6 flex items-center">
                                Similar Books
                            </h3>
                            
                            @if($relatedBooks->count() > 0)
                                <div class="space-y-5">
                                    @foreach($relatedBooks->take(3) as $related)
                                        <a href="{{ route('books.show', $related) }}" class="group flex gap-4 items-start p-3 rounded-xl hover:bg-white/50 transition-colors border border-transparent hover:border-white/50">
                                            <div class="w-16 flex-shrink-0 aspect-[2/3] rounded-lg overflow-hidden shadow-sm relative">
                                                @if($related->cover_image)
                                                    <img src="{{ asset('storage/' . $related->cover_image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-gray-200"></div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0 pt-0.5">
                                                <h4 class="text-sm font-bold text-slate-900 leading-tight line-clamp-2 group-hover:text-purple-600 transition-colors mb-1">{{ $related->title }}</h4>
                                                <p class="text-xs text-slate-500 mb-2 truncate">{{ $related->author }}</p>
                                                <p class="text-sm font-bold text-purple-600">RM {{ number_format($related->final_price, 0) }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-gray-200/50">
                                    <a href="{{ route('books.index') }}" class="block w-full py-3 text-center text-xs font-bold uppercase tracking-widest text-purple-600 border border-purple-200 rounded-xl hover:bg-purple-600 hover:text-white transition-all shadow-sm">
                                        View Collection
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 text-center py-4">No similar books found.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            


        </div>

        <!-- Customer Reviews (Restored section) -->
        <div class="mt-12 p-8 lg:p-12 bg-white/60 backdrop-blur-xl rounded-[2.5rem] border border-white/60 shadow-sm relative overflow-hidden">
             <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-purple-200/20 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>

            <div class="max-w-screen-xl mx-auto relative z-10">
                <div class="flex max-lg:flex-col gap-12">
                    <!-- Left Sidebar - Review Statistics -->
                    <div class="max-w-sm w-full">
                        <div>
                            <h2 class="text-3xl font-bold font-serif text-slate-900 mb-2">Customer Reviews</h2>
                            <div class="flex items-center gap-3 mb-1">
                                <div class="flex items-center gap-1 text-purple-500">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $reviewStats['average'])
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current drop-shadow-sm" viewBox="0 0 24 24">
                                                <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-100 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-slate-900 font-bold text-lg">{{ $reviewStats['average'] }} / 5</p>
                            </div>
                            <p class="text-slate-500 text-sm font-medium">Based on {{ $reviewStats['total'] }} reviews</p>
                        </div>
                        
                        <!-- Rating Breakdown -->
                        <div class="space-y-3 mt-8">
                            @for ($rating = 5; $rating >= 1; $rating--)
                                <div class="flex items-center group">
                                    <div class="min-w-[30px]">
                                        <p class="text-sm font-bold text-slate-700">{{ $rating }} <span class="text-purple-300 text-xs">★</span></p>
                                    </div>
                                    <div class="bg-gray-100 rounded-full w-full h-2.5 mx-3 overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r from-purple-600 to-indigo-500 opacity-80 group-hover:opacity-100 transition-all duration-500" style="width: {{ $reviewStats['percentages'][$rating] }}%"></div>
                                    </div>
                                    <div class="min-w-[40px] text-right">
                                        <p class="text-xs font-bold text-slate-500">{{ $reviewStats['percentages'][$rating] }}%</p>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div class="my-8 h-px bg-gradient-to-r from-transparent via-purple-200 to-transparent"></div>

                        <!-- Write Review Section -->
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">Review this product</h3>
                            <p class="text-slate-500 text-sm mb-6">Share your thoughts with other book lovers</p>
                            @auth
                                @if($canReview && !$hasReviewed && $orderItem)
                                    <button type="button" id="writeReviewBtn" class="w-full py-3.5 bg-gray-900 hover:bg-black text-white text-sm font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center justify-center">
                                        Write a customer review
                                    </button>
                                @elseif($hasReviewed)
                                    <div class="p-4 bg-green-50/50 border border-green-100 text-green-800 rounded-xl text-sm font-medium flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        You've reviewed this book
                                    </div>
                                @else
                                    <div class="p-4 bg-gray-50/50 border border-gray-100 text-gray-500 rounded-xl text-sm text-center italic">
                                        Only Verified Buyers can review
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full py-3.5 bg-white text-gray-900 border border-gray-200 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 text-center transition-all shadow-sm">
                                    Sign in to write a review
                                </a>
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
                            <div class="group mb-10">
                                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Photo Gallery
                                </h3>
                                <div class="relative">
                                    <!-- Gallery Container -->
                                    <div id="review-gallery" class="flex items-center gap-4 overflow-x-auto pb-6 scrollbar-thin scrollbar-thumb-purple-200 scrollbar-track-transparent px-1">
                                        @php $imageIndex = 0; @endphp
                                        @foreach($reviewsWithImages as $reviewWithImage)
                                            @foreach($reviewWithImage->image_urls as $imageUrl)
                                                <div class="relative shrink-0 group/img">
                                                    <img src="{{ $imageUrl }}" 
                                                         class="object-cover w-32 h-32 md:w-40 md:h-40 rounded-2xl shadow-md border-2 border-white cursor-pointer hover:scale-105 transition-all duration-300" 
                                                         alt="customer-review-image" 
                                                         onclick="openImageModal('{{ $imageUrl }}', {{ $imageIndex }}, {!! json_encode($allReviewImages) !!})" />
                                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover/img:opacity-100 rounded-2xl transition-opacity pointer-events-none"></div>
                                                </div>
                                                @php $imageIndex++; @endphp
                                            @endforeach
                                        @endforeach
                                    </div>
                                    
                                    <!-- Gallery Navigation Buttons -->
                                    @if($totalImages > 4)
                                        <button id="gallery-prev" class="absolute left-0 top-1/2 -translate-y-1/2 -ml-2 bg-white/90 hover:bg-white shadow-lg rounded-full p-2 z-10 opacity-0 group-hover:opacity-100 transition-all text-purple-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        </button>
                                        <button id="gallery-next" class="absolute right-0 top-1/2 -translate-y-1/2 -mr-2 bg-white/90 hover:bg-white shadow-lg rounded-full p-2 z-10 opacity-0 group-hover:opacity-100 transition-all text-purple-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Individual Reviews -->
                        <div class="space-y-6">
                            @forelse($reviews as $review)
                                <div class="bg-white/40 backdrop-blur-md rounded-3xl p-6 border border-white/60 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="shrink-0">
                                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-indigo-500 flex items-center justify-center text-white font-bold text-lg shadow-inner ring-2 ring-white">
                                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-slate-900 font-bold">{{ $review->user->name }}</p>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-green-700 bg-green-100/50 px-2 py-0.5 rounded-full">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                        Verified Buyer
                                                    </span>
                                                    <span class="text-xs text-slate-400">• {{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                         <div class="flex items-center gap-1 text-purple-400 mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 24 24">
                                                    <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        
                                        @if($review->comment)
                                            <div class="prose prose-purple prose-sm text-slate-600 leading-relaxed">
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Review Images -->
                                    @if($review->hasImages())
                                        <div class="flex items-center gap-3 mt-4 overflow-x-auto pb-2">
                                            @foreach($review->image_urls as $index => $imageUrl)
                                                <img src="{{ $imageUrl }}" 
                                                     class="bg-gray-100 object-cover w-20 h-20 rounded-xl cursor-pointer hover:opacity-90 hover:scale-105 transition-all border border-gray-100" 
                                                     alt="review-img" 
                                                     onclick="openImageModal('{{ $imageUrl }}', {{ $index }}, {{ json_encode($review->image_urls) }})" />
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <!-- Review Actions -->
                                    <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                                        <p class="text-xs font-medium text-slate-400">{{ $review->helpful_count }} people found this helpful</p>
                                        <div class="flex items-center gap-4">
                                            @auth
                                                <button type="button" 
                                                        class="helpful-btn group flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg transition-all {{ $review->isMarkedHelpfulBy(Auth::id()) ? 'bg-purple-100 text-purple-700' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}"
                                                        data-review-id="{{ $review->id }}"
                                                        data-is-helpful="{{ $review->isMarkedHelpfulBy(Auth::id()) ? 'true' : 'false' }}">
                                                    <svg class="w-4 h-4 {{ $review->isMarkedHelpfulBy(Auth::id()) ? 'fill-current' : 'group-hover:scale-110 transition-transform' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                                    {{ $review->isMarkedHelpfulBy(Auth::id()) ? 'Helpful' : 'Helpful?' }}
                                                </button>
                                                <button type="button" 
                                                        class="report-btn text-xs font-medium text-gray-400 hover:text-red-500 transition-colors"
                                                        data-review-id="{{ $review->id }}">
                                                    Report
                                                </button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center bg-gray-50/50 rounded-3xl border border-dashed border-gray-200">
                                    <div class="w-16 h-16 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4 text-purple-200">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </div>
                                    <p class="text-slate-900 font-bold">No reviews yet</p>
                                    <p class="text-slate-500 text-sm mt-1">Be the first to share your thoughts on this book!</p>
                                </div>
                            @endforelse
                            
                            <!-- Pagination -->
                            @if($reviews->hasPages())
                                <div class="pt-6">
                                    {{ $reviews->links('pagination::tailwind') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Write Review Modal -->
        @auth
            @if($canReview && !$hasReviewed && $orderItem)
                <div id="reviewModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
                    <div class="relative top-20 mx-auto p-8 border border-white/20 w-full max-w-2xl shadow-2xl rounded-[2rem] bg-white/90 backdrop-blur-xl">
                        <div class="mt-2">
                             <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-bold font-serif text-slate-900">Write a Review</h3>
                                <button type="button" id="closeReviewModal" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('books.reviews.store', $book) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order_item_id" value="{{ $orderItem->id }}">
                                
                                <div class="mb-6">
                                    <label for="rating" class="block text-sm font-bold text-slate-700 mb-2">Rating</label>
                                    <div class="flex items-center space-x-2 star-rating bg-gray-50 inline-flex p-2 rounded-xl border border-gray-100">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="cursor-pointer star-rating-item transition-transform hover:scale-110" data-rating="{{ $i }}">
                                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only star-input" required {{ old('rating') == $i ? 'checked' : '' }}>
                                                <svg class="w-8 h-8 text-gray-300 star-svg transition-colors duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                                </svg>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="comment" class="block text-sm font-bold text-slate-700 mb-2">Your Review</label>
                                    <textarea name="comment" id="comment" rows="4" class="w-full bg-gray-50 border-gray-200 rounded-xl shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 transition-all font-medium text-slate-700" placeholder="Share your experience with this book...">{{ old('comment') }}</textarea>
                                </div>
                                
                                <!-- Image Upload Section -->
                                <div class="mb-6">
                                    <label for="images" class="block text-sm font-bold text-slate-700 mb-2">Add Photos (Optional)</label>
                                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-purple-400 hover:bg-purple-50/30 transition-all duration-300 group cursor-pointer" id="image-upload-area">
                                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden" onchange="handleImageUpload(event)">
                                        <div class="space-y-3">
                                            <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center mx-auto text-purple-400 group-hover:text-purple-600 group-hover:scale-110 transition-all">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                <span class="font-bold text-purple-600 hover:text-purple-500">Click to upload</span>
                                                <span class="pl-1">or drag and drop</span>
                                            </div>
                                            <p class="text-xs text-gray-400">PNG, JPG, GIF up to 2MB each (max 5 photos)</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Preview Gallery -->
                                    <div id="image-preview-gallery" class="mt-4 grid grid-cols-4 gap-4 hidden">
                                        <!-- Preview images will be inserted here -->
                                    </div>
                                </div>
                                
                                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                                    <button type="button" id="cancelReview" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-6 py-3 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-black shadow-lg hover:shadow-xl transition-all flex items-center">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
        
        <!-- You May Also Like -->
        @if($relatedBooks->count() > 3)
            <div class="mt-12">
                 <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold font-serif text-slate-900">You May Also Like</h2>
                     <a href="{{ route('books.index') }}" class="text-sm font-bold text-purple-600 hover:text-purple-800 flex items-center group">
                        Full Catalog
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedBooks->skip(3)->take(4) as $book)
                         <x-book-card :book="$book" />
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
                        <select id="reason" name="reason" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
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
                        <textarea id="description" name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" placeholder="Please provide more details about why you're reporting this review..."></textarea>
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

    <!-- Image Gallery Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-0 mx-auto p-5 w-full h-full flex items-center justify-center">
            <div class="relative bg-white rounded-lg shadow-lg max-w-4xl max-h-full w-full h-full flex flex-col">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Review Photos</h3>
                    <button type="button" id="closeImageModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="flex-1 flex items-center justify-center p-4">
                    <div class="relative w-full h-full flex items-center justify-center">
                        <!-- Main Image -->
                        <img id="modalMainImage" src="" alt="Review image" class="max-w-full max-h-full object-contain">
                        
                        <!-- Navigation Arrows -->
                        <button id="prevImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        
                        <button id="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Thumbnail Navigation -->
                <div id="thumbnailContainer" class="p-4 border-t border-gray-200">
                    <div id="thumbnails" class="flex space-x-2 overflow-x-auto">
                        <!-- Thumbnails will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image View Modal -->
    <div id="imageModal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/95 backdrop-blur-lg transition-opacity duration-300"></div>
    
        <!-- Modal Container - Full Width -->
        <div class="fixed inset-0 z-10 flex flex-col">
            
            <!-- Header Bar -->
            <div class="flex justify-between items-center px-6 py-4 bg-gradient-to-b from-black/60 to-transparent z-30">
                <h3 class="text-white/70 text-xs font-medium tracking-widest uppercase">Preview Mode</h3>
                <button type="button" id="closeImageModal" class="rounded-full bg-black/40 p-2.5 text-white hover:bg-white hover:text-black focus:outline-none transition-all duration-200 border border-white/10 backdrop-blur-sm group">
                    <svg class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Image Area with Side Navigation -->
            <div class="flex-1 flex items-center justify-between px-4 sm:px-8 relative">
                
                <!-- Left Arrow -->
                <button id="prevImage" class="shrink-0 z-30 rounded-full bg-white/90 p-4 text-gray-800 hover:bg-white hover:scale-110 shadow-2xl transition-all duration-200 border border-gray-200">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                
                <!-- Center Image Container -->
                <div class="flex-1 flex items-center justify-center px-4 sm:px-8 h-full relative">
                    <!-- Main Image -->
                    <img id="modalMainImage" src="" alt="Preview" class="max-w-full max-h-[80vh] object-contain transition-all duration-300 opacity-0 scale-95 shadow-2xl">
                    
                    <!-- Loading Spinner -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <svg class="animate-spin h-10 w-10 text-white/30" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Right Arrow -->
                <button id="nextImage" class="shrink-0 z-30 rounded-full bg-white/90 p-4 text-gray-800 hover:bg-white hover:scale-110 shadow-2xl transition-all duration-200 border border-gray-200">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

            <!-- Bottom Bar with Thumbnails (Compact) -->
            <div class="bg-black/40 backdrop-blur-sm border-t border-white/5 py-3 px-6 z-20">
                <div class="flex items-center justify-between">
                    <!-- Thumbnails -->
                    <div id="thumbnails" class="flex gap-2 overflow-x-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-white/20 py-1">
                        <!-- Injected via JS -->
                    </div>
                    
                    <!-- Right Controls -->
                    <div class="flex gap-2 ml-4 shrink-0">
                        <button class="rounded-lg bg-white/10 p-2 text-white/60 hover:bg-white/20 hover:text-white transition-all duration-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <rect x="14" y="3" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <rect x="3" y="14" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <rect x="14" y="14" width="7" height="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        
                        <button id="fullscreenToggle" class="rounded-lg bg-white/10 p-2 text-white/60 hover:bg-white/20 hover:text-white transition-all duration-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                        </button>
                    </div>
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

            // Image Modal functionality - Cinematic Design
            let currentImageIndex = 0;
            let currentImages = [];
            
            // Expose to global scope for onclick attributes
            window.openImageModal = function(imageUrl, index, images) {
                currentImages = images;
                currentImageIndex = index;
                
                const modal = document.getElementById('imageModal');
                
                // Show modal
                modal.classList.remove('hidden');
                
                // Prevent body scroll
                document.body.style.overflow = 'hidden';
                
                // Initialize thumbnails
                initThumbnails();
                
                // Small delay for entrance animation, then set image
                setTimeout(() => {
                    setImage(index);
                }, 50);
            }
            
            function initThumbnails() {
                const thumbsContainer = document.getElementById('thumbnails');
                thumbsContainer.innerHTML = '';
                
                currentImages.forEach((src, index) => {
                    const btn = document.createElement('button');
                    btn.className = "relative shrink-0 rounded overflow-hidden border-2 transition-all";
                    btn.style.width = "50px";
                    btn.style.height = "50px";
                    btn.onclick = () => setImage(index);
                    
                    const img = document.createElement('img');
                    img.src = src;
                    img.className = "h-full w-full object-cover";
                    
                    btn.appendChild(img);
                    thumbsContainer.appendChild(btn);
                });
            }
            
            function setImage(index) {
                currentImageIndex = index;
                const mainImg = document.getElementById('modalMainImage');
                
                // Fade out effect with scale
                mainImg.style.opacity = '0.5';
                mainImg.classList.remove('scale-100');
                mainImg.classList.add('scale-95');
                
                // Small delay to allow fade out
                setTimeout(() => {
                    mainImg.src = currentImages[index];
                    
                    // When image loads, fade in with scale
                    mainImg.onload = () => {
                        mainImg.style.opacity = '1';
                        mainImg.classList.remove('scale-95');
                        mainImg.classList.add('scale-100');
                    };
                }, 200);

                updateThumbnails();
            }
            
            function updateThumbnails() {
                const thumbsContainer = document.getElementById('thumbnails');
                const thumbs = thumbsContainer.children;
                
                Array.from(thumbs).forEach((thumb, i) => {
                    if (i === currentImageIndex) {
                        // Active: Bright border
                        thumb.className = "relative shrink-0 rounded overflow-hidden border-2 border-indigo-500 transition-all";
                        thumb.style.width = "50px";
                        thumb.style.height = "50px";
                        
                        // Center the active thumbnail
                        thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                    } else {
                        // Inactive: Subtle border
                        thumb.className = "relative shrink-0 rounded overflow-hidden border-2 border-white/20 hover:border-white/50 transition-all opacity-70 hover:opacity-100";
                        thumb.style.width = "50px";
                        thumb.style.height = "50px";
                    }
                });
            }
            
            function nextImage() {
                let nextIndex = currentImageIndex + 1;
                if (nextIndex >= currentImages.length) nextIndex = 0;
                setImage(nextIndex);
            }
            
            function prevImage() {
                let prevIndex = currentImageIndex - 1;
                if (prevIndex < 0) prevIndex = currentImages.length - 1;
                setImage(prevIndex);
            }
            
            function closeModal() {
                const modal = document.getElementById('imageModal');
                const mainImg = document.getElementById('modalMainImage');
                
                modal.classList.add('hidden');
                
                // Restore body scroll
                document.body.style.overflow = 'auto';
                
                // Reset image state
                mainImg.style.opacity = '0';
                mainImg.classList.remove('scale-100');
                mainImg.classList.add('scale-95');
            }
            
            // Modal event listeners
            document.getElementById('closeImageModal').addEventListener('click', function() {
                closeModal();
            });
            
            document.getElementById('nextImage').addEventListener('click', nextImage);
            document.getElementById('prevImage').addEventListener('click', prevImage);
            
            // Fullscreen toggle
            document.getElementById('fullscreenToggle').addEventListener('click', function() {
                const modal = document.getElementById('imageModal');
                
                if (!document.fullscreenElement) {
                    // Enter fullscreen
                    if (modal.requestFullscreen) {
                        modal.requestFullscreen();
                    } else if (modal.webkitRequestFullscreen) {
                        modal.webkitRequestFullscreen();
                    } else if (modal.msRequestFullscreen) {
                        modal.msRequestFullscreen();
                    }
                } else {
                    // Exit fullscreen
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                }
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                const modal = document.getElementById('imageModal');
                if (!modal.classList.contains('hidden')) {
                    if (e.key === 'Escape') {
                        closeModal();
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
