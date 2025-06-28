<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Filters Sidebar -->
        <div class="md:w-1/4">
            <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                <h2 class="text-lg font-semibold mb-4">Filters</h2>
                
                <!-- Price Range -->
                <div class="mb-4">
                    <h3 class="font-medium text-gray-700 mb-2">Price Range</h3>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">${{ $minPrice }}</span>
                        <span class="text-sm text-gray-600">${{ $price }}</span>
                        <span class="text-sm text-gray-600">${{ $maxPrice }}</span>
                    </div>
                    <input type="range" wire:model.live="price" min="{{ $minPrice }}" max="{{ $maxPrice }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                </div>
                
                <!-- Brands -->
                <div class="mb-4">
                    <h3 class="font-medium text-gray-700 mb-2">Brands</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach($brands as $brand)
                            <label class="flex items-center">
                                <input type="checkbox" wire:model.live="selectedBrands" value="{{ $brand }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">{{ $brand }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Sizes -->
                <div class="mb-4">
                    <h3 class="font-medium text-gray-700 mb-2">Sizes</h3>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($sizes as $size)
                            <label class="inline-flex items-center">
                                <input type="checkbox" wire:model.live="selectedSizes" value="{{ $size }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">{{ $size }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Surface Type -->
                <div class="mb-4">
                    <h3 class="font-medium text-gray-700 mb-2">Surface Type</h3>
                    <div class="space-y-2">
                        @foreach($surfaceTypes as $type)
                            <label class="flex items-center">
                                <input type="checkbox" wire:model.live="selectedSurfaceTypes" value="{{ $type }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">{{ $type }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Performance Rating -->
                <div class="mb-4">
                    <h3 class="font-medium text-gray-700 mb-2">Performance Rating</h3>
                    <div class="space-y-2">
                        @foreach($performanceRatings as $rating)
                            <label class="flex items-center">
                                <input type="checkbox" wire:model.live="selectedPerformanceRatings" value="{{ $rating }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">{{ $rating }} Stars</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="md:w-3/4">
            <!-- Sort Options -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Shoes Collection</h1>
                <div class="flex items-center">
                    <label for="sort" class="mr-2 text-sm text-gray-600">Sort by:</label>
                    <select id="sort" wire:model.live="sortBy" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="newest">Newest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="name_asc">Name: A to Z</option>
                        <option value="name_desc">Name: Z to A</option>
                    </select>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="relative">
                            <a href="{{ route('products.show', $product) }}">
                                <img src="{{ $product->getFirstImage() }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                            </a>
                            
                            @if($product->sale_price)
                                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $product->discountPercentage() }}% OFF
                                </div>
                            @endif
                            
                            <button wire:click="addToWishlist({{ $product->id }})" class="absolute top-2 right-2 p-1 rounded-full bg-white shadow-md hover:bg-gray-100 {{ $this->isInWishlist($product->id) ? 'text-red-500' : 'text-gray-400' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <button wire:click="showQuickView({{ $product->id }})" class="absolute bottom-2 right-2 p-1 rounded-full bg-white shadow-md hover:bg-gray-100 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $product->brand }}</p>
                                </div>
                                <div class="text-right">
                                    @if($product->sale_price)
                                        <p class="text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</p>
                                        <p class="text-lg font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</p>
                                    @else
                                        <p class="text-lg font-bold text-gray-800">${{ number_format($product->price, 2) }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-2 flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    @if($product->rating)
                                        <div class="flex items-center">
                                            <span class="mr-1">{{ $product->rating }}</span>
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $product->rating)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div>
                                    @if($product->stock_quantity > 0)
                                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">In Stock</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-between">
                                <button wire:click="addToCart({{ $product->id }})" @if(!$product->inStock()) disabled @endif class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    @if($addingToCart === $product->id)
                                        <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    @else
                                        Add to Cart
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-gray-500">Try adjusting your filters or search criteria.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    
    <!-- Quick View Modal -->
    @if($quickViewOpen && $quickViewProduct)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeQuickView"></div>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="absolute top-0 right-0 pt-4 pr-4">
                        <button type="button" wire:click="closeQuickView" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="bg-white p-6 sm:p-6 sm:pb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Images -->
                            <div>
                                <div class="mb-4 aspect-square overflow-hidden rounded-lg">
                                    <img src="{{ $quickViewProduct->getFirstImage() }}" alt="{{ $quickViewProduct->name }}" class="w-full h-full object-cover">
                                </div>
                                
                                @if($quickViewProduct->images && count(json_decode($quickViewProduct->images)) > 1)
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach(array_slice(json_decode($quickViewProduct->images), 0, 4) as $image)
                                            <div class="aspect-square overflow-hidden rounded-md">
                                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $quickViewProduct->name }}" class="w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Details -->
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $quickViewProduct->name }}</h2>
                                <p class="text-gray-600 mb-4">{{ $quickViewProduct->brand }}</p>
                                
                                <div class="flex items-center mb-4">
                                    @if($quickViewProduct->rating)
                                        <div class="flex items-center">
                                            <span class="mr-1 font-medium">{{ $quickViewProduct->rating }}</span>
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $quickViewProduct->rating)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mb-4">
                                    @if($quickViewProduct->sale_price)
                                        <div class="flex items-center">
                                            <p class="text-2xl font-bold text-red-600 mr-2">${{ number_format($quickViewProduct->sale_price, 2) }}</p>
                                            <p class="text-gray-500 line-through">${{ number_format($quickViewProduct->price, 2) }}</p>
                                            <span class="ml-2 px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">{{ $quickViewProduct->discountPercentage() }}% OFF</span>
                                        </div>
                                    @else
                                        <p class="text-2xl font-bold text-gray-800">${{ number_format($quickViewProduct->price, 2) }}</p>
                                    @endif
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-1">Color</p>
                                    <p class="font-medium">{{ $quickViewProduct->color }}</p>
                                </div>
                                
                                @if($quickViewProduct->sizes)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">Size</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach(json_decode($quickViewProduct->sizes) as $size)
                                                <button type="button" wire:click="selectSize('{{ $size }}')" class="px-3 py-1 border rounded-md {{ $selectedSize === $size ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-300 text-gray-700' }}">
                                                    {{ $size }}
                                                </button>
                                            @endforeach
                                        </div>
                                        @if($stockError && $stockError === 'Please select a size')
                                            <p class="mt-1 text-sm text-red-600">{{ $stockError }}</p>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="mb-6">
                                    <p class="text-sm text-gray-600 mb-1">Quantity</p>
                                    <div class="flex items-center">
                                        <button type="button" wire:click="decrementQuantity" class="p-2 border border-gray-300 rounded-l-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div class="w-16 text-center py-2 border-t border-b border-gray-300">{{ $quantity }}</div>
                                        <button type="button" wire:click="incrementQuantity" class="p-2 border border-gray-300 rounded-r-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    @if($stockError && $stockError !== 'Please select a size')
                                        <p class="mt-1 text-sm text-red-600">{{ $stockError }}</p>
                                    @endif
                                </div>
                                
                                <div class="flex space-x-4">
                                    <button wire:click="addToCart({{ $quickViewProduct->id }})" @if(!$quickViewProduct->inStock()) disabled @endif class="flex-grow py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition disabled:opacity-50 disabled:cursor-not-allowed">
                                        @if($addingToCart === $quickViewProduct->id)
                                            <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        @else
                                            Add to Cart
                                        @endif
                                    </button>
                                    
                                    <button wire:click="addToWishlist({{ $quickViewProduct->id }})" class="py-3 px-4 border border-gray-300 rounded-md {{ $this->isInWishlist($quickViewProduct->id) ? 'text-red-600 border-red-300' : 'text-gray-600' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="mt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Product Details</h3>
                                    <div class="prose prose-sm max-w-none text-gray-700">
                                        <p>{{ $quickViewProduct->description }}</p>
                                    </div>
                                    
                                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                        @if($quickViewProduct->material)
                                            <div>
                                                <p class="text-gray-600">Material</p>
                                                <p class="font-medium">{{ $quickViewProduct->material }}</p>
                                            </div>
                                        @endif
                                        
                                        @if($quickViewProduct->surface_type)
                                            <div>
                                                <p class="text-gray-600">Surface Type</p>
                                                <p class="font-medium">{{ $quickViewProduct->surface_type }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Toast Notification -->
    <livewire:toast />
</div> 