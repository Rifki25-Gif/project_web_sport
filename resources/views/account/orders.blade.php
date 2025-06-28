<x-account-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order History') }}
        </h2>
    </x-slot>

    <div class="space-y-6" x-data="{ showDetail: false, selectedOrder: null }">
        <!-- Orders List -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @php
                    $orders = [
                        ['id' => 'WU88191111', 'date' => 'January 22, 2021', 'datetime' => '2021-01-22', 'status' => 'Completed', 'total' => '120.00', 'products' => [
                            ['id' => 1, 'name' => 'Running Shoes', 'href' => '#', 'price' => '75.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/order-history-page-02-product-01.jpg', 'imageAlt' => 'Gray canvas low-top sneakers with white laces and rubber sole.'],
                            ['id' => 2, 'name' => 'Athletic Shorts', 'href' => '#', 'price' => '45.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/order-history-page-02-product-02.jpg', 'imageAlt' => 'Black athletic shorts with white drawstring.'],
                        ],
                        'shipping_address' => [
                            'name' => 'John Doe',
                            'street' => '123 Main St',
                            'city' => 'Sportsville',
                            'state' => 'CA',
                            'zip' => '12345',
                            'country' => 'USA'
                        ],
                        'payment_method' => 'Credit Card',
                        'tracking' => [
                            ['status' => 'Order Placed', 'date' => 'January 18, 2021', 'description' => 'Your order has been received'],
                            ['status' => 'Processing', 'date' => 'January 19, 2021', 'description' => 'Your order is being processed'],
                            ['status' => 'Shipped', 'date' => 'January 20, 2021', 'description' => 'Your order has been shipped', 'tracking_number' => 'TRK12345678'],
                            ['status' => 'Delivered', 'date' => 'January 22, 2021', 'description' => 'Your order has been delivered']
                        ]],
                        ['id' => 'WU88191112', 'date' => 'February 5, 2022', 'datetime' => '2022-02-05', 'status' => 'Processing', 'total' => '90.00', 'products' => [
                            ['id' => 1, 'name' => 'Performance T-Shirt', 'href' => '#', 'price' => '35.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg', 'imageAlt' => 'Front of men\'s Basic Tee in black.'],
                            ['id' => 2, 'name' => 'Sports Water Bottle', 'href' => '#', 'price' => '15.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-01.jpg', 'imageAlt' => 'Tall slender porcelain bottle with natural clay textured body and cork stopper.'],
                            ['id' => 3, 'name' => 'Yoga Mat', 'href' => '#', 'price' => '40.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-02.jpg', 'imageAlt' => 'Olive drab green insulated bottle with flared screw lid and flat top.'],
                        ],
                        'shipping_address' => [
                            'name' => 'John Doe',
                            'street' => '123 Main St',
                            'city' => 'Sportsville',
                            'state' => 'CA',
                            'zip' => '12345',
                            'country' => 'USA'
                        ],
                        'payment_method' => 'PayPal',
                        'tracking' => [
                            ['status' => 'Order Placed', 'date' => 'February 1, 2022', 'description' => 'Your order has been received'],
                            ['status' => 'Processing', 'date' => 'February 3, 2022', 'description' => 'Your order is being processed']
                        ]],
                    ];
                @endphp

                @foreach ($orders as $order)
                    <li>
                        <div class="px-4 py-5 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-blue-600 dark:text-blue-400 truncate">
                                    Order #{{ $order['id'] }}
                                </div>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order['status'] === 'Completed') bg-green-100 text-green-800 @endif
                                        @if($order['status'] === 'Processing') bg-yellow-100 text-yellow-800 @endif
                                        @if($order['status'] === 'Cancelled') bg-red-100 text-red-800 @endif
                                    ">
                                        {{ $order['status'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-1 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <time datetime="{{ $order['datetime'] }}">{{ $order['date'] }}</time>
                                    </p>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                                    <p>Total: <span class="font-medium text-gray-900 dark:text-white">${{ $order['total'] }}</span></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:px-6">
                            <div class="grid grid-cols-1 md:grid-cols-6 gap-y-6 gap-x-4">
                                @foreach ($order['products'] as $product)
                                    <div class="md:col-span-2 flex items-start space-x-4">
                                        <img src="{{ $product['imageSrc'] }}" alt="{{ $product['imageAlt'] }}" class="h-20 w-20 rounded-md object-cover object-center">
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-900 dark:text-white">{{ $product['name'] }}</h5>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">${{ $product['price'] }} × {{ $product['quantity'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4 sm:px-6 flex justify-between items-center">
                            <a href="{{ route('account.orders.show', $order['id']) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 focus:outline-none focus:underline transition-colors duration-300">
                                View Order Details
                            </a>
                            
                            <button @click="showDetail = true; selectedOrder = {{ json_encode($order) }}" type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 focus:outline-none focus:underline transition-colors duration-300">
                                Quick View
                            </button>
                            
                            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                                Track Order
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <!-- Order Detail Modal -->
        <div x-show="showDetail" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50" style="display: none;" x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto" @click.away="showDetail = false">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white" x-text="'Order #' + selectedOrder?.id"></h2>
                        <button @click="showDetail = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Date</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="selectedOrder?.date"></p>
                        </div>
                        <div class="flex justify-between mb-2">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                            <p class="text-sm font-medium" 
                                :class="{
                                    'text-green-600': selectedOrder?.status === 'Completed',
                                    'text-yellow-600': selectedOrder?.status === 'Processing',
                                    'text-red-600': selectedOrder?.status === 'Cancelled'
                                }"
                                x-text="selectedOrder?.status"></p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Payment Method</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="selectedOrder?.payment_method"></p>
                        </div>
                    </div>
                    
                    <!-- Products -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-3">Items</h3>
                        <div class="space-y-4">
                            <template x-for="(product, index) in selectedOrder?.products" :key="index">
                                <div class="flex space-x-4">
                                    <img :src="product.imageSrc" :alt="product.imageAlt" class="h-16 w-16 rounded-md object-cover object-center">
                                    <div class="flex-grow flex flex-col">
                                        <h4 x-text="product.name" class="text-sm font-medium text-gray-900 dark:text-white"></h4>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            <span x-text="`$${product.price}`"></span>
                                            <span x-show="product.quantity > 1" x-text="` × ${product.quantity}`"></span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="'$' + (parseFloat(product.price) * product.quantity).toFixed(2)"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="border-t border-gray-200 dark:border-gray-700 mt-6 pt-4">
                            <div class="flex justify-between mb-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Subtotal</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="'$' + selectedOrder?.total"></p>
                            </div>
                            <div class="flex justify-between mb-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Shipping</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">$0.00</p>
                            </div>
                            <div class="flex justify-between mb-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tax</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">$0.00</p>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 mt-2 pt-2">
                                <p class="text-base font-medium text-gray-900 dark:text-white">Total</p>
                                <p class="text-base font-bold text-gray-900 dark:text-white" x-text="'$' + selectedOrder?.total"></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Shipping Information -->
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-3">Shipping Information</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-900 dark:text-white" x-text="selectedOrder?.shipping_address.name"></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="selectedOrder?.shipping_address.street"></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="selectedOrder?.shipping_address.city + ', ' + selectedOrder?.shipping_address.state + ' ' + selectedOrder?.shipping_address.zip"></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="selectedOrder?.shipping_address.country"></p>
                        </div>
                    </div>
                    
                    <!-- Order Tracking -->
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white mb-3">Order Tracking</h3>
                        <div class="relative pb-2">
                            <div class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                            
                            <template x-for="(step, index) in selectedOrder?.tracking" :key="index">
                                <div class="relative flex items-start mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4 min-w-0 flex-1">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            <span x-text="step.status"></span>
                                            <span class="text-gray-500 dark:text-gray-400 text-xs ml-2" x-text="step.date"></span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400" x-text="step.description"></p>
                                        <p x-show="step.tracking_number" class="text-sm text-blue-600 dark:text-blue-400">
                                            Tracking Number: <span x-text="step.tracking_number"></span>
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end space-x-3">
                        <button @click="showDetail = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-300">
                            Close
                        </button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-300">
                            Download Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        // Additional JavaScript functionality can be added here
        // For example, you might want to implement invoice download or order tracking features
    </script>
    @endpush
</x-account-layout> 