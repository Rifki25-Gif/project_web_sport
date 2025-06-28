<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Product Details</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Edit Product</a>
                            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Back to Products</a>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Product Images -->
                        <div class="md:col-span-1">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Product Images</h3>
                                
                                @if($product->featured_image)
                                    <div class="mb-4">
                                        <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg">
                                    </div>
                                @endif
                                
                                @if($product->images && count(json_decode($product->images)) > 0)
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach(json_decode($product->images) as $image)
                                            <div class="aspect-square overflow-hidden rounded-md">
                                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                @if(!$product->featured_image && (!$product->images || count(json_decode($product->images)) === 0))
                                    <div class="bg-gray-200 aspect-square flex items-center justify-center rounded-lg">
                                        <span class="text-gray-500">No images available</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Product Information -->
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Basic Information</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Name</p>
                                        <p class="font-medium">{{ $product->name }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">SKU</p>
                                        <p class="font-medium">{{ $product->sku }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Category</p>
                                        <p class="font-medium">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Brand</p>
                                        <p class="font-medium">{{ $product->brand }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Price</p>
                                        <p class="font-medium">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Sale Price</p>
                                        <p class="font-medium">
                                            @if($product->sale_price)
                                                ${{ number_format($product->sale_price, 2) }}
                                                <span class="text-green-600 text-sm">({{ $product->discountPercentage() }}% off)</span>
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Stock Quantity</p>
                                        <p class="font-medium">
                                            @if($product->stock_quantity > 10)
                                                <span class="text-green-600">{{ $product->stock_quantity }}</span>
                                            @elseif($product->stock_quantity > 0)
                                                <span class="text-yellow-600">{{ $product->stock_quantity }}</span>
                                            @else
                                                <span class="text-red-600">Out of stock</span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Status</p>
                                        <p class="font-medium">
                                            @if($product->is_active)
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Featured</p>
                                        <p class="font-medium">
                                            @if($product->is_featured)
                                                <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">Yes</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">No</span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Created At</p>
                                        <p class="font-medium">{{ $product->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Last Updated</p>
                                        <p class="font-medium">{{ $product->updated_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Shoe Details</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Material</p>
                                        <p class="font-medium">{{ $product->material }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Color</p>
                                        <p class="font-medium">{{ $product->color }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Surface Type</p>
                                        <p class="font-medium">{{ $product->surface_type ?? '-' }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-600">Performance Rating</p>
                                        <p class="font-medium">
                                            @if($product->performance_rating)
                                                <div class="flex items-center">
                                                    <span class="mr-1">{{ $product->performance_rating }}/5</span>
                                                    <div class="flex text-yellow-400">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $product->performance_rating)
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @elseif($i - 0.5 <= $product->performance_rating)
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
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <p class="text-sm text-gray-600">Available Sizes</p>
                                        <div class="flex flex-wrap gap-2 mt-1">
                                            @if($product->sizes)
                                                @foreach(json_decode($product->sizes) as $size)
                                                    <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">{{ $size }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-gray-500">No sizes specified</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Product Description</h3>
                                
                                <div class="prose max-w-none">
                                    {!! $product->description ?? '<p class="text-gray-500">No description available</p>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 