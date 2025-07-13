{{--
    CATATAN: Route 'account.wishlist' tidak ada. File ini kemungkinan tidak digunakan.
--}}
<x-account-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wishlist') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (count($wishlistItems) > 0)
            <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                @foreach ($wishlistItems as $item)
                    <div class="group relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col hover:shadow-xl transition-shadow duration-300">
                        <div class="w-full min-h-80 bg-gray-200 dark:bg-gray-700 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
                            <img src="{{ $item->product->featured_image }}" alt="{{ $item->product->name }}" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700 dark:text-gray-200">
                                    <a href="{{ route('products.show', $item->product->slug) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $item->product->brand }}</p>
                            </div>
                            <div>
                                @if($item->product->sale_price)
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">${{ $item->product->sale_price }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 line-through">${{ $item->product->price }}</p>
                                @else
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">${{ $item->product->price }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-6 flex-1 flex items-end">
                            <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                @if ($item->product->stock_quantity > 0)
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-300">
                                        Add to cart
                                    </button>
                                @else
                                    <button type="button" class="w-full bg-gray-400 cursor-not-allowed text-white font-bold py-2 px-4 rounded">
                                        Out of stock
                                    </button>
                                @endif
                            </form>
                        </div>
                        <div class="absolute top-0 right-0 p-2">
                            <form action="{{ route('account.wishlist.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors duration-300">
                                    <span class="sr-only">Remove</span>
                                    <!-- Heroicon name: solid/x-circle -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Stock badge -->
                        @if ($item->product->stock_quantity <= 0)
                            <div class="absolute bottom-0 left-0 right-0 bg-red-600 text-white text-center py-1 text-sm font-bold">
                                Out of Stock
                            </div>
                        @elseif ($item->product->stock_quantity <= 5)
                            <div class="absolute bottom-0 left-0 right-0 bg-yellow-500 text-white text-center py-1 text-sm font-bold">
                                Low Stock: {{ $item->product->stock_quantity }} left
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Your wishlist is empty</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start adding products you love.</p>
                <div class="mt-6">
                    <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <!-- Heroicon name: solid/plus -->
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Browse Products
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-account-layout> 