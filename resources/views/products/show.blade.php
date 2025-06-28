@section('title', $product->name)
@section('description', Str::limit(strip_tags($product->description), 155))
@section('image', $product->featured_image)

<x-app-layout>
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-blue-600">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('products.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">
                                Products
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Product Image -->
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg">
                    
                    <!-- Thumbnail Images (if available) -->
                    <div class="grid grid-cols-4 gap-2 mt-4">
                        <div class="border-2 border-blue-500 rounded-lg overflow-hidden">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-20 object-cover">
                        </div>
                        <!-- Add more thumbnails if you have them -->
                    </div>
                </div>

                <!-- Product Details -->
                <div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                        <p class="text-gray-600 mb-4">{{ $product->brand }}</p>
                        
                        <!-- Price -->
                        <div class="mb-6">
                            @if($product->sale_price)
                                <div class="flex items-center">
                                    <span class="text-3xl font-bold text-gray-800">${{ number_format($product->sale_price, 2) }}</span>
                                    <span class="ml-2 text-xl text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                    <span class="ml-2 bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        {{ $product->discountPercentage() }}% OFF
                                    </span>
                                </div>
                            @else
                                <span class="text-3xl font-bold text-gray-800">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        
                        <!-- Stock Status -->
                        <div class="mb-6">
                            @if($product->stock_quantity > 0)
                                <span class="bg-green-100 text-green-800 text-sm font-semibold px-2.5 py-0.5 rounded">In Stock ({{ $product->stock_quantity }} available)</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-sm font-semibold px-2.5 py-0.5 rounded">Out of Stock</span>
                            @endif
                        </div>
                        
                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <!-- Size Selection -->
                            @if($product->sizes)
                                <div class="mb-4">
                                    <label for="size" class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                                    <div class="grid grid-cols-5 gap-2">
                                        @foreach(json_decode($product->sizes) as $size)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="size" value="{{ $size }}" class="sr-only peer" required>
                                                <div class="text-center py-2 border rounded-lg peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition-colors duration-200">
                                                    {{ $size }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Color Selection -->
                            @if($product->colors)
                                <div class="mb-4">
                                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach(json_decode($product->colors) as $color)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="color" value="{{ $color }}" class="sr-only peer" required>
                                                <div class="text-center py-2 border rounded-lg peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition-colors duration-200">
                                                    {{ $color }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Quantity -->
                            <div class="mb-4">
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <div class="flex items-center">
                                    <button type="button" class="decrement-qty bg-gray-200 px-3 py-2 rounded-l-lg">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-16 text-center border-t border-b py-2">
                                    <button type="button" class="increment-qty bg-gray-200 px-3 py-2 rounded-r-lg">+</button>
                                </div>
                            </div>
                            
                            <!-- Add to Cart Button -->
                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                                
                                @auth
                                    <button type="button" class="wishlist-toggle bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center" data-product-id="{{ $product->id }}">
                                        @if($product->isInWishlist())
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        @endif
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </a>
                                @endauth
                            </div>
                        </form>
                        
                        <!-- Product Features -->
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Features</h2>
                            <ul class="space-y-1 text-gray-600">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Brand: {{ $product->brand }}
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Surface Type: {{ $product->surface_type }}
                                </li>
                                @if($product->performance)
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Performance: {{ implode(', ', json_decode($product->performance)) }}
                                    </li>
                                @endif
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    SKU: {{ $product->sku }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Product Description</h2>
                <div class="prose max-w-none text-gray-600">
                    <p>{{ $product->description }}</p>
                </div>
            </div>

            <!-- Similar Products -->
            <x-product-recommendations title="Similar Products" :products="$similarProducts" />
            
            <!-- Frequently Bought Together -->
            <x-product-recommendations title="Frequently Bought Together" :products="$frequentlyBoughtTogether" />
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity increment/decrement
            const quantityInput = document.getElementById('quantity');
            const decrementBtn = document.querySelector('.decrement-qty');
            const incrementBtn = document.querySelector('.increment-qty');
            const maxQuantity = {{ $product->stock_quantity }};
            
            decrementBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
            
            incrementBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < maxQuantity) {
                    quantityInput.value = currentValue + 1;
                }
            });
        });
    </script>
</x-app-layout> 