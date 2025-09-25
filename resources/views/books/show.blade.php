@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('books.index') }}" class="text-purple-600 hover:text-purple-900">
                &larr; Back to Books
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Book Cover -->
                <div class="md:w-1/3 p-6">
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
                                <div class="mb-4">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="number" id="quantity" value="1" min="1" max="{{ $book->stock }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" {{ $book->stock < 1 ? 'disabled' : '' }}>
                                </div>
                                
                                @if($book->stock > 0)
                                    <button 
                                        type="button" 
                                        class="ajax-add-to-cart w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                                        data-book-id="{{ $book->id }}"
                                        onclick="addToCart({{ $book->id }}, document.getElementById('quantity').value, this)"
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
                                        onclick="toggleWishlist({{ $book->id }}, this)"
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
                <div class="md:w-2/3 p-6 border-t md:border-t-0 md:border-l border-gray-200">
                    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-600 mb-4">by {{ $book->author }}</p>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-purple-100 text-purple-800">
                            {{ $book->genre->name }}
                        </span>
                        @foreach($book->tropes as $trope)
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                {{ $trope->name }}
                            </span>
                        @endforeach
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Synopsis</h2>
                        <div class="prose max-w-none text-gray-700">
                            <p>{{ $book->synopsis }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Book Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Title</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $book->title }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Author</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $book->author }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Genre</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $book->genre->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tropes</h3>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $book->tropes->pluck('name')->join(', ') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reviews -->
        <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-serif font-bold text-gray-900">Customer Reviews</h2>
                    <div class="flex items-center">
                        @php
                            $avgRating = $book->average_rating;
                            $reviewsCount = $book->reviews_count;
                        @endphp
                        
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $avgRating)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @elseif ($i - 0.5 <= $avgRating)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-2 text-sm text-gray-600">
                            {{ $avgRating ? $avgRating : 'No' }} rating{{ $avgRating != 1 ? 's' : '' }} from {{ $reviewsCount }} review{{ $reviewsCount != 1 ? 's' : '' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Write a Review Form -->
            @auth
                @if($canReview && !$hasReviewed && $orderItem)
                    <div class="p-6 bg-purple-50">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Write a Review</h3>
                        <form action="{{ route('books.reviews.store', $book) }}" method="POST">
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
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const starContainer = document.querySelector('.star-rating');
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
                                    });
                                </script>
                            </div>
                            
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                                <textarea name="comment" id="comment" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" placeholder="Share your experience with this book...">{{ old('comment') }}</textarea>
                            </div>
                            
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                Submit Review
                            </button>
                        </form>
                    </div>
                @elseif($hasReviewed)
                    <div class="p-6 bg-green-50">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-green-800 font-medium">You've already reviewed this book. Thank you for your feedback!</p>
                        </div>
                    </div>
                @elseif(auth()->check() && !$canReview)
                    <div class="p-6 bg-gray-50">
                        <p class="text-gray-600">
                            <svg class="w-5 h-5 inline mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Only customers who purchased this book can leave a review.
                        </p>
                    </div>
                @endif
            @else
                <div class="p-6 bg-gray-50">
                    <p class="text-gray-600">
                        <svg class="w-5 h-5 inline mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-800 font-medium">Sign in</a> to write a review. Only customers who purchased this book can leave a review.
                    </p>
                </div>
            @endauth
            
            <!-- Review List (Flowbite style) -->
            <div class="divide-y divide-gray-200">
                @forelse($reviews as $review)
                    <article class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 me-4 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div class="font-medium">
                                <p class="text-gray-900">{{ $review->user->name }}
                                    <time datetime="{{ $review->created_at->toIso8601String() }}" class="block text-sm text-gray-500">Reviewed on {{ $review->created_at->format('F d, Y') }}</time>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center mb-1 space-x-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                @endif
                            @endfor
                            <h3 class="ms-2 text-sm font-semibold text-gray-900">{{ $review->title ?? 'Customer Review' }}</h3>
                        </div>
                        <footer class="mb-3 text-sm text-gray-500"><p>Purchased on <time datetime="{{ $review->created_at->toIso8601String() }}">{{ $review->created_at->format('M d, Y') }}</time></p></footer>
                        @if($review->comment)
                            <p class="mb-3 text-gray-700">{{ $review->comment }}</p>
                        @endif
                        <aside>
                            <p class="mt-1 text-xs text-gray-500">{{ $review->helpful_count }} people found this helpful</p>
                            <div class="flex items-center mt-3">
                                <button type="button" 
                                        class="helpful-btn px-2 py-1.5 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 {{ $review->isMarkedHelpfulBy(Auth::id()) ? 'bg-blue-100 text-blue-700 border-blue-300' : '' }}"
                                        data-review-id="{{ $review->id }}"
                                        data-is-helpful="{{ $review->isMarkedHelpfulBy(Auth::id()) ? 'true' : 'false' }}">
                                    {{ $review->isMarkedHelpfulBy(Auth::id()) ? 'Helpful ✓' : 'Helpful' }}
                                </button>
                                <button type="button" 
                                        class="report-btn ps-4 text-sm font-medium text-blue-600 hover:underline border-gray-200 ms-4 border-s"
                                        data-review-id="{{ $review->id }}">
                                    Report abuse
                                </button>
                            </div>
                        </aside>
                    </article>
                @empty
                    <div class="p-6 text-center">
                        <p class="text-gray-500">No reviews yet. Be the first to review this book!</p>
                    </div>
                @endforelse
            </div>
        </div>
        
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                            const helpfulCountElement = this.closest('aside').querySelector('p');
                            helpfulCountElement.textContent = `${data.helpful_count} people found this helpful`;
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
        });
    </script>
@endsection
