<x-app-layout>
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <!-- Checkout Steps -->
            <div class="flex justify-center mb-8">
                <div class="flex items-center">
                    <div class="flex items-center text-blue-600">
                        <div class="bg-blue-600 rounded-full h-8 w-8 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="ml-2">Cart</span>
                    </div>
                    <div class="ml-12 flex items-center text-blue-600">
                        <div class="bg-blue-600 rounded-full h-8 w-8 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="ml-2">Shipping</span>
                    </div>
                    <div class="ml-12 flex items-center text-blue-600">
                        <div class="bg-blue-600 rounded-full h-8 w-8 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <span class="ml-2 font-semibold">Payment</span>
                    </div>
                    <div class="ml-12 flex items-center text-gray-400">
                        <div class="border-2 border-gray-400 rounded-full h-8 w-8 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="ml-2">Confirmation</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Payment Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-6">Payment</h2>
                        
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif
                        
                        <form action="{{ route('checkout.payment') }}" method="POST" id="payment-form">
                            @csrf
                            
                            <!-- Shipping Address Review -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Shipping to:</h3>
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <p><span class="font-semibold">{{ $shipping['first_name'] }} {{ $shipping['last_name'] }}</span></p>
                                    <p>{{ $shipping['address'] }}</p>
                                    <p>{{ $shipping['city'] }}, {{ $shipping['state'] }} {{ $shipping['postal_code'] }}</p>
                                    <p>{{ $shipping['country'] }}</p>
                                    <p class="mt-1">{{ $shipping['email'] }}</p>
                                    <p>{{ $shipping['phone'] }}</p>
                                </div>
                            </div>
                            
                            <!-- Dummy Payment Notice -->
                            <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h3 class="font-bold text-blue-700 text-lg mb-2">Development Mode</h3>
                                <p class="text-blue-700 mb-2">This is a dummy payment system for development purposes.</p>
                                <p class="text-blue-700">No real payment will be processed. Click "Place Order" to simulate a successful payment.</p>
                                
                                <input type="hidden" name="payment_method" value="dummy">
                            </div>
                            
                            <div class="mt-8 flex justify-between">
                                <a href="{{ route('checkout.shipping') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300">
                                    Back to Shipping
                                </a>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-300">
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                        <div class="border-b pb-4">
                            @foreach($cart->items as $item)
                                <div class="flex py-2">
                                    <div class="w-16 h-16 flex-shrink-0">
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <h3 class="text-sm font-semibold">{{ $item->product->name }}</h3>
                                        <p class="text-xs text-gray-500">{{ $item->size }} {{ $item->color ? '/ ' . $item->color : '' }}</p>
                                        <div class="flex justify-between mt-1 text-sm">
                                            <p>{{ $item->quantity }} x ${{ number_format($item->price, 2) }}</p>
                                            <p>${{ number_format($item->quantity * $item->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">${{ number_format($cart->subtotal(), 2) }}</span>
                            </div>
                            @if($cart->discount() > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Discount</span>
                                    <span>-${{ number_format($cart->discount(), 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (10%)</span>
                                <span class="font-semibold">${{ number_format($cart->tax(), 2) }}</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between font-bold">
                                <span>Total</span>
                                <span>${{ number_format($cart->finalTotal(), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 