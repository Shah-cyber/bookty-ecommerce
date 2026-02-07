import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);
import './toast';

import { DataTable } from 'simple-datatables';

window.Alpine = Alpine;
window.simpleDatatables = { DataTable };

// Quick Add to Cart global function
window.quickAddToCart = async function (bookId) {
    const button = event.target.closest('.quick-add-btn');
    if (!button) return;

    const btnText = button.querySelector('.btn-text');
    const loadingSpinner = button.querySelector('.loading-spinner');

    // Disable button and show loading state
    button.disabled = true;
    if (btnText) btnText.classList.add('hidden');
    if (loadingSpinner) loadingSpinner.classList.remove('hidden');

    try {
        const response = await fetch(`/cart/quick-add/${bookId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('Please login to add items to your cart.');
            }
            const errorData = await response.json();
            throw new Error(errorData.message || 'Failed to add item to cart');
        }

        const data = await response.json();

        // Show success message
        showToast(data.message || 'Book added to cart!', 'success');

        // Update cart count in navigation if it exists
        updateCartCount(data.cart_count);

        // Show success state
        if (btnText) {
            btnText.textContent = 'Added!';
            btnText.classList.remove('hidden');
        }
        if (loadingSpinner) loadingSpinner.classList.add('hidden');

        // Apply success styling
        button.classList.add('success-state');

        // Reset button after 2 seconds
        setTimeout(() => {
            if (btnText) {
                btnText.textContent = 'Quick Add';
            }
            button.classList.remove('success-state');
            button.disabled = false;
        }, 2000);

    } catch (error) {
        console.error('Quick add to cart error:', error);

        // Check if user needs to login
        if (error.message.includes('login') || error.message.includes('Please login')) {
            showToast('Please login to add items to your cart.', 'warning');

            // Redirect to login after a short delay
            setTimeout(() => {
                window.location.href = '/login';
            }, 1500);
        } else {
            showToast(error.message || 'Failed to add item to cart. Please try again.', 'error');
        }

        // Reset button state
        if (btnText) btnText.classList.remove('hidden');
        if (loadingSpinner) loadingSpinner.classList.add('hidden');
        button.disabled = false;
    }
};

// Update cart count in navigation
window.updateCartCount = function (count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count;
        element.style.display = count > 0 ? 'block' : 'none';
    });
};

// Copy tracking number and redirect to J&T tracking page
window.copyAndTrackPackage = async function (trackingNumber, trackingUrl) {
    try {
        // Copy tracking number to clipboard
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(trackingNumber);
            showToast(`Tracking number ${trackingNumber} copied to clipboard!`, 'success');
        } else {
            // Fallback for browsers that don't support clipboard API
            const textArea = document.createElement('textarea');
            textArea.value = trackingNumber;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                document.execCommand('copy');
                showToast(`Tracking number ${trackingNumber} copied to clipboard!`, 'success');
            } catch (err) {
                showToast('Could not copy tracking number, but opening tracking page...', 'warning');
            }

            document.body.removeChild(textArea);
        }

        // Redirect to J&T tracking page after a short delay
        setTimeout(() => {
            window.open(trackingUrl, '_blank');
        }, 1000);

    } catch (error) {
        console.error('Error copying tracking number:', error);
        showToast('Could not copy tracking number, but opening tracking page...', 'warning');

        // Still redirect even if copy fails
        setTimeout(() => {
            window.open(trackingUrl, '_blank');
        }, 1000);
    }
};

// Copy tracking number only (without redirect)
window.copyTrackingNumber = async function (trackingNumber) {
    try {
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(trackingNumber);
            showToast(`Tracking number ${trackingNumber} copied!`, 'success');
        } else {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = trackingNumber;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                document.execCommand('copy');
                showToast(`Tracking number ${trackingNumber} copied!`, 'success');
            } catch (err) {
                showToast('Failed to copy tracking number.', 'error');
            }

            document.body.removeChild(textArea);
        }
    } catch (error) {
        console.error('Error copying tracking number:', error);
        showToast('Failed to copy tracking number.', 'error');
    }
};

// Toggle wishlist functionality
window.toggleWishlist = async function (bookId, button) {
    // Show loading state
    const originalContent = button.innerHTML;
    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin h-4 w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;

    try {
        const response = await fetch(`/wishlist/toggle/${bookId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        if (data.success) {
            // Update button state - toggle the current state
            const wasInWishlist = button.dataset.inWishlist === 'true';
            const isNowInWishlist = !wasInWishlist;

            // Update all wishlist buttons for this book
            const allButtons = document.querySelectorAll(`.wishlist-btn[data-book-id="${bookId}"]`);

            allButtons.forEach(btn => {
                btn.dataset.inWishlist = isNowInWishlist ? 'true' : 'false';

                // Check if this is a detailed button (with text) or icon-only button
                const hasText = btn.querySelector('span');

                if (isNowInWishlist) {
                    // Book was added to wishlist - filled heart
                    if (hasText) {
                        // Button with text (like on book detail page)
                        btn.innerHTML = `
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                            <span>Remove from Wishlist</span>
                        `;
                        btn.className = btn.className.replace(/bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200/g, 'bg-pink-100 text-pink-700 border-pink-300 hover:bg-pink-200');
                    } else {
                        // Icon-only button
                        btn.innerHTML = `
                            <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        `;
                    }
                } else {
                    // Book was removed from wishlist - outline heart
                    if (hasText) {
                        // Button with text (like on book detail page)
                        btn.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span>Add to Wishlist</span>
                        `;
                        btn.className = btn.className.replace(/bg-pink-100 text-pink-700 border-pink-300 hover:bg-pink-200/g, 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200');
                    } else {
                        // Icon-only button
                        btn.innerHTML = `
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        `;
                    }
                }
                btn.disabled = false;
            });

            // Update wishlist count in the header if it exists
            if (data.wishlist_count !== undefined) {
                const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                wishlistCountElements.forEach(element => {
                    if (data.wishlist_count > 0) {
                        element.textContent = data.wishlist_count;
                        element.classList.remove('hidden');
                    } else {
                        element.classList.add('hidden');
                    }
                });
            }

            // Show success message
            showToast(data.message, isNowInWishlist ? 'success' : 'info');
        } else {
            button.innerHTML = originalContent;
            button.disabled = false;
            showToast(data.message || 'Failed to update wishlist', 'error');
        }
    } catch (error) {
        console.error('Wishlist toggle error:', error);
        button.innerHTML = originalContent;
        button.disabled = false;
        showToast('An error occurred. Please try again.', 'error');
    }
};

// Recommendation System
window.RecommendationManager = {
    async fetchRecommendations(limit = 12) {
        try {
            const response = await fetch(`/api/recommendations/me?limit=${limit}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('Failed to fetch recommendations');
            }

            const data = await response.json();
            return data.data || [];
        } catch (error) {
            console.error('Error fetching recommendations:', error);
            return [];
        }
    },

    async fetchSimilarBooks(bookId, limit = 8) {
        try {
            const response = await fetch(`/api/recommendations/similar/${bookId}?limit=${limit}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Failed to fetch similar books');
            }

            const data = await response.json();
            return data.data || [];
        } catch (error) {
            console.error('Error fetching similar books:', error);
            return [];
        }
    },

    renderBookCard(book) {
        // Calculate discount percent if not provided but on sale
        const discountPercent = book.discount_percent || Math.round(((book.price - book.final_price) / book.price) * 100);
        
        // Condition logic
        const isPreloved = (book.condition === 'preloved');
        const conditionLabel = book.condition_label || (isPreloved ? 'Preloved' : 'New');
        const conditionClasses = isPreloved ? 'bg-amber-100/90 text-amber-900' : 'bg-emerald-100/90 text-emerald-900';

        // Genre label
        const genreName = (book.genre?.name || book.genre || 'GENRE').toUpperCase();
        
        // Wishlist logic
        const inWishlist = book.in_wishlist;

        return `
            <div class="group relative w-full aspect-[3/4] rounded-[2.5rem] overflow-hidden shadow-xl bg-gray-900 transform-gpu hover:-translate-y-1 transition-transform duration-300">
                <!-- Background Image -->
                <div class="absolute inset-0 rounded-[2.5rem] overflow-hidden z-0 mask-image-rounded">
                    ${book.cover_image ? 
                        `<img src="${book.cover_image}" alt="${book.title}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 opacity-90 group-hover:opacity-100">` : 
                        `<div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                            <svg class="h-16 w-16 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>`
                    }

                    <!-- Dark gradient overlay for text readability -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
                </div>

                <!-- Top badges + wishlist -->
                <div class="absolute top-4 left-4 right-4 flex justify-between items-start z-20">
                    <div class="flex flex-col gap-2">
                        <!-- Discount badge -->
                        ${book.is_on_sale ? `
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold bg-white/90 text-gray-900 shadow-md backdrop-blur-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                ${discountPercent}% OFF
                            </span>
                        ` : ''}
                        
                        <!-- Condition badge -->
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-[11px] font-bold shadow-md ${conditionClasses}">
                            ${conditionLabel}
                        </span>
                    </div>

                    <!-- Wishlist button with glass effect -->
                    <div class="pointer-events-auto">
                        <button
                            class="wishlist-btn p-2.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/30 text-white hover:text-red-500 backdrop-blur-md transition-all duration-300 shadow-lg"
                            data-book-id="${book.id}"
                            data-in-wishlist="${inWishlist ? 'true' : 'false'}"
                            aria-label="${inWishlist ? 'Remove from wishlist' : 'Add to wishlist'}"
                        >
                            <svg class="w-5 h-5 ${inWishlist ? 'fill-current text-red-500' : 'fill-none'}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Liquid Glass bottom panel -->
                <div class="absolute inset-x-3 bottom-3 z-30 transform translate-y-[62px] group-hover:translate-y-0 transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]">
                    <!-- Original Liquid Glass Style: Translucent bg-white/30 with blur -->
                    <div class="relative rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.3)] px-4 py-4 sm:px-5 sm:py-5 text-white ring-1 ring-white/10">
                        
                        <!-- Top row: genre + match + price -->
                        <div class="flex items-center justify-between mb-3 mt-1">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-[10px] font-bold tracking-wide text-white uppercase backdrop-blur-sm shadow-sm border border-white/10">
                                    ${genreName}
                                </span>
                                
                                <!-- Match Score (Inline) -->
                                ${book.score ? `
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-purple-500/80 text-white shadow-sm backdrop-blur-sm border border-purple-400/30">
                                        <svg class="w-2.5 h-2.5 mr-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        ${Math.round(book.score * 100)}%
                                    </span>
                                ` : ''}
                            </div>

                            <div class="text-right">
                                ${book.is_on_sale ? `
                                    <div class="text-[11px] text-white/70 line-through decoration-red-500/80 decoration-2 drop-shadow-md font-medium">
                                        RM ${parseFloat(book.price).toFixed(2)}
                                    </div>
                                    <div class="text-base font-extrabold text-white drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]">
                                        RM ${parseFloat(book.final_price).toFixed(2)}
                                    </div>
                                ` : `
                                    <div class="text-base font-extrabold text-white drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]">
                                        RM ${parseFloat(book.price).toFixed(2)}
                                    </div>
                                `}
                            </div>
                        </div>

                        <!-- Title & Author -->
                        <div class="mb-3">
                            <a href="${book.link}" class="block group/title">
                                <h3 class="text-[15px] sm:text-base font-bold text-white mb-0.5 leading-snug line-clamp-2 drop-shadow-md group-hover/title:text-pink-300 transition-colors">
                                    ${book.title}
                                </h3>
                            </a>
                            <p class="text-[11px] text-gray-200 font-medium drop-shadow-sm">
                                ${book.author}
                            </p>

                            ${(book.stock <= 5 && book.stock > 0) ? `
                                <div class="mt-2 flex items-center gap-1.5">
                                    <span class="w-3.5 h-3.5 rounded-full border border-amber-200/50 flex items-center justify-center bg-black/20 backdrop-blur-sm">
                                        <span class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.8)] animate-pulse"></span>
                                    </span>
                                    <span class="text-[11px] text-amber-300 font-bold drop-shadow-sm">
                                        Only ${book.stock} left
                                    </span>
                                </div>
                            ` : ''}
                        </div>

                        <!-- Add to Cart -->
                        <div class="pt-1">
                            ${book.stock > 0 ? `
                                <button
                                    type="button"
                                    class="btn-liquid w-full ajax-add-to-cart"
                                    data-book-id="${book.id}"
                                    data-quantity="1"
                                >
                                    <span>Add to cart</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </button>
                            ` : `
                                <button
                                    type="button"
                                    class="w-full py-3 rounded-full bg-white/10 text-gray-400 text-sm font-bold cursor-not-allowed border border-white/20 backdrop-blur-sm"
                                    disabled
                                >
                                    Out of stock
                                </button>
                            `}
                        </div>
                    </div>
                </div>
            </div>
        `;
    },

    renderSidebarBookCard(book) {
        return `
            <div class="flex space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                <div class="flex-shrink-0 relative">
                    <a href="${book.link}" class="block">
                        ${book.cover_image ?
                `<img src="${book.cover_image}" alt="${book.title}" class="w-16 h-20 object-cover rounded-md shadow-sm">` :
                `<div class="w-16 h-20 bg-gray-200 rounded-md flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>`
            }
                    </a>
                    <!-- Condition Badge -->
                    ${book.condition === 'preloved' ? `
                        <span class="absolute -top-1 -right-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-medium bg-amber-500 text-white shadow-sm">
                            Preloved
                        </span>
                    ` : `
                        <span class="absolute -top-1 -right-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-medium bg-green-500 text-white shadow-sm">
                            New
                        </span>
                    `}
                </div>
                <div class="flex-1 min-w-0">
                    <a href="${book.link}" class="block">
                        <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 hover:text-purple-600 transition-colors">${book.title}</h4>
                        <p class="text-xs text-gray-600 mt-1">by ${book.author}</p>
                        <div class="mt-2">
                            ${book.is_on_sale ?
                `<div class="flex items-center space-x-1">
                                    <span class="text-sm font-bold text-purple-600">RM ${parseFloat(book.final_price).toFixed(2)}</span>
                                    <span class="text-xs text-gray-500 line-through">RM ${parseFloat(book.price).toFixed(2)}</span>
                                </div>` :
                `<span class="text-sm font-bold text-purple-600">RM ${parseFloat(book.price).toFixed(2)}</span>`
            }
                        </div>
                        ${book.score ? `<div class="mt-1"><span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">${Math.round(book.score * 100)}% match</span></div>` : ''}
                    </a>
                </div>
            </div>
        `;
    },

    async loadRecommendations(containerId, limit = 12) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const books = await this.fetchRecommendations(limit);
        if (books.length === 0) {
            container.innerHTML = '<p class="text-gray-500 text-center">No recommendations available at the moment.</p>';
            return;
        }

        const html = books.map(book => this.renderBookCard(book)).join('');
        container.innerHTML = html;
    },

    async loadSimilarBooks(bookId, containerId, limit = 6) {
        const container = document.getElementById(containerId);
        if (!container) return;

        // Show loading state
        container.innerHTML = `
            <div class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
            </div>
        `;

        try {
            const books = await this.fetchSimilarBooks(bookId, limit);

            if (books.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-sm">No similar books found.</p>
                    </div>
                `;
                return;
            }

            const html = books.map(book => this.renderSidebarBookCard(book)).join('');
            container.innerHTML = html;
        } catch (error) {
            console.error('Error loading similar books:', error);
            container.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-500 text-sm">Failed to load similar books.</p>
                </div>
            `;
        }
    }
};

// AJAX Add to Cart functionality
document.addEventListener('DOMContentLoaded', function () {
    // Handle wishlist button clicks via event delegation
    document.addEventListener('click', function (e) {
        const button = e.target.closest('.wishlist-btn');
        if (button) {
            e.preventDefault();
            e.stopPropagation(); // Prevent event bubbling

            const bookId = button.dataset.bookId;

            if (bookId && window.toggleWishlist) {
                window.toggleWishlist(bookId, button);
            }
        }
    });

    // Handle login buttons for wishlist (for non-authenticated users)
    document.addEventListener('click', function (e) {
        const button = e.target.closest('button[aria-label*="Login to add to wishlist"]');
        if (button) {
            e.preventDefault();
            e.stopPropagation();

            // Dispatch custom event to open auth modal
            window.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }));
        }
    });

    // Handle AJAX add to cart buttons
    document.addEventListener('click', function (e) {
        const button = e.target.closest('.ajax-add-to-cart');
        if (button) {
            e.preventDefault();
            e.stopPropagation(); // Prevent event bubbling

            const bookId = button.dataset.bookId;
            const quantity = button.dataset.quantity || 1;

            // Show loading state
            const originalContent = button.innerHTML;
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin h-4 w-4 text-gray-900 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;

            // Send AJAX request
            fetch(`/cart/quick-add/${bookId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    quantity: parseInt(quantity)
                }),
                credentials: 'same-origin'
            })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            // User not authenticated
                            return response.json().then(data => {
                                throw new Error(data.message || 'Authentication required');
                            });
                        }
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update cart count in header if it exists
                        if (data.cart_count !== undefined) {
                            const cartCountElements = document.querySelectorAll('.cart-count');
                            cartCountElements.forEach(element => {
                                element.textContent = data.cart_count;
                                element.classList.remove('hidden');
                            });
                        }

                        // Show success message
                        showToast(data.message, 'success');

                        // Restore button with success state briefly
                        button.innerHTML = `
                        <svg class="h-4 w-4 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    `;

                        // Restore original content after delay
                        setTimeout(() => {
                            button.innerHTML = originalContent;
                            button.disabled = false;
                        }, 1000);
                    } else {
                        throw new Error(data.message || 'Failed to add to cart');
                    }
                })
                .catch(error => {
                    console.error('Add to cart error:', error);
                    button.innerHTML = originalContent;
                    button.disabled = false;

                    // Show error message
                    if (error.message.includes('Authentication required') || error.message.includes('login')) {
                        showToast('Please login to add items to your cart.', 'warning');
                        // Optionally trigger login modal
                        setTimeout(() => {
                            window.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }));
                        }, 1000);
                    } else {
                        showToast(error.message || 'Failed to add item to cart. Please try again.', 'error');
                    }
                });
        }
    });
});

Alpine.start();
