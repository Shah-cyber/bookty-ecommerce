@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 relative overflow-hidden">
    {{-- Ambient Background --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-pink-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
        <div class="absolute top-1/3 -left-40 w-96 h-96 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    </div>

    <div class="relative z-10 py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="mb-8" data-aos="fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center">
                            <svg class="w-7 h-7 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">My Wishlist</h1>
                            <p class="text-gray-500 text-sm mt-0.5">Books you've saved for later</p>
                        </div>
                    </div>
                    <a href="{{ route('books.index') }}" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Browse Books
                    </a>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3" data-aos="fade-up" role="alert">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3" data-aos="fade-up" role="alert">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @if($wishlistItems->isEmpty())
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sm:p-12 text-center" data-aos="fade-up">
                    <div class="max-w-sm mx-auto">
                        <div class="w-24 h-24 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">Your wishlist is empty</h2>
                        <p class="text-gray-500 mb-6">Start adding books you love to your wishlist. They'll be saved here for you to revisit anytime.</p>
                        <a href="{{ route('books.index') }}" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all shadow-lg shadow-gray-900/10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Discover Books
                        </a>
                    </div>
                </div>
            @else
                {{-- Stats Cards --}}
                @php
                    $totalItems = $wishlistItems->count();
                    $totalValue = $wishlistItems->sum(function($item) {
                        return $item->book->final_price ?? $item->book->price;
                    });
                    $onSaleCount = $wishlistItems->filter(function($item) {
                        return $item->book->is_on_sale;
                    })->count();
                    $inStockCount = $wishlistItems->filter(function($item) {
                        return $item->book->stock > 0;
                    })->count();
                @endphp
                
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8" data-aos="fade-up" data-aos-delay="100">
                    {{-- Total Items --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-pink-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalItems }}</p>
                                <p class="text-xs text-gray-500">Saved Items</p>
                            </div>
                        </div>
                    </div>

                    {{-- Total Value --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">RM {{ number_format($totalValue, 0) }}</p>
                                <p class="text-xs text-gray-500">Total Value</p>
                            </div>
                        </div>
                    </div>

                    {{-- On Sale --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ $onSaleCount }}</p>
                                <p class="text-xs text-gray-500">On Sale</p>
                            </div>
                        </div>
                    </div>

                    {{-- In Stock --}}
                    <div class="bg-white rounded-xl border border-gray-100 p-4 sm:p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ $inStockCount }}</p>
                                <p class="text-xs text-gray-500">In Stock</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wishlist Items Grid --}}
                <div class="mb-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Your Saved Books</h2>
                        @if($totalItems > 0)
                            <form action="{{ route('wishlist.clear') }}" method="POST" class="inline" 
                                onsubmit="return confirm('Are you sure you want to clear your entire wishlist?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Clear All
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div id="wishlist-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="200">
                    @foreach($wishlistItems as $index => $item)
                        <div class="wishlist-item" data-book-id="{{ $item->book->id }}" data-aos="fade-up" data-aos-delay="{{ 50 + ($index * 50) }}">
                            <x-book-card :book="$item->book" :context="'wishlist'" />
                        </div>
                    @endforeach
                </div>

                {{-- Bottom CTA --}}
                <div class="mt-12 text-center" data-aos="fade-up">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8 inline-block">
                        <p class="text-gray-600 mb-4">Ready to make these books yours?</p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                            <a href="{{ route('cart.index') }}" 
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                View Cart
                            </a>
                            <a href="{{ route('books.index') }}" 
                                class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                                Continue Shopping
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Empty State Template (hidden, used when all items removed) --}}
<template id="empty-wishlist-template">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sm:p-12 text-center" data-aos="fade-up">
        <div class="max-w-sm mx-auto">
            <div class="w-24 h-24 bg-pink-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Your wishlist is empty</h2>
            <p class="text-gray-500 mb-6">Start adding books you love to your wishlist. They'll be saved here for you to revisit anytime.</p>
            <a href="{{ route('books.index') }}" 
                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all shadow-lg shadow-gray-900/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Discover Books
            </a>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove onclick attributes from all wishlist remove buttons
    document.querySelectorAll('.wishlist-item form[action*="wishlist/remove"] button').forEach(btn => {
        btn.removeAttribute('onclick');
    });
    
    // Function to remove wishlist item with animation
    function removeWishlistItem(wishlistItem, button) {
        const bookId = wishlistItem.dataset.bookId;
        const removeUrl = `/wishlist/remove/${bookId}`;
        
        // Disable button and show loading state
        button.disabled = true;
        button.classList.add('opacity-50');
        
        fetch(removeUrl, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Animate card removal
                wishlistItem.style.transition = 'all 0.3s ease-out';
                wishlistItem.style.transform = 'scale(0.8)';
                wishlistItem.style.opacity = '0';
                
                setTimeout(() => {
                    wishlistItem.remove();
                    
                    // Update wishlist count in header
                    updateWishlistCount(data.wishlist_count);
                    
                    // Check if wishlist is now empty
                    const remainingItems = document.querySelectorAll('.wishlist-item');
                    if (remainingItems.length === 0) {
                        showEmptyState();
                    } else {
                        // Update stats
                        updateStats(remainingItems.length);
                    }
                    
                    // Show success toast
                    if (window.showToast) {
                        window.showToast(data.message || 'Book removed from wishlist!', 'success');
                    }
                }, 300);
            } else {
                button.disabled = false;
                button.classList.remove('opacity-50');
                if (window.showToast) {
                    window.showToast(data.message || 'Failed to remove book', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.disabled = false;
            button.classList.remove('opacity-50');
            if (window.showToast) {
                window.showToast('An error occurred. Please try again.', 'error');
            }
        });
    }
    
    // Use event delegation for better reliability
    const wishlistGrid = document.getElementById('wishlist-grid');
    if (wishlistGrid) {
        wishlistGrid.addEventListener('click', function(e) {
            // Check if click was on trash button (form remove button)
            const trashBtn = e.target.closest('form[action*="wishlist/remove"] button');
            if (trashBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                const wishlistItem = trashBtn.closest('.wishlist-item');
                if (wishlistItem) {
                    removeWishlistItem(wishlistItem, trashBtn);
                }
                return;
            }
            
            // Check if click was on wishlist heart button
            const heartBtn = e.target.closest('.wishlist-btn');
            if (heartBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                const wishlistItem = heartBtn.closest('.wishlist-item');
                if (wishlistItem) {
                    removeWishlistItem(wishlistItem, heartBtn);
                }
                return;
            }
        });
    }
    
    // Update wishlist count in navigation
    function updateWishlistCount(count) {
        // Update header wishlist badge if exists
        const wishlistBadges = document.querySelectorAll('.wishlist-count');
        wishlistBadges.forEach(badge => {
            badge.textContent = count;
            if (count === 0) {
                badge.closest('.wishlist-count-badge')?.classList.add('hidden');
            }
        });
    }
    
    // Update stats cards
    function updateStats(count) {
        // Update saved items count
        const statsGrid = document.querySelector('.grid.grid-cols-2.lg\\:grid-cols-4');
        if (statsGrid) {
            const firstStatValue = statsGrid.querySelector('.text-2xl.font-bold');
            if (firstStatValue) {
                firstStatValue.textContent = count;
            }
        }
    }
    
    // Show empty state when all items removed
    function showEmptyState() {
        const template = document.getElementById('empty-wishlist-template');
        const grid = document.getElementById('wishlist-grid');
        const statsGrid = document.querySelector('.grid.grid-cols-2.lg\\:grid-cols-4');
        const gridHeader = document.querySelector('.mb-6[data-aos-delay="150"]');
        const bottomCTA = document.querySelector('.mt-12.text-center');
        
        // Remove stats, grid header, grid, and bottom CTA
        if (statsGrid) statsGrid.remove();
        if (gridHeader) gridHeader.remove();
        if (grid) grid.remove();
        if (bottomCTA) bottomCTA.remove();
        
        // Insert empty state
        if (template) {
            const emptyState = template.content.cloneNode(true);
            const container = document.querySelector('.max-w-7xl.mx-auto');
            const flashMessages = container.querySelector('[role="alert"]');
            if (flashMessages) {
                flashMessages.after(emptyState);
            } else {
                const header = container.querySelector('.mb-8');
                if (header) {
                    header.after(emptyState);
                }
            }
        }
    }
});
</script>
@endsection
