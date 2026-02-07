@props(['book', 'context' => 'general'])

<div
    class="group relative w-full aspect-[3/4] rounded-[2.5rem] overflow-hidden shadow-xl bg-gray-900/5 transform-gpu hover:-translate-y-1 transition-transform duration-300"
>
    <!-- Background Image -->
    <div class="absolute inset-0 rounded-[2.5rem] overflow-hidden z-0 mask-image-rounded">
        @if($book->cover_image)
            <img
                src="{{ asset('storage/' . $book->cover_image) }}"
                alt="{{ $book->title }}"
                class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
            >
        @else
            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <svg class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        @endif

        <!-- Subtle top gradient for readability -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent pointer-events-none"></div>
    </div>

    <!-- Top badges + wishlist -->
    <div class="absolute top-4 left-4 right-4 flex justify-between items-start z-20">
        <div class="flex flex-col gap-2">
            {{-- Discount badge --}}
            @if($book->is_on_sale)
                <span
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold bg-white/80 text-gray-900 shadow-md backdrop-blur-md">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    {{ $book->discount_percent }}% OFF
                </span>
            @endif

            {{-- Condition badge --}}
            <span
                class="inline-flex items-center px-3.5 py-1.5 rounded-full text-[11px] font-bold shadow-md
                       {{ ($book->condition ?? 'new') === 'preloved'
                            ? 'bg-amber-100/90 text-amber-900'
                            : 'bg-emerald-100/90 text-emerald-900' }}">
                {{ $book->condition_label ?? 'New' }}
            </span>
        </div>

        {{-- Wishlist button with glass effect --}}
        <div class="pointer-events-auto">
            @auth
                <button
                    class="wishlist-btn p-2.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/30
                           text-white hover:text-red-500 backdrop-blur-md transition-all duration-300 shadow-md"
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
                    onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }))"
                    class="p-2.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/30
                           text-white hover:text-red-500 backdrop-blur-md transition-all duration-300 shadow-md"
                    aria-label="Login to add to wishlist"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            @endauth
        </div>
    </div>

    <!-- Liquid Glass bottom panel -->
    <div
        class="absolute inset-x-3 bottom-3 z-30 transform translate-y-[62px]
               group-hover:translate-y-0 transition-transform duration-500
               ease-[cubic-bezier(0.34,1.56,0.64,1)]">
        <div
            class="relative rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20
                   shadow-[0_8px_32px_rgba(0,0,0,0.3)] px-4 py-4 sm:px-5 sm:py-5 text-white ring-1 ring-white/10"
        >
            <!-- Top row: genre + price -->
            <div class="flex items-center justify-between mb-3 mt-1">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-[10px] font-bold tracking-wide text-white uppercase backdrop-blur-sm shadow-sm border border-white/10">
                    {{ strtoupper($book->genre->name ?? 'GENRE') }}
                </span>

                <div class="text-right">
                    @if($book->is_on_sale)
                        <div class="text-[11px] text-white/70 line-through decoration-red-500/80 decoration-2 drop-shadow-md font-medium">
                            RM {{ number_format($book->price, 2) }}
                        </div>
                        <div class="text-base font-extrabold text-white drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]">
                            RM {{ number_format($book->final_price, 2) }}
                        </div>
                    @else
                        <div class="text-base font-extrabold text-white drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]">
                            RM {{ number_format($book->price, 2) }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Title & Author -->
            <div class="mb-3">
                <a href="{{ route('books.show', $book) }}" class="block group/title">
                    <h3
                        class="text-[15px] sm:text-base font-bold text-white mb-0.5 leading-snug line-clamp-2
                               drop-shadow-md group-hover/title:text-pink-300 transition-colors">
                        {{ $book->title }}
                    </h3>
                </a>
                <p class="text-[11px] text-gray-200 font-medium drop-shadow-sm">
                    {{ $book->author }}
                </p>

                @if($book->stock <= 5 && $book->stock > 0)
                    <div class="mt-2 flex items-center gap-1.5">
                        <span
                            class="w-3.5 h-3.5 rounded-full border border-amber-200/50 flex items-center justify-center bg-black/20 backdrop-blur-sm">
                            <span class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.8)] animate-pulse"></span>
                        </span>
                        <span class="text-[11px] text-amber-300 font-bold drop-shadow-sm">
                            Only {{ $book->stock }} left
                        </span>
                    </div>
                @endif
            </div>

            <!-- Add to Cart -->
            <div class="pt-1">
                @if($book->stock > 0)
                    @if($context === 'wishlist')
                        <div class="flex gap-2">
                            <button
                                type="button"
                                class="btn-liquid flex-1 ajax-add-to-cart"
                                data-book-id="{{ $book->id }}"
                                data-quantity="1"
                            >
                                <span>Add to cart</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </button>

                            <form action="{{ route('wishlist.remove', $book) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="button"
                                    onclick="this.closest('form').submit()"
                                    class="px-3 py-3 rounded-2xl bg-red-50 text-red-500 hover:bg-red-100
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
                            <span>Add to cart</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </button>
                    @else
                        <button
                            type="button"
                            class="btn-liquid w-full"
                            onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }))"
                        >
                            <span>Add to cart</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </button>
                    @endauth
                    @endif
                @else
                    <button
                        type="button"
                        class="w-full py-3 rounded-full bg-gray-200/80 text-gray-500 text-sm font-semibold
                               cursor-not-allowed border border-gray-200"
                        disabled
                    >
                        Out of stock
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
