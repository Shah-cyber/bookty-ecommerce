import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs';
import './toast';

window.Alpine = Alpine;

// Quick Add to Cart global function
window.quickAddToCart = async function(bookId) {
    const button = event.target.closest('.quick-add-btn');
    const btnText = button.querySelector('.btn-text');
    const loadingSpinner = button.querySelector('.loading-spinner');
    
    // Disable button and show loading state
    button.disabled = true;
    btnText.classList.add('hidden');
    loadingSpinner.classList.remove('hidden');
    
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
        
        const data = await response.json();
        
        if (data.success) {
            // Show success message
            showToast(data.message, 'success');
            
            // Update cart count in navigation if it exists
            updateCartCount(data.cart_count);
            
            // Change button text temporarily
            btnText.textContent = 'Added!';
            btnText.classList.remove('hidden');
            loadingSpinner.classList.add('hidden');
            button.classList.remove('bg-gradient-to-r', 'from-purple-600', 'to-pink-600');
            button.classList.add('bg-green-500');
            
            // Reset button after 2 seconds
            setTimeout(() => {
                btnText.textContent = button.classList.contains('w-full') ? 'Quick Add to Cart' : 'Add to Cart';
                button.classList.add('bg-gradient-to-r', 'from-purple-600', 'to-pink-600');
                button.classList.remove('bg-green-500');
                button.disabled = false;
            }, 2000);
            
        } else {
            throw new Error(data.message || 'Something went wrong');
        }
        
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
        btnText.classList.remove('hidden');
        loadingSpinner.classList.add('hidden');
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

Alpine.start();
