@props(['book', 'showAddToCart' => true])

@php
    $avgRating = $book->average_rating ?? 0;
    $reviewsCount = $book->reviews_count ?? 0;
    $isOnSale = $book->is_on_sale ?? false;
    $discountPercent = $book->discount_percent ?? 0;
    $finalPrice = $book->final_price ?? $book->price;
    $stockLeft = $book->stock ?? 999; // Default to in-stock if not specified
    $isOutOfStock = $book->stock === 0;
    $isBestSeller = ($book->total_sold ?? 0) >= 10; // Consider best seller if 10+ sold
@endphp

<div class="group relative rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 h-full flex flex-col aspect-[3/4] block ring-1 ring-white/20 bg-white">
    <!-- Main Card Link (Stretched) -->
    <a href="{{ route('books.show', $book) }}" class="absolute inset-0 z-0" aria-label="View {{ $book->title }}"></a>

    <!-- Full Cover Image Background -->
    <span class="absolute inset-0 z-0 bg-gray-200 pointer-events-none">
        @if($book->cover_image)
            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                 alt="{{ $book->title }}" 
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 {{ $isOutOfStock ? 'grayscale opacity-75' : '' }}">
        @else
            <div class="w-full h-full bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 flex items-center justify-center">
                <svg class="h-20 w-20 text-purple-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        @endif
    </span>
    
    <!-- Top Badges -->
    <div class="relative z-10 p-4 flex justify-between items-start w-full pointer-events-none">
        <!-- Left: Condition Badge -->
        <div class="flex flex-col gap-2">
            @if(($book->condition ?? 'new') === 'preloved')
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-bold tracking-wide bg-amber-500/90 backdrop-blur-md text-white shadow-lg uppercase border border-amber-400/50">
                    Preloved
                </span>
            @else 
                 <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-bold tracking-wide bg-white/60 backdrop-blur-md text-gray-900 shadow-sm border border-white/40 uppercase">
                    New
                </span>
            @endif
        </div>
        
        <!-- Right: Discount Badge -->
        @if($isOnSale && $discountPercent > 0)
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-500/90 backdrop-blur-md text-white shadow-lg border border-red-400/50">
                -{{ $discountPercent }}%
            </span>
        @endif
    </div>
    
    <!-- Spacer -->
    <div class="flex-1 pointer-events-none"></div>
    
    <!-- Bottom Content Overlay -->
    <div class="relative z-10 pointer-events-none">
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent -top-24 pointer-events-none"></div>
        
        <!-- Content -->
        <div class="relative p-5 pt-2 text-white">
            
            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mb-3 pointer-events-none">
                @if($isBestSeller)
                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-bold bg-amber-400/20 backdrop-blur-sm border border-amber-400/50 text-amber-200 uppercase tracking-wide">
                        Best Seller
                    </span>
                @endif
                @if($book->genre)
                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-bold bg-white/20 backdrop-blur-sm border border-white/30 text-white uppercase tracking-wide">
                        {{ $book->genre->name }}
                    </span>
                @endif
            </div>

            <!-- Title & Price Row -->
            <div class="flex items-start justify-between gap-3 mb-1 pointer-events-none">
                <h3 class="font-serif text-lg font-bold leading-tight line-clamp-2 flex-1 text-white group-hover:text-purple-200 transition-colors">
                    {{ $book->title }}
                </h3>
                <span class="flex-shrink-0 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-sm font-bold border border-white/30 whitespace-nowrap">
                    RM {{ number_format($finalPrice, 0) }}
                </span>
            </div>
            
            <!-- Author -->
            <p class="text-white/70 text-sm mb-5 line-clamp-1 font-medium pointer-events-none">
                by {{ $book->author }}
            </p>
            
            <!-- Add to Cart Button -->
            <!-- Pointer events auto specifically for this button -->
            <div class="relative z-30 pointer-events-auto">
                @if($showAddToCart)
                    @if($stockLeft > 0)
                        <button 
                            type="button" 
                            class="ajax-add-to-cart w-full py-3.5 bg-white text-gray-900 text-sm font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-gray-100 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300"
                            data-book-id="{{ $book->id }}"
                            data-quantity="1"
                        >
                            Add to cart
                        </button>
                    @else
                        <button 
                            type="button" 
                            class="w-full py-3.5 bg-white/10 backdrop-blur-md text-white/50 text-sm font-bold rounded-xl cursor-not-allowed border border-white/10"
                            disabled
                        >
                            Out of Stock
                        </button>
                    @endif
                @else
                    <span class="block w-full py-3.5 bg-white/20 backdrop-blur-md border border-white/30 text-white text-center text-sm font-bold rounded-xl shadow-lg pointer-events-none">
                        View Details
                    </span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Wishlist Button (floating) -->
    <!-- Pointer events auto specifically for this button -->
    <div class="absolute top-4 right-4 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-2 group-hover:translate-y-0 pointer-events-auto">
        @auth
            <button type="button" 
                class="wishlist-btn p-2.5 bg-white/80 backdrop-blur-md rounded-full hover:bg-white transition-all duration-200 shadow-lg text-gray-900 hover:text-pink-600 hover:scale-110"
                data-book-id="{{ $book->id }}"
                data-in-wishlist="{{ Auth::user()->hasBookInWishlist($book->id) ? 'true' : 'false' }}"
                tabindex="0"
                aria-label="{{ Auth::user()->hasBookInWishlist($book->id) ? 'Remove from wishlist' : 'Add to wishlist' }}"
            >
                @if(Auth::user()->hasBookInWishlist($book->id))
                    <svg class="w-5 h-5 text-pink-600 pointer-events-none" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                @endif
            </button>
        @else
            <button type="button" 
                class="p-2.5 bg-white/80 backdrop-blur-md rounded-full hover:bg-white transition-all duration-200 shadow-lg text-gray-900 hover:text-pink-600 hover:scale-110" 
                tabindex="0" 
                aria-label="Login to add to wishlist"
                onclick="document.dispatchEvent(new CustomEvent('open-auth-modal'));"
            >
                <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        @endauth
    </div>
    
    <!-- Sale Price Comparison (if on sale) -->
    @if($isOnSale && $discountPercent > 0)
        <div class="absolute bottom-28 right-5 z-10 pointer-events-none">
            <span class="text-xs text-white/60 line-through font-medium">RM {{ number_format($book->price, 0) }}</span>
        </div>
    @endif
</div>

