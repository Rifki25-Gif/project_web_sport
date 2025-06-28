document.addEventListener('DOMContentLoaded', () => {

    // --- Shipping Form Validation ---
    const shippingForm = document.getElementById('shipping-form');
    if (shippingForm) {
        shippingForm.querySelectorAll('input[required]').forEach(input => {
            input.addEventListener('input', () => {
                if (input.checkValidity()) {
                    input.classList.remove('invalid');
                }
            });
            input.addEventListener('invalid', (e) => {
                e.preventDefault();
                input.classList.add('invalid');
            });
        });
    }

    // --- Payment Method Selection ---
    const paymentMethods = document.getElementById('payment-methods');
    if (paymentMethods) {
        const methods = paymentMethods.querySelectorAll('[data-payment-method]');
        methods.forEach(method => {
            method.addEventListener('click', () => {
                // Hide all forms
                paymentMethods.querySelectorAll('.border-t').forEach(form => {
                    form.classList.add('hidden');
                });
                // Deselect all methods
                methods.forEach(m => m.classList.remove('bg-blue-100', 'border-blue-500'));
                
                // Show selected form
                const methodType = method.dataset.paymentMethod;
                const formToShow = document.getElementById(`${methodType}-form`) || document.getElementById(`${methodType}-info`);
                if (formToShow) {
                    formToShow.classList.remove('hidden');
                }
                method.parentElement.classList.add('bg-blue-100', 'border-blue-500');
            });
        });
        // Open the first payment method by default
        if(methods.length > 0) {
            methods[0].click();
        }
    }

    // --- Fake Payment Processing ---
    const paymentForm = document.getElementById('payment-form');
    if (paymentForm) {
        paymentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const payButton = document.getElementById('pay-button');
            const buttonText = document.getElementById('pay-button-text');

            buttonText.textContent = 'Processing...';
            payButton.disabled = true;

            // Simulate network request
            setTimeout(() => {
                window.location.href = paymentForm.action;
            }, 2000);
        });
    }
}); 