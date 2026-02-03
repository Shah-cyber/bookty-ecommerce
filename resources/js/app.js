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
        const finalPrice = book.is_on_sale ? book.final_price : book.price;
        const discountPercent = book.discount_percent || 0;
        const stockLeft = book.stock !== undefined ? book.stock : 999; // Default to in-stock if not specified
        const isBestSeller = (book.total_sold || 0) >= 10;
        const isOutOfStock = stockLeft === 0;
        
        return `
            <div class="group relative rounded-[1.5rem] overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 h-full flex flex-col aspect-[3/4]">
                <!-- Full Cover Image Background -->
                <a href="${book.link}" class="absolute inset-0 z-0">
                    ${book.cover_image ?
                        `<img src="${book.cover_image}" alt="${book.title}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ${isOutOfStock ? 'grayscale' : ''}">` :
                        `<div class="w-full h-full bg-gradient-to-br from-amber-200 via-orange-300 to-amber-400 flex items-center justify-center">
                            <svg class="h-20 w-20 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>`
                    }
                </a>
                
                <!-- Top Badges -->
                <div class="relative z-10 p-4 flex justify-between items-start">
                    <!-- Left: Condition Badge -->
                    <div class="flex flex-col gap-2">
                        ${book.condition === 'preloved' ? `
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide bg-white/90 backdrop-blur-md text-amber-700 shadow-lg uppercase">
                                Preloved
                            </span>
                        ` : ''}
                        ${book.score ? `
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide bg-white/90 backdrop-blur-md text-gray-700 shadow-lg">
                                ${Math.round(book.score * 100)}% match
                            </span>
                        ` : ''}
                    </div>
                    
                    <!-- Right: Discount Badge -->
                    ${book.is_on_sale && discountPercent > 0 ? `
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-gray-900 shadow-lg">
                            ${discountPercent}% off
                        </span>
                    ` : ''}
                </div>
                
                <!-- Spacer -->
                <div class="flex-1"></div>
                
                <!-- Bottom Content Overlay -->
                <div class="relative z-10">
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent -top-20"></div>
                    
                    <!-- Content -->
                    <div class="relative p-5 pt-8 text-white">
                        <!-- Dots Indicator (decorative) -->
                        <div class="flex justify-center gap-1 mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-white/40"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-white/40"></span>
                        </div>
                        
                        <!-- Title & Price Row -->
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <h3 class="font-serif text-xl font-bold italic leading-tight line-clamp-2 flex-1">
                                ${book.title}
                            </h3>
                            <span class="flex-shrink-0 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-sm font-bold border border-white/30 whitespace-nowrap">
                                RM ${parseFloat(finalPrice).toFixed(0)}
                            </span>
                        </div>
                        
                        <!-- Description/Author -->
                        <p class="text-white/70 text-sm mb-4 line-clamp-2 leading-relaxed">
                            by ${book.author}
                        </p>
                        
                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            ${isBestSeller ? `
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-white/20 backdrop-blur-sm border border-white/30 text-white uppercase tracking-wide">
                                    Best Seller
                                </span>
                            ` : ''}
                            ${stockLeft > 0 && stockLeft <= 10 && book.stock !== undefined ? `
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-white/20 backdrop-blur-sm border border-white/30 text-white uppercase tracking-wide">
                                    ${stockLeft} left
                                </span>
                            ` : ''}
                            ${book.genre ? `
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-semibold bg-white/20 backdrop-blur-sm border border-white/30 text-white uppercase tracking-wide">
                                    ${book.genre}
                                </span>
                            ` : ''}
                        </div>
                        
                        <!-- View Details Button -->
                        <a href="${book.link}" class="block w-full py-3.5 bg-white text-gray-900 text-center text-sm font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                            View Details
                        </a>
                    </div>
                </div>
                
                ${book.is_on_sale && discountPercent > 0 ? `
                    <div class="absolute bottom-24 right-5 z-10">
                        <span class="text-xs text-white/60 line-through">RM ${parseFloat(book.price).toFixed(0)}</span>
                    </div>
                ` : ''}
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

