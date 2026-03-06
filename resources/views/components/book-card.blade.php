@props(['book', 'context' => 'general'])

<div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 hover:border-gray-200 transition-all duration-500 hover:-translate-y-1 overflow-hidden flex flex-col">
    <!-- Cover Image Area -->
    <div class="relative overflow-hidden">
        <a href="{{ route('books.show', $book->slug) }}" class="block aspect-[5/6] overflow-hidden">
            @if($book->cover_image)
                <img
                    src="{{ asset('storage/' . $book->cover_image) }}"
                    alt="{{ $book->title }}"
                    class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                    loading="lazy"
                >
            @else
                <div class="w-full h-full bg-gradient-to-br from-gray-100 via-gray-50 to-gray-200 flex flex-col items-center justify-center gap-3">
                    <svg class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-400">No Cover</span>
                </div>
            @endif
        </a>

        <!-- Top Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
            @if($book->is_on_sale)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-red-500 text-white shadow-sm">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm4.707 3.707a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L8.414 10H13a1 1 0 100-2H8.414l1.293-1.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ $book->discount_percent }}% OFF
                </span>
            @endif

            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide shadow-sm
                   {{ ($book->condition ?? 'new') === 'preloved'
                        ? 'bg-amber-400 text-amber-950'
                        : 'bg-emerald-400 text-emerald-950' }}">
                {{ $book->condition_label ?? 'New' }}
            </span>
        </div>

        <!-- Wishlist Button -->
        <div class="absolute top-3 right-3">
            @auth
                <button
                    class="wishlist-btn p-2 rounded-full bg-white/90 hover:bg-white text-gray-400
                           hover:text-red-500 shadow-sm hover:shadow-md backdrop-blur-sm
                           transition-all duration-300 border border-gray-100"
                    data-book-id="{{ $book->id }}"
                    data-in-wishlist="{{ Auth::user()->hasBookInWishlist($book->id) ? 'true' : 'false' }}"
                    aria-label="{{ Auth::user()->hasBookInWishlist($book->id) ? 'Remove from wishlist' : 'Add to wishlist' }}"
                >
                    <svg
                        class="w-4 h-4 {{ Auth::user()->hasBookInWishlist($book->id) ? 'fill-current text-red-500' : 'fill-none' }}"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            @else
                <button
                    onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }))"
                    class="p-2 rounded-full bg-white/90 hover:bg-white text-gray-400
                           hover:text-red-500 shadow-sm hover:shadow-md backdrop-blur-sm
                           transition-all duration-300 border border-gray-100"
                    aria-label="Login to add to wishlist"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            @endauth
        </div>
    </div>

    <!-- Info Panel -->
    <div class="flex flex-col flex-1 p-4">
        <!-- Genre pill -->
        <div class="mb-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider bg-gray-100 text-gray-500">
                {{ $book->genre->name ?? 'Genre' }}
            </span>
        </div>

        <!-- Title & Author -->
        <div class="flex-1 mb-3">
            <a href="{{ route('books.show', $book) }}" class="block group/title">
                <h3 class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2 mb-1
                           group-hover/title:text-primary-600 transition-colors duration-200">
                    {{ $book->title }}
                </h3>
            </a>
            <p class="text-xs text-gray-400 font-medium">
                {{ $book->author }}
            </p>
        </div>

        <!-- Price -->
        <div class="mb-3">
            @if($book->is_on_sale)
                <div class="flex items-baseline gap-2">
                    <span class="text-lg font-bold text-gray-900">
                        RM {{ number_format($book->final_price, 2) }}
                    </span>
                    <span class="text-xs text-gray-400 line-through">
                        RM {{ number_format($book->price, 2) }}
                    </span>
                </div>
            @else
                <span class="text-lg font-bold text-gray-900">
                    RM {{ number_format($book->price, 2) }}
                </span>
            @endif
        </div>

        <!-- Low stock warning -->
        @if($book->stock <= 5 && $book->stock > 0)
            <div class="flex items-center gap-1.5 mb-3">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                </span>
                <span class="text-[11px] text-amber-600 font-semibold">
                    Only {{ $book->stock }} left
                </span>
            </div>
        @endif

        <!-- Add to Cart -->
        <div class="mt-auto">
            @if($book->stock > 0)
                @if($context === 'wishlist')
                    <div class="flex gap-2">
                        <button
                            type="button"
                            class="btn-liquid flex-1 ajax-add-to-cart"
                            data-book-id="{{ $book->id }}"
                            data-quantity="1"
                        >
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span>Add to Cart</span>
                        </button>

                        <form action="{{ route('wishlist.remove', $book) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                type="button"
                                onclick="this.closest('form').submit()"
                                class="p-3 rounded-xl bg-red-50 text-red-500 hover:bg-red-100
                                       border border-red-100 transition-all duration-300"
                                aria-label="Remove from wishlist"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    @auth
                        <button
                            type="button"
                            class="btn-liquid w-full ajax-add-to-cart"
                            data-book-id="{{ $book->id }}"
                            data-quantity="1"
                        >
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span>Add to Cart</span>
                        </button>
                    @else
                        <button
                            type="button"
                            class="btn-liquid w-full"
                            onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }))"
                        >
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span>Add to Cart</span>
                        </button>
                    @endauth
                @endif
            @else
                <button
                    type="button"
                    class="w-full py-3 rounded-xl bg-gray-100 text-gray-400 text-sm font-semibold
                           cursor-not-allowed"
                    disabled
                >
                    Out of Stock
                </button>
            @endif
        </div>
    </div>
</div>
