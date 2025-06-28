document.addEventListener('DOMContentLoaded', function() {
    console.log('Cart.js loaded successfully');
    
    // Setup CSRF token for AJAX requests
    let csrfToken;
    try {
        csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log('CSRF token found');
    } catch (e) {
        console.error('CSRF token not found:', e);
    }
    
    // Add to cart form submission handler
    const addToCartForms = document.querySelectorAll('form[action*="cart/add"]');
    console.log('Found ' + addToCartForms.length + ' add to cart forms');
    
    if (addToCartForms.length > 0) {
        addToCartForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                console.log('Form submit event triggered', form);
                e.preventDefault();
                
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Adding...';
                submitButton.disabled = true;
                
                // Gather form data
                const formData = new FormData(form);
                console.log('Form action:', form.action);
                
                // Send AJAX request
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    console.log('Response received:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data);
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                    
                    if (data.success) {
                        // Show success message
                        showToast(data.message, 'success');
                        
                        // Update cart count if available
                        updateCartCount(data.cart_count);
                    } else {
                        // Show error message
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                    showToast('An error occurred. Please try again.', 'error');
                });
            });
            console.log('Submit event listener added to form');
        });
    } else {
        console.warn('No add to cart forms found on the page');
    }
    
    // Simple toast notification
    function showToast(message, type = 'success') {
        console.log('Showing toast:', message, type);
        // Check if Livewire is available
        if (typeof Livewire !== 'undefined') {
            console.log('Using Livewire toast');
            Livewire.dispatch('show-toast', { 
                message: message, 
                type: type 
            });
        } else {
            console.log('Using fallback toast');
            // Fallback to simple toast
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 p-4 rounded-md text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} z-50`;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    }
    
    // Update cart count in the navigation
    function updateCartCount(count) {
        console.log('Updating cart count to:', count);
        const cartCountElements = document.querySelectorAll('.cart-count');
        console.log('Found cart count elements:', cartCountElements.length);
        if (cartCountElements.length > 0) {
            cartCountElements.forEach(element => {
                element.textContent = count;
                element.classList.remove('hidden');
            });
            console.log('Cart count updated successfully');
        }
    }
}); 