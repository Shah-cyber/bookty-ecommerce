@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('books.index') }}" class="text-purple-600 hover:text-purple-900">
                &larr; Back to Books
            </a>
        </div>

        {{-- Flash messages are now handled by JavaScript toast notifications --}}

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="lg:flex">
                <!-- Book Cover -->
                <div class="lg:w-1/4 p-6">
                    <div class="sticky top-6">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-full h-96 bg-gray-200 rounded-lg shadow-md flex items-center justify-center">
                                <svg class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        <div class="mt-6">
                            <div class="flex items-center mb-4">
                                @if($book->is_on_sale)
                                    <div class="flex items-center">
                                        <span class="text-2xl font-bold text-purple-600">RM {{ number_format($book->final_price, 2) }}</span>
                                        <span class="ml-3 text-lg text-gray-500 line-through">RM {{ number_format($book->price, 2) }}</span>
                                        <span class="ml-3 text-sm bg-red-100 text-red-800 px-2 py-1 rounded-md">-{{ $book->discount_percent }}%</span>
                                    </div>
                                @else
                                    <span class="text-2xl font-bold text-purple-600">RM {{ number_format($book->price, 2) }}</span>
                                @endif
                                <span class="ml-2 text-sm {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $book->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>

                            <div class="flex flex-col space-y-4">
                                @if($book->stock > 0)
                                    <button 
                                        type="button" 
                                        class="ajax-add-to-cart w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                                        data-book-id="{{ $book->id }}"
                                    >
                                        Add to Cart
                                    </button>
                                @else
                                    <button type="button" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md opacity-50 cursor-not-allowed" disabled>
                                        Out of Stock
                                    </button>
                                @endif
                                
                                @auth
                                    <button 
                                        type="button" 
                                        id="wishlist-button"
                                        class="wishlist-btn w-full px-4 py-2 {{ Auth::user()->hasBookInWishlist($book->id) ? 'bg-pink-100 text-pink-700 border border-pink-300 hover:bg-pink-200' : 'bg-gray-100 text-gray-700 border border-gray-300 hover:bg-gray-200' }} rounded-md flex items-center justify-center gap-2"
                                        data-book-id="{{ $book->id }}"
                                        data-in-wishlist="{{ Auth::user()->hasBookInWishlist($book->id) ? 'true' : 'false' }}"
                                    >
                                        @if(Auth::user()->hasBookInWishlist($book->id))
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Remove from Wishlist</span>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            <span>Add to Wishlist</span>
                                        @endif
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="w-full px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-200 flex items-center justify-center gap-2 text-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Sign in to Save
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book Details -->
                <div class="lg:w-1/2 p-8 border-t lg:border-t-0 lg:border-l border-gray-200">
                    <h1 class="text-4xl font-bold font-serif text-slate-900 !leading-tight mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-slate-500 mb-6">by <a href="#" class="hover:underline">{{ $book->author }}</a></p>

                    <div class="flex flex-wrap gap-2 mb-8">
                        <!-- Condition Badge -->
                        @if(($book->condition ?? 'new') === 'preloved')
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-amber-100 text-amber-800 hover:bg-amber-200 transition-colors border border-amber-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Preloved
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition-colors border border-green-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                New
                            </span>
                        @endif
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-purple-100 text-purple-800 hover:bg-purple-200 transition-colors">
                            {{ $book->genre->name }}
                        </span>
                        @foreach($book->tropes as $trope)
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                                {{ $trope->name }}
                            </span>
                        @endforeach
                    </div>

                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Synopsis</h2>
                        <div class="relative">
                            <div id="synopsis-content" class="prose max-w-none text-slate-600 text-base leading-relaxed max-h-28 overflow-hidden transition-all duration-500 ease-in-out">
                                <p>{{ $book->synopsis }}</p>
                            </div>
                            <div id="synopsis-fade" class="absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
                            <button id="toggle-synopsis" class="text-purple-600 hover:text-purple-800 font-semibold mt-2 text-sm">Read More</button>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Book Details</h2>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="border-b border-gray-100 pb-3">
                                <dt class="text-sm font-medium text-slate-500">Title</dt>
                                <dd class="mt-1 text-base text-slate-900">{{ $book->title }}</dd>
                            </div>
                            <div class="border-b border-gray-100 pb-3">
                                <dt class="text-sm font-medium text-slate-500">Author</dt>
                                <dd class="mt-1 text-base text-slate-900">{{ $book->author }}</dd>
                            </div>
                            <div class="border-b border-gray-100 pb-3">
                                <dt class="text-sm font-medium text-slate-500">Condition</dt>
                                <dd class="mt-1 text-base text-slate-900">
                                    @if(($book->condition ?? 'new') === 'preloved')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Preloved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            New
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div class="border-b border-gray-100 pb-3">
                                <dt class="text-sm font-medium text-slate-500">Genre</dt>
                                <dd class="mt-1 text-base text-slate-900">{{ $book->genre->name }}</dd>
                            </div>
                            <div class="border-b border-gray-100 pb-3">
                                <dt class="text-sm font-medium text-slate-500">Tropes</dt>
                                <dd class="mt-1 text-base text-slate-900">
                                    {{ $book->tropes->pluck('name')->join(', ') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Similar Books Sidebar -->
                <div class="lg:w-1/4 p-6 border-t lg:border-t-0 lg:border-l border-gray-200 bg-gray-50">
                    <div class="sticky top-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Similar Books
                        </h3>
                        
                        <div id="similar-books-list" class="space-y-4">
                            <!-- Loading state -->
                            <div class="text-center py-8">
                                <div class="inline-flex items-center px-3 py-2 bg-white rounded-lg shadow-sm">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">Loading...</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- View More Button -->
                        <div class="mt-6">
                            <a href="{{ route('books.index') }}" class="block w-full text-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                View All Books
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reviews -->
        <div class="mt-12 p-6">
            <div class="max-w-screen-xl mx-auto">
                <div class="flex max-lg:flex-col gap-12">
                    <!-- Left Sidebar - Review Statistics -->
                    <div class="max-w-sm w-full">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 !leading-tight mb-2">Customer reviews</h2>
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-0.5 text-orange-500">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $reviewStats['average'])
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] fill-current" viewBox="0 0 24 24">
                                                <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z" />
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
                        <div class="divide-y divide-gray-300 {{ $reviewsWithImages->count() > 0 ? 'mt-8' : '' }}">
                            @forelse($reviews as $review)
                                <div class="py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="shrink-0">
                                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-semibold border-2 border-gray-400">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm text-slate-900 font-semibold">{{ $review->user->name }}</p>
                                            <div class="flex items-center gap-2 mt-2">
                                                <span class="w-4 h-4 flex items-center justify-center rounded-full bg-green-600/20">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2 fill-green-700" viewBox="0 0 24 24">
                                                        <path d="M9.225 20.656a1.206 1.206 0 0 1-1.71 0L.683 13.823a1.815 1.815 0 0 1 0-2.566l.855-.856a1.815 1.815 0 0 1 2.567 0l4.265 4.266L19.895 3.14a1.815 1.815 0 0 1 2.567 0l.855.856a1.815 1.815 0 0 1 0 2.566z" />
                                                    </svg>
                                                </span>
                                                <p class="text-slate-600 text-xs">Verified Buyer</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h6 class="text-slate-900 text-[15px] font-semibold">{{ $review->title ?? 'Customer Review' }}</h6>
                                        <div class="flex items-center space-x-0.5 text-orange-500 mt-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] fill-current" viewBox="0 0 24 24">
                                                        <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] text-gray-300 fill-current" viewBox="0 0 24 24">
                                                        <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                            <p class="text-slate-600 text-sm !ml-2">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if($review->comment)
                                            <div class="mt-4">
                                                <p class="text-slate-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Review Images -->
                                    @if($review->hasImages())
                                        <div class="flex items-center gap-4 mt-4 overflow-auto">
                                            @foreach($review->image_urls as $index => $imageUrl)
                                                <img src="{{ $imageUrl }}" 
                                                     class="bg-gray-100 object-cover p-2 w-48 h-48 cursor-pointer hover:opacity-90 transition-opacity" 
                                                     alt="review-img-{{ $index + 1 }}" 
                                                     onclick="openImageModal('{{ $imageUrl }}', {{ $index }}, {{ json_encode($review->image_urls) }})" />
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <!-- Review Actions -->
                                    <div class="mt-4">
                                        <p class="text-xs text-gray-500 mb-2">{{ $review->helpful_count }} people found this helpful</p>
                                        <div class="flex items-center gap-4">
                                            @auth
                                                <button type="button" 
                                                        class="helpful-btn px-3 py-1.5 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 {{ $review->isMarkedHelpfulBy(Auth::id()) ? 'bg-blue-100 text-blue-700 border-blue-300' : '' }}"
                                                        data-review-id="{{ $review->id }}"
                                                        data-is-helpful="{{ $review->isMarkedHelpfulBy(Auth::id()) ? 'true' : 'false' }}">
                                                    {{ $review->isMarkedHelpfulBy(Auth::id()) ? 'Helpful ✓' : 'Helpful' }}
                                                </button>
                                                <button type="button" 
                                                        class="report-btn text-sm font-medium text-blue-600 hover:underline"
                                                        data-review-id="{{ $review->id }}">
                                                    Report abuse
                                                </button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-6 text-center">
                                    <p class="text-gray-500">No reviews yet. Be the first to review this book!</p>
                                </div>
                            @endforelse
                            
                            @if($reviews->hasPages())
                                <div class="py-6">
                                    <ul class="flex space-x-4 justify-end">
                                        {{-- Previous Page Link --}}
                                        @if ($reviews->onFirstPage())
                                            <li class="flex items-center justify-center shrink-0 bg-gray-100 w-9 h-9 rounded-full cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-300" viewBox="0 0 55.753 55.753">
                                                    <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                                                </svg>
                                            </li>
                                        @else
                                            <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer w-9 h-9 rounded-full">
                                                <a href="{{ $reviews->previousPageUrl() }}" class="flex items-center justify-center w-full h-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-400" viewBox="0 0 55.753 55.753">
                                                        <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $start = max(1, $reviews->currentPage() - 2);
                                            $end = min($reviews->lastPage(), $reviews->currentPage() + 2);
                                        @endphp

                                        {{-- First page --}}
                                        @if($start > 1)
                                            <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer text-[15px] font-medium text-slate-900 w-9 h-9 rounded-full">
                                                <a href="{{ $reviews->url(1) }}" class="flex items-center justify-center w-full h-full">1</a>
                                            </li>
                                            @if($start > 2)
                                                <li class="flex items-center justify-center shrink-0 text-[15px] font-medium text-slate-900 w-9 h-9">
                                                    <span>...</span>
                                                </li>
                                            @endif
                                        @endif

                                        {{-- Page numbers around current page --}}
                                        @for ($page = $start; $page <= $end; $page++)
                                            @if ($page == $reviews->currentPage())
                                                <li class="flex items-center justify-center shrink-0 bg-blue-500 border-2 border-blue-500 cursor-pointer text-[15px] font-medium text-white w-9 h-9 rounded-full">
                                                    {{ $page }}
                                                </li>
                                            @else
                                                <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer text-[15px] font-medium text-slate-900 w-9 h-9 rounded-full">
                                                    <a href="{{ $reviews->url($page) }}" class="flex items-center justify-center w-full h-full">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        {{-- Last page --}}
                                        @if($end < $reviews->lastPage())
                                            @if($end < $reviews->lastPage() - 1)
                                                <li class="flex items-center justify-center shrink-0 text-[15px] font-medium text-slate-900 w-9 h-9">
                                                    <span>...</span>
                                                </li>
                                            @endif
                                            <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer text-[15px] font-medium text-slate-900 w-9 h-9 rounded-full">
                                                <a href="{{ $reviews->url($reviews->lastPage()) }}" class="flex items-center justify-center w-full h-full">{{ $reviews->lastPage() }}</a>
                                            </li>
                                        @endif

                                        {{-- Next Page Link --}}
                                        @if ($reviews->hasMorePages())
                                            <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer w-9 h-9 rounded-full">
                                                <a href="{{ $reviews->nextPageUrl() }}" class="flex items-center justify-center w-full h-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-400 rotate-180" viewBox="0 0 55.753 55.753">
                                                        <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                                                    </svg>
                                                </a>
                                            </li>
                                        @else
                                            <li class="flex items-center justify-center shrink-0 bg-gray-100 w-9 h-9 rounded-full cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-300 rotate-180" viewBox="0 0 55.753 55.753">
                                                    <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                                                </svg>
                                            </li>
                                        @endif
                                    </ul>
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
                                    <textarea name="comment" id="comment" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" placeholder="Share your experience with this book...">{{ old('comment') }}</textarea>
                                </div>
                                
                                <!-- Image Upload Section -->
                                <div class="mb-4">
                                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Add Photos (Optional)</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-400 transition-colors duration-200" id="image-upload-area">
                                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden" onchange="handleImageUpload(event)">
                                        <div class="space-y-2">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="text-sm text-gray-600">
                                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
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
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <a href="{{ route('books.show', $relatedBook) }}">
                                <div class="h-64 overflow-hidden">
                                    @if($relatedBook->cover_image)
                                        <img src="{{ asset('storage/' . $relatedBook->cover_image) }}" alt="{{ $relatedBook->title }}" class="w-full h-full object-cover">
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
                                <a href="{{ route('books.show', $relatedBook) }}">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $relatedBook->title }}</h3>
                                </a>
                                <p class="text-sm text-gray-600 mb-2">{{ $relatedBook->author }}</p>
                                <div class="flex justify-between items-center">
                                    @if($relatedBook->is_on_sale)
                                        <div class="flex items-center">
                                            <span class="text-purple-600 font-semibold">RM {{ number_format($relatedBook->final_price, 2) }}</span>
                                            <span class="ml-2 text-xs text-gray-500 line-through">RM {{ number_format($relatedBook->price, 2) }}</span>
                                            <span class="ml-1 text-xs bg-red-100 text-red-800 px-1 py-0.5 rounded">-{{ $relatedBook->discount_percent }}%</span>
                                        </div>
                                    @else
                                        <span class="text-purple-600 font-semibold">RM {{ number_format($relatedBook->price, 2) }}</span>
                                    @endif
                                    <span class="text-xs text-gray-500 px-2 py-1 bg-gray-100 rounded-full">{{ $relatedBook->genre->name }}</span>
                                </div>
                                <div class="flex items-center mt-2">
                                    @php
                                        $avgRating = $relatedBook->average_rating;
                                        $reviewsCount = $relatedBook->reviews_count;
                                    @endphp
                                    <div class="flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-3 h-3 {{ $i <= ($avgRating ?: 0) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500 ml-1">{{ $avgRating ? number_format($avgRating, 1) : 'No' }} ({{ $reviewsCount }})</span>
                                </div>
                            </div>
                        </div>
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
                
                // Set main image
                mainImage.src = imageUrl;
                
                // Create thumbnails
                thumbnails.innerHTML = '';
                images.forEach((img, idx) => {
                    const thumbnail = document.createElement('img');
                    thumbnail.src = img;
                    thumbnail.className = `w-16 h-16 object-cover rounded cursor-pointer border-2 ${idx === index ? 'border-purple-500' : 'border-gray-200'}`;
                    thumbnail.onclick = () => switchImage(idx);
                    thumbnails.appendChild(thumbnail);
                });
                
                // Show/hide navigation arrows
                const prevBtn = document.getElementById('prevImage');
                const nextBtn = document.getElementById('nextImage');
                
                prevBtn.style.display = images.length > 1 ? 'block' : 'none';
                nextBtn.style.display = images.length > 1 ? 'block' : 'none';
                
                modal.classList.remove('hidden');
            }
            
            function switchImage(index) {
                currentImageIndex = index;
                const mainImage = document.getElementById('modalMainImage');
                const thumbnails = document.getElementById('thumbnails');
                
                mainImage.src = currentImages[index];
                
                // Update thumbnail selection
                Array.from(thumbnails.children).forEach((thumb, idx) => {
                    thumb.className = `w-16 h-16 object-cover rounded cursor-pointer border-2 ${idx === index ? 'border-purple-500' : 'border-gray-200'}`;
                });
            }
            
            function nextImage() {
                if (currentImageIndex < currentImages.length - 1) {
                    switchImage(currentImageIndex + 1);
                }
            }
            
            function prevImage() {
                if (currentImageIndex > 0) {
                    switchImage(currentImageIndex - 1);
                }
            }
            
            // Modal event listeners
            document.getElementById('closeImageModal').addEventListener('click', function() {
                document.getElementById('imageModal').classList.add('hidden');
            });
            
            document.getElementById('nextImage').addEventListener('click', nextImage);
            document.getElementById('prevImage').addEventListener('click', prevImage);
            
            // Close modal when clicking outside
            document.getElementById('imageModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                const modal = document.getElementById('imageModal');
                if (!modal.classList.contains('hidden')) {
                    if (e.key === 'Escape') {
                        modal.classList.add('hidden');
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
