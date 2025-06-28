<x-account-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Order Header -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <div class="flex flex-col sm:flex-row justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Order #{{ $order['id'] }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                            Placed on {{ $order['date'] }}
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            @if($order['status'] === 'Completed') bg-green-100 text-green-800 @endif
                            @if($order['status'] === 'Processing') bg-yellow-100 text-yellow-800 @endif
                            @if($order['status'] === 'Shipped') bg-blue-100 text-blue-800 @endif
                            @if($order['status'] === 'Cancelled') bg-red-100 text-red-800 @endif
                        ">
                            {{ $order['status'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Order Summary -->
                    <div class="col-span-2">
                        <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Order Summary</h4>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 overflow-hidden shadow rounded-lg divide-y divide-gray-200 dark:divide-gray-600">
                            <!-- Order Items -->
                            @foreach($order['products'] as $product)
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-16 w-16 rounded-md object-cover" 
                                                 src="{{ $product['imageSrc'] }}" 
                                                 alt="{{ $product['imageAlt'] }}">
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $product['name'] }}
                                                    </h5>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        Quantity: {{ $product['quantity'] }}
                                                    </p>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                        ${{ number_format((float)$product['price'] * $product['quantity'], 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Order Totals -->
                            <div class="px-4 py-4 sm:px-6 bg-gray-100 dark:bg-gray-600">
                                <div class="flex justify-between text-sm">
                                    <p class="text-gray-500 dark:text-gray-400">Subtotal</p>
                                    <p class="font-medium text-gray-900 dark:text-white">${{ $order['total'] }}</p>
                                </div>
                                <div class="flex justify-between text-sm mt-2">
                                    <p class="text-gray-500 dark:text-gray-400">Shipping</p>
                                    <p class="font-medium text-gray-900 dark:text-white">$0.00</p>
                                </div>
                                <div class="flex justify-between text-sm mt-2">
                                    <p class="text-gray-500 dark:text-gray-400">Tax</p>
                                    <p class="font-medium text-gray-900 dark:text-white">$0.00</p>
                                </div>
                                <div class="flex justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-500">
                                    <p class="text-base font-medium text-gray-900 dark:text-white">Total</p>
                                    <p class="text-base font-bold text-gray-900 dark:text-white">${{ $order['total'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="col-span-1">
                        <!-- Shipping Address -->
                        <div class="mb-6">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Shipping Address</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <p class="text-sm text-gray-900 dark:text-white">{{ $order['shipping_address']['name'] }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order['shipping_address']['street'] }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $order['shipping_address']['city'] }}, {{ $order['shipping_address']['state'] }} {{ $order['shipping_address']['zip'] }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order['shipping_address']['country'] }}</p>
                            </div>
                        </div>
                        
                        <!-- Payment Information -->
                        <div class="mb-6">
                            <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Payment Information</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <p class="text-sm text-gray-900 dark:text-white">{{ $order['payment_method'] }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Order Total: ${{ $order['total'] }}</p>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="mt-6">
                            <a href="#" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                                Download Invoice
                            </a>
                            @if($order['status'] === 'Processing' || $order['status'] === 'Shipped')
                                <a href="#" class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                                    Track Package
                                </a>
                            @endif
                            <a href="{{ route('account.orders') }}" class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                                Back to Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Tracking -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Order Tracking
                </h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <div class="relative">
                        <!-- Vertical Line -->
                        <div class="hidden sm:block absolute top-0 left-0 h-full w-px bg-gray-200 dark:bg-gray-700" aria-hidden="true"></div>

                        <ul role="list" class="-mb-8">
                            @foreach($order['tracking'] as $index => $step)
                                <li>
                                    <div class="relative pb-8">
                                        @if($index != count($order['tracking']) - 1)
                                            <div class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></div>
                                        @endif
                                        <div class="relative flex items-start space-x-3">
                                            <div>
                                                <div class="relative px-1">
                                                    <div class="h-8 w-8 bg-blue-500 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1 py-1.5">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    <div class="font-medium text-gray-900 dark:text-white">
                                                        {{ $step['status'] }}
                                                    </div>
                                                    <span class="text-gray-500 dark:text-gray-400">{{ $step['date'] }}</span>
                                                </div>
                                                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                                    <p>{{ $step['description'] }}</p>
                                                    @if(isset($step['tracking_number']))
                                                        <p class="mt-2 text-blue-600 dark:text-blue-400">
                                                            Tracking Number: {{ $step['tracking_number'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Need Help Section -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Need Help?
                </h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <h4 class="text-base font-medium text-gray-900 dark:text-white">
                                Return or Exchange
                            </h4>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Not satisfied with your purchase? You can return or exchange items within 30 days.
                            </p>
                            <div class="mt-3">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                                    Start a Return
                                </a>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-base font-medium text-gray-900 dark:text-white">
                                Contact Support
                            </h4>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Have questions about your order? Our support team is here to help.
                            </p>
                            <div class="mt-3">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                                    Contact Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-account-layout> 