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
                            <span class="ml-1 text-gray-500 md:ml-2">Categories</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-gray-500 md:ml-2">{{ $category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Category Header -->
            <div class="relative rounded-xl overflow-hidden mb-8">
                @if (Str::startsWith($category->image, ['http://', 'https://']))
                    <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-64 object-cover">
                @elseif ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No image</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-8">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $category->name }}</h1>
                    <p class="text-white/80 text-lg max-w-2xl">{{ $category->description }}</p>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden group transform transition-transform duration-300 hover:scale-105">
                        <a href="{{ route('products.show', $product) }}">
                            <div class="relative">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                                @if ($product->is_new)
                                    <div class="absolute top-0 left-0 bg-blue-600 text-white py-1 px-3 m-2 rounded-full text-sm font-bold">New</div>
                                @endif
                                @if ($product->is_on_sale)
                                    <div class="absolute top-0 right-0 bg-red-600 text-white py-1 px-3 m-2 rounded-full text-sm font-bold">Sale</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $product->brand }}</p>
                                <div class="flex justify-between items-center">
                                    @if ($product->sale_price)
                                        <div>
                                            <span class="text-lg font-bold text-gray-800">${{ number_format($product->sale_price, 2) }}</span>
                                            <span class="text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                        </div>
                                    @else
                                        <span class="text-lg font-bold text-gray-800">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-10 h-10 flex items-center justify-center transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <h2 class="text-2xl font-bold text-gray-600">No products found in this category</h2>
                        <p class="text-gray-500 mt-2">Check back later for new arrivals.</p>
                        <a href="{{ route('products.index') }}" class="mt-6 inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition">
                            Browse All Products
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 