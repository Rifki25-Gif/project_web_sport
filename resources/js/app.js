import './bootstrap';
import './wishlist';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Initialize Alpine
Alpine.start();

// Listen for Livewire toast events
document.addEventListener('livewire:initialized', () => {
    Livewire.on('show-toast', (data) => {
        window.dispatchEvent(
            new CustomEvent('toast-timer-start', {
                detail: { timeout: data.timeout || 3000 }
            })
        );
    });
});
