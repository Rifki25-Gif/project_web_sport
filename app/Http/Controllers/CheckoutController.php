<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function shipping()
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        return view('checkout.shipping', [
            'cart' => $cart,
        ]);
    }

    public function processShipping(Request $request)
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);
        
        // Store shipping details in session
        Session::put('checkout_shipping', $validated);
        
        return redirect()->route('checkout.payment');
    }

    public function payment()
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        // Check if shipping details are present
        if (!Session::has('checkout_shipping')) {
            return redirect()->route('checkout.shipping');
        }
        
        return view('checkout.payment', [
            'cart' => $cart,
            'shipping' => Session::get('checkout_shipping'),
        ]);
    }

    public function processPayment(Request $request)
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        // Check if shipping details are present
        if (!Session::has('checkout_shipping')) {
            return redirect()->route('checkout.shipping');
        }
        
        $validated = $request->validate([
            'payment_method' => 'required|string|in:dummy',
        ]);
        
        // Generate dummy payment information
        $paymentDetails = [
            'payment_method' => 'dummy',
            'transaction_id' => 'DEV-' . strtoupper(Str::random(10)),
            'payment_status' => 'completed',
            'payment_date' => now()->format('Y-m-d H:i:s'),
            'is_test' => true
        ];
        
        // Store payment details in session
        Session::put('checkout_payment', $paymentDetails);
        
        // Create order
        $order = $this->createOrder($cart);
        
        // Mark cart as checked out
        $cart->is_checked_out = true;
        $cart->save();
        
        // Store order ID in session
        Session::put('last_order_id', $order->id);
        
        return redirect()->route('checkout.success');
    }

    public function success()
    {
        // Check if order ID is in session
        if (!Session::has('last_order_id')) {
            return redirect()->route('welcome');
        }
        
        $orderId = Session::get('last_order_id');
        $order = Order::with('items.product')->find($orderId);
        
        // Clear checkout session data
        Session::forget(['checkout_shipping', 'checkout_payment', 'last_order_id']);
        
        return view('checkout.success', [
            'order' => $order,
        ]);
    }
    
    private function getCart()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        $cart = Cart::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })
        ->where('is_checked_out', false)
        ->with('items.product')
        ->first();
        
        return $cart;
    }
    
    private function createOrder($cart)
    {
        $shipping = Session::get('checkout_shipping');
        $payment = Session::get('checkout_payment');
        
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => 'pending',
            'shipping_address' => json_encode([
                'first_name' => $shipping['first_name'],
                'last_name' => $shipping['last_name'],
                'email' => $shipping['email'],
                'phone' => $shipping['phone'],
                'address' => $shipping['address'],
                'city' => $shipping['city'],
                'state' => $shipping['state'],
                'postal_code' => $shipping['postal_code'],
                'country' => $shipping['country'],
            ]),
            'payment_method' => $payment['payment_method'],
            'payment_details' => json_encode($payment),
            'subtotal' => $cart->subtotal(),
            'discount' => $cart->discount(),
            'tax' => $cart->tax(),
            'total' => $cart->finalTotal(),
        ]);
        
        // Create order items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->quantity * $item->price,
                'options' => json_encode([
                    'size' => $item->size,
                    'color' => $item->color,
                ]),
            ]);
        }
        
        return $order;
    }
}
