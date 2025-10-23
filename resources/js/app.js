import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import './toast';

window.Alpine = Alpine;

// Quick Add to Cart global function
window.quickAddToCart = async function(bookId) {
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
window.updateCartCount = function(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count;
        element.style.display = count > 0 ? 'block' : 'none';
    });
};

// Copy tracking number and redirect to J&T tracking page
window.copyAndTrackPackage = async function(trackingNumber, trackingUrl) {
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
window.copyTrackingNumber = async function(trackingNumber) {
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
window.toggleWishlist = async function(bookId, button) {
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

// AJAX Add to Cart functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle wishlist button clicks via event delegation
    document.addEventListener('click', function(e) {
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
    document.addEventListener('click', function(e) {
        const button = e.target.closest('button[aria-label*="Login to add to wishlist"]');
        if (button) {
            e.preventDefault();
            e.stopPropagation();
            
            // Dispatch custom event to open auth modal
            window.dispatchEvent(new CustomEvent('open-auth-modal', { detail: 'login' }));
        }
    });

    // Handle AJAX add to cart buttons
    document.addEventListener('click', function(e) {
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
