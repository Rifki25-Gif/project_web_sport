<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Your Shopping Cart</h1>
        
        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-4 border-b">
                            <h2 class="text-xl font-semibold text-gray-800">Cart Items ({{ count($cartItems) }})</h2>
                        </div>
                        
                        <ul>
                            @foreach($cartItems as $item)
                                <li class="border-b last:border-b-0 p-4" wire:key="cart-item-{{ $item->id }}">
                                    <div class="flex flex-col md:flex-row items-center gap-4">
                                        <div class="w-24 h-24 flex-shrink-0">
                                            @if($item->product->featured_image)
                                                <img src="{{ asset('storage/' . $item->product->featured_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                            @elseif($item->product->images && count(json_decode($item->product->images)) > 0)
                                                <img src="{{ asset('storage/' . json_decode($item->product->images)[0]) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                            @else
                                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500 rounded">
                                                    No Image
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                            <p class="text-gray-600 text-sm">Brand: {{ $item->product->brand }}</p>
                                            @if($item->size)
                                                <p class="text-gray-600 text-sm">Size: {{ $item->size }}</p>
                                            @endif
                                            @if($item->color)
                                                <p class="text-gray-600 text-sm">Color: {{ $item->product->color }}</p>
                                            @endif
                                            <div class="mt-2 flex flex-wrap items-center gap-4">
                                                <div class="flex items-center border rounded-md">
                                                    <button type="button" wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                                    <div class="w-10 text-center py-1 relative">
                                                        <span @class(['opacity-0' => $updatingQuantity === $item->id])>{{ $item->quantity }}</span>
                                                        @if($updatingQuantity === $item->id)
                                                            <div class="absolute inset-0 flex items-center justify-center">
                                                                <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <button type="button" wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                                </div>
                                                <div>
                                                    <span class="font-semibold text-gray-800">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                                    <span class="text-sm text-gray-500">${{ number_format($item->price, 2) }} each</span>
                                                </div>
                                                <button type="button" wire:click="removeItem({{ $item->id }})" class="text-red-600 hover:text-red-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-8">
                        <div class="p-4 border-b">
                            <h2 class="text-xl font-semibold text-gray-800">Order Summary</h2>
                        </div>
                        <div class="p-4 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold text-gray-800">${{ number_format($cart->subtotal(), 2) }}</span>
                            </div>
                            
                            @if($couponApplied)
                                <div class="flex justify-between text-green-600">
                                    <span>Discount</span>
                                    <span>-${{ number_format($cart->discount(), 2) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (10%)</span>
                                <span class="font-semibold text-gray-800">${{ number_format($cart->tax(), 2) }}</span>
                            </div>
                            
                            <div class="border-t pt-4 flex justify-between">
                                <span class="text-lg font-bold text-gray-800">Total</span>
                                <span class="text-lg font-bold text-gray-800">${{ number_format($cart->finalTotal(), 2) }}</span>
                            </div>
                            
                            <!-- Coupon Code -->
                            <div class="mt-6">
                                <label for="coupon" class="block text-sm font-medium text-gray-700 mb-1">Promo/Coupon Code</label>
                                <div class="flex space-x-2">
                                    <input type="text" id="coupon" wire:model="couponCode" @disabled($couponApplied) class="flex-grow px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100 disabled:text-gray-500">
                                    @if($couponApplied)
                                        <button type="button" wire:click="removeCoupon" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Remove</button>
                                    @else
                                        <button type="button" wire:click="applyCoupon" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Apply</button>
                                    @endif
                                </div>
                                @if($couponMessage)
                                    <p class="mt-1 text-sm {{ $couponApplied ? 'text-green-600' : 'text-red-600' }}">{{ $couponMessage }}</p>
                                @endif
                            </div>
                            
                            <a href="{{ route('checkout.shipping') }}" class="block w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md text-center transition">
                                Proceed to Checkout
                            </a>
                            
                            <a href="{{ route('products.index') }}" class="block w-full py-3 px-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-md text-center transition">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="mt-4 text-2xl font-semibold text-gray-800">Your cart is empty</h2>
                <p class="mt-2 text-gray-600">Looks like you haven't added any shoes to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="mt-6 inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
