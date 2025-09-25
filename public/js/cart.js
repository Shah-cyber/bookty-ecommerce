/**
 * Bookty E-commerce - Cart AJAX Operations
 * 
 * This file contains JavaScript functions for handling cart operations without page reloads
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart functionality
    initCartFunctions();
});

/**
 * Initialize all cart-related functions
 */
function initCartFunctions() {
    // Set up event listeners for add to cart buttons
    setupAddToCartButtons();
    
    // Set up toast notification system
    setupToastSystem();
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
        showToast(data.message, 'success');
        
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
        showToast(error.message, 'error');
        
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
        showToast(data.message, 'success');
        
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
        showToast(error.message, 'error');
        
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

/**
 * Set up toast notification system
 */
function setupToastSystem() {
    // Create toast container if it doesn't exist
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'fixed top-4 right-4 z-50 flex flex-col space-y-4';
        document.body.appendChild(toastContainer);
    }
}

/**
 * Show a toast notification
 * 
 * @param {string} message - The message to display
 * @param {string} type - The type of toast (success, error, info)
 */
function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toast-container');
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'transform transition-all duration-300 ease-out scale-95 opacity-0 flex items-center p-4 rounded-lg shadow-lg max-w-xs';
    
    // Set background color based on type
    switch (type) {
        case 'success':
            toast.classList.add('bg-green-50', 'border-l-4', 'border-green-500');
            break;
        case 'error':
            toast.classList.add('bg-red-50', 'border-l-4', 'border-red-500');
            break;
        default:
            toast.classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
    }
    
    // Set icon based on type
    let icon = '';
    switch (type) {
        case 'success':
            icon = `<svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>`;
            break;
        case 'error':
            icon = `<svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>`;
            break;
        default:
            icon = `<svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>`;
    }
    
    // Set toast content
    toast.innerHTML = `
        ${icon}
        <div class="text-sm font-medium ${type === 'success' ? 'text-green-800' : type === 'error' ? 'text-red-800' : 'text-blue-800'}">
            ${message}
        </div>
        <button class="ml-auto text-gray-400 hover:text-gray-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    
    // Add toast to container
    toastContainer.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('scale-95', 'opacity-0');
        toast.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Add click event to close button
    const closeButton = toast.querySelector('button');
    closeButton.addEventListener('click', () => {
        removeToast(toast);
    });
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        removeToast(toast);
    }, 5000);
}

/**
 * Remove a toast notification with animation
 * 
 * @param {HTMLElement} toast - The toast element to remove
 */
function removeToast(toast) {
    // Animate out
    toast.classList.remove('scale-100', 'opacity-100');
    toast.classList.add('scale-95', 'opacity-0');
    
    // Remove after animation completes
    setTimeout(() => {
        toast.remove();
    }, 300);
}

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
        showToast(data.message, 'success');
        
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
        showToast(error.message, 'error');
        
        console.error('Error:', error);
    });
}

// Make functions available globally
window.addToCart = addToCart;
window.showToast = showToast;
window.toggleWishlist = toggleWishlist;
window.quickAddToCart = quickAddToCart;
