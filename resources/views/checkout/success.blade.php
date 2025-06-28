<x-app-layout>
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8">
                <!-- Development Mode Notice -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong class="font-bold">Development Mode:</strong> This is a dummy transaction for testing purposes.
                                <br>
                                No actual payment has been processed.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mb-8">
                    <div class="bg-green-100 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Thank You For Your Order!</h1>
                    <p class="text-lg text-gray-600">Your order has been placed successfully.</p>
                </div>

                <div class="border-t border-b py-4 mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Order Number:</span>
                        <span>{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Date:</span>
                        <span>{{ $order->created_at->format('F j, Y') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Total:</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="font-medium">Payment Method:</span>
                        <span>{{ ucfirst($order->payment_method) }} (Test)</span>
                    </div>
                    @php
                        $paymentDetails = json_decode($order->payment_details, true);
                    @endphp
                    @if(isset($paymentDetails['transaction_id']))
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Transaction ID:</span>
                            <span>{{ $paymentDetails['transaction_id'] }}</span>
                        </div>
                    @endif
                    @if(isset($paymentDetails['payment_status']))
                        <div class="flex justify-between">
                            <span class="font-medium">Payment Status:</span>
                            <span class="text-green-600 font-semibold">{{ ucfirst($paymentDetails['payment_status']) }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">Order Details</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex border-b pb-4">
                                <div class="w-20 h-20 flex-shrink-0">
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                </div>
                                <div class="ml-4 flex-grow">
                                    <h3 class="font-medium">{{ $item->product->name }}</h3>
                                    @php
                                        $options = json_decode($item->options, true);
                                    @endphp
                                    <p class="text-sm text-gray-500">
                                        Size: {{ $options['size'] ?? 'N/A' }} 
                                        @if(isset($options['color'])) 
                                            | Color: {{ $options['color'] }}
                                        @endif
                                    </p>
                                    <div class="flex justify-between mt-2 text-sm">
                                        <p>{{ $item->quantity }} x ${{ number_format($item->price, 2) }}</p>
                                        <p class="font-semibold">${{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span>-${{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span>Tax</span>
                            <span>${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="border-t pt-2 mt-2 flex justify-between font-bold">
                            <span>Total</span>
                            <span>${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                    @php
                        $shipping = json_decode($order->shipping_address, true);
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="font-medium">{{ $shipping['first_name'] }} {{ $shipping['last_name'] }}</p>
                            <p>{{ $shipping['address'] }}</p>
                            <p>{{ $shipping['city'] }}, {{ $shipping['state'] }} {{ $shipping['postal_code'] }}</p>
                            <p>{{ $shipping['country'] }}</p>
                        </div>
                        <div>
                            <p><span class="font-medium">Email:</span> {{ $shipping['email'] }}</p>
                            <p><span class="font-medium">Phone:</span> {{ $shipping['phone'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-gray-600 mb-4">We've sent a confirmation email to {{ $shipping['email'] }}.</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('welcome') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                            Continue Shopping
                        </a>
                        <a href="{{ route('account.orders') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300">
                            View My Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 