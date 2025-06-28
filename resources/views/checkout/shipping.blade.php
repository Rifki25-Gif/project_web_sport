<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Checkout</h1>
                <div class="flex items-center mt-4">
                    <div class="flex items-center text-blue-600">
                        <span class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">1</span>
                        <span class="ml-2 font-medium">Shipping</span>
                    </div>
                    <div class="w-12 h-1 bg-gray-300 mx-4"></div>
                    <div class="flex items-center text-gray-400">
                        <span class="w-8 h-8 rounded-full bg-gray-300 text-white flex items-center justify-center font-bold">2</span>
                        <span class="ml-2 font-medium">Payment</span>
                    </div>
                    <div class="w-12 h-1 bg-gray-300 mx-4"></div>
                    <div class="flex items-center text-gray-400">
                        <span class="w-8 h-8 rounded-full bg-gray-300 text-white flex items-center justify-center font-bold">3</span>
                        <span class="ml-2 font-medium">Confirmation</span>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Shipping Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-6">Shipping Information</h2>
                            
                            <form action="{{ route('checkout.shipping') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', auth()->user()->name ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('first_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('last_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-6">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-6">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                        <input type="text" name="city" id="city" value="{{ old('city') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('city')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province *</label>
                                        <input type="text" name="state" id="state" value="{{ old('state') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('state')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal/ZIP Code *</label>
                                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @error('postal_code')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                        <select name="country" id="country" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Country</option>
                                            <option value="Indonesia" {{ old('country') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                            <option value="Malaysia" {{ old('country') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                            <option value="Singapore" {{ old('country') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                            <option value="Thailand" {{ old('country') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                            <option value="Vietnam" {{ old('country') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                        </select>
                                        @error('country')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mt-8 flex justify-end">
                                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700">
                                        Continue to Payment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-8">
                        <div class="p-4 border-b">
                            <h2 class="text-xl font-semibold text-gray-800">Order Summary</h2>
                        </div>
                        <div class="p-4">
                            <div class="space-y-4 mb-4">
                                @foreach($cart->items as $item)
                                    <div class="flex items-start">
                                        <div class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-md">
                                            @if($item->product->featured_image)
                                                <img src="{{ asset('storage/' . $item->product->featured_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @elseif($item->product->images && count(json_decode($item->product->images)) > 0)
                                                <img src="{{ asset('storage/' . json_decode($item->product->images)[0]) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                    No Image
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-sm font-medium text-gray-800">{{ $item->product->name }}</h3>
                                            <p class="text-xs text-gray-500">
                                                @if($item->size)
                                                    Size: {{ $item->size }}
                                                @endif
                                            </p>
                                            <div class="flex justify-between mt-1">
                                                <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                                <p class="text-sm font-medium text-gray-800">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">${{ number_format($cart->subtotal(), 2) }}</span>
                                </div>
                                
                                @if($cart->discount() > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>Discount</span>
                                        <span>-${{ number_format($cart->discount(), 2) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax (10%)</span>
                                    <span class="font-medium">${{ number_format($cart->tax(), 2) }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">$0.00</span>
                                </div>
                                
                                <div class="border-t pt-2 flex justify-between">
                                    <span class="text-lg font-bold text-gray-800">Total</span>
                                    <span class="text-lg font-bold text-gray-800">${{ number_format($cart->finalTotal(), 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 