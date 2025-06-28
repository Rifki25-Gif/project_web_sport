<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .active-size {
            background-color: #1a202c;
            color: #fff;
        }
        .transition-transform {
            transition: transform 0.3s ease-in-out;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <div class="container mx-auto p-4 lg:p-8" x-data="productPage()">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <!-- Image Gallery -->
                <div class="w-full lg:w-1/2 p-4">
                    <div class="relative" @mouseenter="zoom = true" @mouseleave="zoom = false">
                        <img :src="images[selectedImage]" alt="Main product image" class="w-full h-auto rounded-lg cursor-pointer" id="mainImage">
                        <div x-show="zoom" x-transition class="absolute top-0 left-0 w-full h-full bg-no-repeat rounded-lg pointer-events-none" :style="`background-image: url(${images[selectedImage]}); background-size: 200%;`" id="zoom-box" @mousemove.throttle.16ms="handleZoom($event)"></div>
                    </div>
                    <div class="flex mt-4 space-x-2 overflow-x-auto">
                        <template x-for="(image, index) in images" :key="index">
                            <img :src="image" alt="Product thumbnail" class="w-20 h-20 rounded-md cursor-pointer border-2" :class="{'border-blue-500': selectedImage === index}" @click="selectedImage = index">
                        </template>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="w-full lg:w-1/2 p-4 lg:p-8">
                    <h1 class="text-3xl font-bold text-gray-800">High-Performance Running Shoes</h1>
                    <p class="text-gray-600 mt-2">Engineered for speed and comfort.</p>
                    <div class="mt-4">
                        <h2 class="text-xl font-semibold text-gray-700">Performance Specifications</h2>
                        <ul class="list-disc list-inside mt-2 text-gray-600">
                            <li>Lightweight mesh upper</li>
                            <li>Responsive foam midsole</li>
                            <li>Durable rubber outsole</li>
                            <li>Weight: 8.5 oz (Men's size 9)</li>
                        </ul>
                    </div>

                    <!-- Size Selector -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-700">Select Size</h3>
                        <div class="flex space-x-2 mt-2">
                            <template x-for="size in sizes" :key="size">
                                <button @click="selectedSize = size" :class="{'active-size': selectedSize === size}" class="w-12 h-12 rounded-full border-2 border-gray-300 focus:outline-none focus:border-blue-500 transition-colors">
                                    <span x-text="size"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="mt-6">
                        <span class="text-2xl font-bold text-gray-800">$120.00</span>
                    </div>

                    <!-- Add to Cart -->
                    <div class="mt-6">
                        <button @click="addToCart()" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-all duration-300 flex items-center justify-center h-12">
                            <span x-show="!addingToCart && !addedToCart">Add to Cart</span>
                            <div x-show="addingToCart" class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-6 w-6 animate-spin"></div>
                            <span x-show="addedToCart" class="flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Added!
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-6">
                <!-- Example Related Product -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/300x300.png/0000FF/808080?text=Shoe+5" alt="Related Product" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800">Another Shoe</h3>
                        <p class="text-gray-600 mt-1">$95.00</p>
                    </div>
                </div>
                 <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/300x300.png/FF0000/FFFFFF?text=Shoe+6" alt="Related Product" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800">Trail Runners</h3>
                        <p class="text-gray-600 mt-1">$110.00</p>
                    </div>
                </div>
                 <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/300x300.png/008000/FFFFFF?text=Shoe+7" alt="Related Product" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800">Classic Trainers</h3>
                        <p class="text-gray-600 mt-1">$80.00</p>
                    </div>
                </div>
                 <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/300x300.png/FFFF00/000000?text=Shoe+8" alt="Related Product" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800">Minimalist Style</h3>
                        <p class="text-gray-600 mt-1">$100.00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Sidebar -->
    <div x-data x-show="$store.cart.isOpen" @keydown.escape.window="$store.cart.isOpen = false" class="fixed inset-0 overflow-hidden z-50" x-cloak>
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="$store.cart.isOpen" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="$store.cart.isOpen = false"></div>
            
            <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                <div x-show="$store.cart.isOpen" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                        <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900">Shopping cart</h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button @click="$store.cart.isOpen = false" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                                        <template x-if="$store.cart.items.length === 0">
                                            <p class="text-gray-500 text-center py-6">Your cart is empty.</p>
                                        </template>
                                        <template x-for="item in $store.cart.items" :key="item.id">
                                            <li class="py-6 flex">
                                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                    <img :src="item.image" alt="item" class="h-full w-full object-cover object-center">
                                                </div>

                                                <div class="ml-4 flex-1 flex flex-col">
                                                    <div>
                                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                                            <h3 x-text="item.name"></h3>
                                                            <p class="ml-4" x-text="`$${(item.price * item.quantity).toFixed(2)}`"></p>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500" x-text="`Size: ${item.size}`"></p>
                                                    </div>
                                                    <div class="flex-1 flex items-end justify-between text-sm">
                                                        <div class="flex items-center">
                                                            <button @click="$store.cart.updateQuantity(item.id, item.quantity - 1)" class="text-gray-500 focus:outline-none focus:text-gray-600 p-1">-</button>
                                                            <span class="text-gray-700 mx-2" x-text="item.quantity"></span>
                                                            <button @click="$store.cart.updateQuantity(item.id, item.quantity + 1)" class="text-gray-500 focus:outline-none focus:text-gray-600 p-1">+</button>
                                                        </div>
                                                        <div class="flex">
                                                            <button @click="$store.cart.confirmRemoveItem(item.id)" type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                            <!-- Free Shipping Progress -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-600" x-text="$store.cart.shippingMessage"></p>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                    <div class="bg-blue-600 h-2.5 rounded-full" :style="`width: ${$store.cart.shippingProgress}%`"></div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Subtotal</p>
                                <p x-text="`$${$store.cart.total.toFixed(2)}`"></p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                            
                            <!-- Coupon -->
                            <div class="mt-6">
                                <div class="flex">
                                    <input type="text" x-model="$store.cart.couponCode" placeholder="Coupon code" class="flex-grow rounded-l-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <button @click="$store.cart.applyCoupon()" class="bg-gray-200 text-gray-600 px-4 rounded-r-md hover:bg-gray-300">Apply</button>
                                </div>
                                <p x-show="$store.cart.couponMessage" x-text="$store.cart.couponMessage" class="mt-2 text-sm" :class="{'text-green-600': $store.cart.couponApplied, 'text-red-600': !$store.cart.couponApplied && $store.cart.couponMessage}"></p>
                            </div>

                            <div class="mt-6">
                                <a href="#" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Checkout</a>
                            </div>
                            <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                <p>or <button @click="$store.cart.isOpen = false" type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Continue Shopping<span aria-hidden="true"> &rarr;</span></button></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-data x-show="$store.cart.removeItemId" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="$store.cart.removeItemId" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="$store.cart.removeItemId" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Remove item</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to remove this item from your cart?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="$store.cart.removeItem($store.cart.removeItemId)" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Remove</button>
                    <button @click="$store.cart.removeItemId = null" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productPage', () => ({
                images: [
                    'https://via.placeholder.com/600x600.png/0000FF/808080?text=Shoe+1',
                    'https://via.placeholder.com/600x600.png/FF0000/FFFFFF?text=Shoe+2',
                    'https://via.placeholder.com/600x600.png/008000/FFFFFF?text=Shoe+3',
                    'https://via.placeholder.com/600x600.png/FFFF00/000000?text=Shoe+4'
                ],
                selectedImage: 0,
                zoom: false,
                sizes: [7, 8, 9, 10, 11, 12],
                selectedSize: null,
                addingToCart: false,
                addedToCart: false,

                handleZoom(event) {
                    const box = this.$refs.mainImage;
                    const zoomBox = this.$refs.zoomBox;
                    if (!box) return;
                    const rect = box.getBoundingClientRect();
                    const x = event.clientX - rect.left;
                    const y = event.clientY - rect.top;
                    const imgWidth = box.offsetWidth;
                    const imgHeight = box.offsetHeight;
                    const xPercent = (x / imgWidth) * 100;
                    const yPercent = (y / imgHeight) * 100;

                    zoomBox.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
                },

                addToCart() {
                    if (!this.selectedSize) {
                        alert('Please select a size.');
                        return;
                    }
                    this.addingToCart = true;
                    setTimeout(() => {
                        this.addingToCart = false;
                        this.addedToCart = true;
                        
                        this.$store.cart.addItem({
                            id: Date.now(),
                            name: 'High-Performance Running Shoes',
                            price: 120.00,
                            quantity: 1,
                            size: this.selectedSize,
                            image: this.images[0]
                        });

                        setTimeout(() => {
                            this.addedToCart = false;
                        }, 2000);
                    }, 1000);
                }
            }));

            Alpine.store('cart', {
                isOpen: false,
                items: [],
                removeItemId: null,
                couponCode: '',
                couponApplied: false,
                couponMessage: '',
                freeShippingThreshold: 200,

                addItem(newItem) {
                    const existingItem = this.items.find(i => i.name === newItem.name && i.size === newItem.size);
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        this.items.push(newItem);
                    }
                    this.isOpen = true;
                },

                get total() {
                    let total = this.items.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                    if (this.couponApplied) {
                        total *= 0.9; // 10% discount
                    }
                    return total;
                },

                get shippingProgress() {
                    return Math.min((this.total / this.freeShippingThreshold) * 100, 100);
                },
                
                get shippingMessage() {
                    if (this.total >= this.freeShippingThreshold) {
                        return "You've got free shipping!";
                    }
                    const remaining = this.freeShippingThreshold - this.total;
                    if (this.total === 0) {
                         return `Add $${this.freeShippingThreshold.toFixed(2)} to your cart for free shipping.`
                    }
                    return `Add $${remaining.toFixed(2)} more for free shipping.`;
                },

                updateQuantity(id, quantity) {
                    const item = this.items.find(i => i.id === id);
                    if (item && quantity > 0) {
                        item.quantity = quantity;
                    } else if (item && quantity === 0) {
                        this.confirmRemoveItem(id);
                    }
                },
                
                confirmRemoveItem(id) {
                    this.removeItemId = id;
                },

                removeItem(id) {
                    this.items = this.items.filter(item => item.id !== id);
                    this.removeItemId = null;
                },

                applyCoupon() {
                    if (this.couponCode.toUpperCase() === 'SALE10') {
                        this.couponApplied = true;
                        this.couponMessage = 'Coupon applied successfully!';
                    } else {
                        this.couponApplied = false;
                        this.couponMessage = 'Invalid coupon code.';
                    }
                }
            });
        });
    </script>
</body>
</html> 