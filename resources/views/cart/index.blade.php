@extends('layouts.app')

@section('content')
<style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>
<div class="min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Page Header --}}
        <div class="mb-8" data-aos="fade-up">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
                    <p class="text-sm text-gray-500"><span id="header-item-count">{{ $cart->items->count() }}</span> {{ Str::plural('item', $cart->items->count()) }} in your cart</p>
                </div>
            </div>
        </div>

        @if($cart->items->isEmpty())
            {{-- Empty Cart State --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center" data-aos="fade-up">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">Looks like you haven't added any books yet. Start exploring our collection!</p>
                <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Browse Books
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-8">
                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-4" data-aos="fade-up" data-aos-delay="100">
                    @foreach($cart->items as $item)
                        <div class="cart-item-{{ $item->id }} bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow duration-200" data-item-id="{{ $item->id }}">
                            <div class="flex gap-4">
                                {{-- Book Cover --}}
                                <a href="{{ route('books.show', $item->book) }}" class="flex-shrink-0">
                                    @if($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-20 h-28 object-cover rounded-xl shadow-sm">
                                    @else
                                        <div class="w-20 h-28 bg-gray-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                </a>

                                {{-- Book Details --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between gap-4">
                                        <div class="min-w-0">
                                            <a href="{{ route('books.show', $item->book) }}" class="text-base font-semibold text-gray-900 hover:text-gray-700 line-clamp-1 transition-colors">
                                                {{ $item->book->title }}
                                            </a>
                                            <p class="text-sm text-gray-500 mt-0.5">{{ $item->book->author }}</p>
                                            
                                            @if($item->book->stock <= 0)
                                                <span class="inline-flex items-center gap-1 mt-2 px-2 py-1 bg-red-50 text-red-600 text-xs font-medium rounded-lg">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                    Out of stock
                                                </span>
                                            @elseif($item->book->stock <= 5)
                                                <span class="inline-flex items-center gap-1 mt-2 px-2 py-1 bg-amber-50 text-amber-600 text-xs font-medium rounded-lg">
                                                    Only {{ $item->book->stock }} left
                                                </span>
                                            @endif
                                        </div>

                                        <div class="text-right flex-shrink-0">
                                            <p class="item-total-{{ $item->id }} text-lg font-bold text-gray-900">RM {{ number_format($item->book->price * $item->quantity, 2) }}</p>
                                            <p class="text-sm text-gray-500">RM {{ number_format($item->book->price, 2) }} each</p>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                        @if($item->book->stock > 0)
                                            <div class="flex items-center gap-2">
                                                <label for="qty-{{ $item->id }}" class="text-sm text-gray-600">Qty:</label>
                                                <select id="qty-{{ $item->id }}" 
                                                    class="cart-qty-select w-16 px-2 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400"
                                                    data-item-id="{{ $item->id }}"
                                                    data-update-url="{{ route('cart.update', $item) }}"
                                                    data-price="{{ $item->book->price }}">
                                                    @for($i = 1; $i <= min(10, $item->book->stock); $i++)
                                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">Unavailable</span>
                                        @endif

                                        <button type="button" 
                                            class="cart-remove-btn inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-red-600 transition-colors"
                                            data-item-id="{{ $item->id }}"
                                            data-remove-url="{{ route('cart.remove', $item) }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Continue Shopping --}}
                    <div class="pt-4">
                        <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                {{-- Order Summary Sidebar --}}
                <div class="lg:col-span-1" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>

                        {{-- Summary Details --}}
                        <div class="space-y-3 pb-4 border-b border-gray-100">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal (<span id="cart-item-count">{{ $cart->items->count() }}</span> items)</span>
                                <span id="cart-subtotal" class="font-medium text-gray-900">
                                    RM {{ number_format($cart->items->sum(function($item) { return $item->book->price * $item->quantity; }), 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="text-gray-500">Calculated at checkout</span>
                            </div>
                        </div>

                        {{-- Total --}}
                        <div class="flex justify-between items-center py-4">
                            <span class="text-base font-semibold text-gray-900">Estimated Total</span>
                            <span id="cart-total" class="text-xl font-bold text-gray-900">
                                RM {{ number_format($cart->items->sum(function($item) { return $item->book->price * $item->quantity; }), 2) }}
                            </span>
                        </div>

                        {{-- Checkout Button --}}
                        <a href="{{ route('checkout.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all duration-200">
                            <span>Proceed to Checkout</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>

                        {{-- Shipping Info --}}
                        <div class="mt-6 p-4 bg-blue-50 rounded-xl">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Shipping Rates</p>
                                    <p class="text-xs text-blue-700 mt-1">Peninsular: RM 8 - RM 12</p>
                                    <p class="text-xs text-blue-700">East Malaysia: RM 15 - RM 20</p>
                                </div>
                            </div>
                        </div>

                        {{-- Secure Checkout Badge --}}
                        <div class="mt-4 flex items-center justify-center gap-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="text-xs">Secure checkout</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recommendations --}}
            @auth
                <div class="mt-12 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center gap-3 mb-4 sm:mb-6 px-2 sm:px-0">
                        <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">You Might Also Like</h3>
                            <p class="text-xs sm:text-sm text-gray-500">Based on items in your cart</p>
                        </div>
                    </div>
                    
                    {{-- Mobile: Horizontal scroll, Desktop: Grid --}}
                    <div class="sm:hidden">
                        <div id="cart-recommendations-mobile" class="flex gap-3 overflow-x-auto pb-4 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide">
                            <div class="flex justify-center items-center py-8 w-full">
                                <div class="w-8 h-8 border-2 border-gray-200 border-t-gray-600 rounded-full animate-spin"></div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Desktop: Grid layout --}}
                    <div id="cart-recommendations-grid" class="hidden sm:grid sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div class="col-span-full flex justify-center items-center py-8">
                            <div class="w-8 h-8 border-2 border-gray-200 border-t-gray-600 rounded-full animate-spin"></div>
                        </div>
                    </div>
                </div>
            @endauth
        @endif
    </div>
</div>

{{-- Cart AJAX Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Helper function to update cart counts in header
    function updateHeaderCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(el => el.textContent = count);
        
        const cartBadgeElements = document.querySelectorAll('.cart-count-badge');
        cartBadgeElements.forEach(el => {
            if (count > 0) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
    }
    
    // Helper function to format currency
    function formatCurrency(amount) {
        return 'RM ' + parseFloat(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    
    // Handle quantity change
    document.querySelectorAll('.cart-qty-select').forEach(select => {
        select.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const updateUrl = this.dataset.updateUrl;
            const price = parseFloat(this.dataset.price);
            const newQty = parseInt(this.value);
            const originalValue = this.dataset.originalValue || this.value;
            
            // Store original value for rollback
            this.dataset.originalValue = this.value;
            
            // Disable select during update
            this.disabled = true;
            this.classList.add('opacity-50');
            
            fetch(updateUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ quantity: newQty }),
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update item total
                    const itemTotalEl = document.querySelector('.item-total-' + itemId);
                    if (itemTotalEl) {
                        itemTotalEl.textContent = data.item_total_formatted;
                    }
                    
                    // Update subtotal and total
                    const subtotalEl = document.getElementById('cart-subtotal');
                    const totalEl = document.getElementById('cart-total');
                    if (subtotalEl) subtotalEl.textContent = data.subtotal_formatted;
                    if (totalEl) totalEl.textContent = data.subtotal_formatted;
                    
                    // Update header cart count
                    updateHeaderCartCount(data.cart_count);
                    
                    // Show success toast
                    if (window.showToast) {
                        window.showToast(data.message, 'success');
                    }
                } else {
                    // Rollback on error
                    this.value = originalValue;
                    if (window.showToast) {
                        window.showToast(data.message || 'Failed to update cart', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error updating cart:', error);
                this.value = originalValue;
                if (window.showToast) {
                    window.showToast('Failed to update cart. Please try again.', 'error');
                }
            })
            .finally(() => {
                this.disabled = false;
                this.classList.remove('opacity-50');
            });
        });
    });
    
    // Handle remove item
    document.querySelectorAll('.cart-remove-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const removeUrl = this.dataset.removeUrl;
            const cartItem = document.querySelector('.cart-item-' + itemId);
            
            // Disable button during removal
            this.disabled = true;
            this.classList.add('opacity-50');
            
            fetch(removeUrl, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Animate and remove item
                    if (cartItem) {
                        cartItem.style.transition = 'all 0.3s ease';
                        cartItem.style.opacity = '0';
                        cartItem.style.transform = 'translateX(-20px)';
                        setTimeout(() => {
                            cartItem.remove();
                            
                            // Check if cart is empty
                            if (data.item_count === 0) {
                                location.reload(); // Reload to show empty cart state
                            }
                        }, 300);
                    }
                    
                    // Update subtotal and total
                    const subtotalEl = document.getElementById('cart-subtotal');
                    const totalEl = document.getElementById('cart-total');
                    const itemCountEl = document.getElementById('cart-item-count');
                    const headerItemCountEl = document.getElementById('header-item-count');
                    
                    if (subtotalEl) subtotalEl.textContent = data.subtotal_formatted;
                    if (totalEl) totalEl.textContent = data.subtotal_formatted;
                    if (itemCountEl) itemCountEl.textContent = data.item_count;
                    if (headerItemCountEl) headerItemCountEl.textContent = data.item_count;
                    
                    // Update header cart count
                    updateHeaderCartCount(data.cart_count);
                    
                    // Show success toast
                    if (window.showToast) {
                        window.showToast(data.message, 'success');
                    }
                } else {
                    this.disabled = false;
                    this.classList.remove('opacity-50');
                    if (window.showToast) {
                        window.showToast(data.message || 'Failed to remove item', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error removing item:', error);
                this.disabled = false;
                this.classList.remove('opacity-50');
                if (window.showToast) {
                    window.showToast('Failed to remove item. Please try again.', 'error');
                }
            });
        });
    });
});
</script>

@auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.RecommendationManager) {
                // Load for desktop grid
                window.RecommendationManager.loadRecommendations('cart-recommendations-grid', 8);
                
                // Load for mobile horizontal scroll
                const mobileContainer = document.getElementById('cart-recommendations-mobile');
                if (mobileContainer) {
                    // Fetch recommendations for mobile with proper headers
                    fetch('/api/recommendations/me?limit=8', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        credentials: 'same-origin'
                    })
                        .then(response => response.json())
                        .then(data => {
                            const books = data.data || [];
                            if (books.length > 0) {
                                mobileContainer.innerHTML = books.map(book => `
                                    <a href="/books/${book.slug}" class="flex-shrink-0 w-36 snap-start">
                                        <div class="relative aspect-[3/4] rounded-2xl overflow-hidden shadow-md bg-gray-100">
                                            ${book.cover_image 
                                                ? `<img src="/storage/${book.cover_image}" alt="${book.title}" class="w-full h-full object-cover">`
                                                : `<div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                   </div>`
                                            }
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                            <div class="absolute bottom-0 left-0 right-0 p-3">
                                                <p class="text-white text-xs font-semibold line-clamp-2 leading-tight">${book.title}</p>
                                                <p class="text-white/70 text-[10px] mt-0.5">${book.author}</p>
                                                <p class="text-white text-xs font-bold mt-1">RM ${parseFloat(book.final_price || book.price).toFixed(2)}</p>
                                            </div>
                                        </div>
                                    </a>
                                `).join('');
                            } else {
                                mobileContainer.innerHTML = '<p class="text-gray-500 text-sm text-center py-4 w-full">No recommendations available</p>';
                            }
                        })
                        .catch(() => {
                            mobileContainer.innerHTML = '<p class="text-gray-500 text-sm text-center py-4 w-full">Unable to load recommendations</p>';
                        });
                }
            }
        });
    </script>
@endauth
@endsection
