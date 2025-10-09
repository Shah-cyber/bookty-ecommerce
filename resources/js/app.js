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

Alpine.start();
