/**
 * Bookty E-commerce - Cart AJAX Operations
 * 
 * This file contains JavaScript functions for handling cart operations without page reloads
 */

/**
 * Safe toast function that checks if the global toast system is available
 * @param {string} message - The message to display
 * @param {string} type - The type of toast (success, error, warning, info)
 */
function safeShowToast(message, type = 'info') {
    if (typeof window.showToast === 'function') {
        window.showToast(message, type);
    } else {
        // Fallback - try different approaches
        console.log(`Toast system not available, trying alternatives for: ${type} - ${message}`);
        
        // Try to find toast manager
        if (window.toastManager) {
            window.toastManager.show(message, type);
        } else if (window.toastSuccess && type === 'success') {
            window.toastSuccess(message);
        } else if (window.toastError && type === 'error') {
            window.toastError(message);
        } else {
            // Final fallback - show alert for now
            alert(`${type.toUpperCase()}: ${message}`);
        }
    }
}

// Initialize cart functionality after DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add a small delay to ensure the Vite-compiled toast system has loaded
    setTimeout(initCartFunctions, 100);
});

/**
 * Initialize all cart-related functions
 */
function initCartFunctions() {
    // Set up event listeners for add to cart buttons
    setupAddToCartButtons();
    
    // Toast notifications are now handled by the global toast system
}

/**
 * Set up event listeners for all add to cart buttons
 */
function setupAddToCartButtons() {
    // Get all add to cart buttons with the ajax-add-to-cart class
    const addToCartButtons = document.querySelectorAll('.ajax-add-to-cart');
    
    // Add click event listener to each button
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get book ID from data attribute
            const bookId = this.dataset.bookId;
            const quantity = this.dataset.quantity || 1;
            
            // Add to cart via AJAX
            addToCart(bookId, quantity, this);
        });
    });
}

/**
 * Toggle a book in the wishlist (add or remove)
 * 
 * @param {number} bookId - The ID of the book to toggle
 * @param {HTMLElement} button - The button that was clicked
 */
function toggleWishlist(bookId, button) {
    // Show loading state
    setButtonLoading(button, true);
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Determine if the book is in the wishlist
    const isInWishlist = button.dataset.inWishlist === 'true';
    
    // Determine the endpoint
    const endpoint = isInWishlist ? 
        `/wishlist/remove/${bookId}` : 
        `/wishlist/add/${bookId}`;
    
    // Prepare the request
    const method = isInWishlist ? 'DELETE' : 'POST';
    
    // Make AJAX request
    fetch(endpoint, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                // Unauthorized - open auth modal instead of redirecting
                window.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }));
                throw new Error('Please login to manage your wishlist');
            }
            return response.json().then(data => {
                throw new Error(data.message || 'Error updating wishlist');
            });
        }
        return response.json();
    })
    .then(data => {
        // Reset button state
        setButtonLoading(button, false);
        
        // Update all wishlist buttons for this book
        const allButtons = document.querySelectorAll(`.wishlist-btn[data-book-id="${bookId}"]`);
        
        allButtons.forEach(btn => {
            if (isInWishlist) {
                // Book was removed from wishlist
                btn.dataset.inWishlist = 'false';
                
                // Update button style
                btn.classList.remove('bg-pink-100', 'text-pink-700', 'border-pink-300', 'hover:bg-pink-200');
                btn.classList.add('bg-gray-100', 'text-gray-700', 'border-gray-300', 'hover:bg-gray-200');
                
                // Update button content
                if (btn.id === 'wishlist-button') {
                    btn.innerHTML = `
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Add to Wishlist</span>
                    `;
                } else {
                    btn.innerHTML = `
                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    `;
                }
            } else {
                // Book was added to wishlist
                btn.dataset.inWishlist = 'true';
                
                // Update button style
                btn.classList.remove('bg-gray-100', 'text-gray-700', 'border-gray-300', 'hover:bg-gray-200');
                btn.classList.add('bg-pink-100', 'text-pink-700', 'border-pink-300', 'hover:bg-pink-200');
                
                // Update button content
                if (btn.id === 'wishlist-button') {
                    btn.innerHTML = `
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        <span>Remove from Wishlist</span>
                    `;
                } else {
                    btn.innerHTML = `
                        <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    `;
                }
            }
        });
        
        // Show success notification
        safeShowToast(data.message, 'success');
        
        // Trigger custom event for other components to listen to
        document.dispatchEvent(new CustomEvent('wishlist:updated', {
            detail: {
                wishlistCount: data.wishlist_count,
                bookId: bookId,
                inWishlist: !isInWishlist
            }
        }));
    })
    .catch(error => {
        // Reset button state
        setButtonLoading(button, false);
        
        // Show error notification
        safeShowToast(error.message, 'error');
        
        console.error('Error:', error);
    });
}

/**
 * Add a book to the cart via AJAX
 * 
 * @param {number} bookId - The ID of the book to add
 * @param {number} quantity - The quantity to add (default: 1)
 * @param {HTMLElement} button - The button that was clicked
 */
function addToCart(bookId, quantity, button) {
    // Show loading state
    setButtonLoading(button, true);
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Make AJAX request
    fetch(`/cart/quick-add/${bookId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                // Unauthorized - open auth modal instead of redirecting
                window.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }));
                throw new Error('Please login to add items to your cart');
            }
            return response.json().then(data => {
                throw new Error(data.message || 'Error adding item to cart');
            });
        }
        return response.json();
    })
    .then(data => {
        // Reset button state
        setButtonLoading(button, false);
        
        // Update cart count in the header
        updateCartCount(data.cart_count);
        
        // Show success notification
        safeShowToast(data.message, 'success');
        
        // Trigger custom event for other components to listen to
        document.dispatchEvent(new CustomEvent('cart:updated', {
            detail: {
                cartCount: data.cart_count,
                bookId: bookId,
                bookTitle: data.book.title,
                bookPrice: data.book.price
            }
        }));
    })
    .catch(error => {
        // Reset button state
        setButtonLoading(button, false);
        
        // Show error notification
        safeShowToast(error.message, 'error');
        
        console.error('Error:', error);
    });
}

/**
 * Set button loading state
 * 
 * @param {HTMLElement} button - The button element
 * @param {boolean} isLoading - Whether the button is in loading state
 */
function setButtonLoading(button, isLoading) {
    if (isLoading) {
        // Store original content
        button.dataset.originalContent = button.innerHTML;
        
        // Replace with loading spinner
        button.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Adding...
        `;
        button.disabled = true;
    } else {
        // Restore original content
        if (button.dataset.originalContent) {
            button.innerHTML = button.dataset.originalContent;
        }
        button.disabled = false;
    }
}

/**
 * Update the cart count in the header
 * 
 * @param {number} count - The new cart count
 */
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    
    cartCountElements.forEach(element => {
        if (count > 0) {
            element.textContent = count;
            element.classList.remove('hidden');
            element.classList.add('flex');
        } else {
            element.classList.add('hidden');
            element.classList.remove('flex');
        }
    });
}

// Toast functionality is now provided by the global toast system from resources/js/toast.js
// The showToast function is available globally

/**
 * Quick add to cart function for home page buttons
 * This function handles the special UI for the quick add buttons on the home page
 * 
 * @param {number} bookId - The ID of the book to add
 */
function quickAddToCart(bookId) {
    // Find all quick add buttons for this book
    const buttons = document.querySelectorAll(`.quick-add-btn[onclick*="${bookId}"]`);
    
    buttons.forEach(button => {
        // Show loading state
        const btnText = button.querySelector('.btn-text');
        const loadingSpinner = button.querySelector('.loading-spinner');
        
        if (btnText) btnText.classList.add('hidden');
        if (loadingSpinner) loadingSpinner.classList.remove('hidden');
        
        button.disabled = true;
    });
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Make AJAX request
    fetch(`/cart/quick-add/${bookId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 401) {
                // Unauthorized - open auth modal instead of redirecting
                window.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }));
                throw new Error('Please login to add items to your cart');
            }
            return response.json().then(data => {
                throw new Error(data.message || 'Error adding item to cart');
            });
        }
        return response.json();
    })
    .then(data => {
        // Reset button state
        buttons.forEach(button => {
            const btnText = button.querySelector('.btn-text');
            const loadingSpinner = button.querySelector('.loading-spinner');
            
            if (btnText) btnText.classList.remove('hidden');
            if (loadingSpinner) loadingSpinner.classList.add('hidden');
            
            button.disabled = false;
        });
        
        // Update cart count in the header
        updateCartCount(data.cart_count);
        
        // Show success notification
        safeShowToast(data.message, 'success');
        
        // Trigger custom event for other components to listen to
        document.dispatchEvent(new CustomEvent('cart:updated', {
            detail: {
                cartCount: data.cart_count,
                bookId: bookId,
                bookTitle: data.book.title,
                bookPrice: data.book.price
            }
        }));
    })
    .catch(error => {
        // Reset button state
        buttons.forEach(button => {
            const btnText = button.querySelector('.btn-text');
            const loadingSpinner = button.querySelector('.loading-spinner');
            
            if (btnText) btnText.classList.remove('hidden');
            if (loadingSpinner) loadingSpinner.classList.add('hidden');
            
            button.disabled = false;
        });
        
        // Show error notification
        safeShowToast(error.message, 'error');
        
        console.error('Error:', error);
    });
}

// Make functions available globally
window.addToCart = addToCart;
window.toggleWishlist = toggleWishlist;
window.quickAddToCart = quickAddToCart;
