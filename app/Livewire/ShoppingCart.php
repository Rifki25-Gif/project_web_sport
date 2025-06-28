<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShoppingCart extends Component
{
    public $cart;
    public $cartItems = [];
    public $couponCode = '';
    public $couponApplied = false;
    public $couponMessage = '';
    public $updatingQuantity = null;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        $this->cart = Cart::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })
        ->where('is_checked_out', false)
        ->first();

        if ($this->cart) {
            $this->cartItems = $this->cart->items()->with('product')->get();
            $this->couponCode = $this->cart->coupon_code ?? '';
            $this->couponApplied = !empty($this->cart->coupon_code);
        } else {
            $this->cartItems = [];
            $this->couponCode = '';
            $this->couponApplied = false;
        }
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $this->updatingQuantity = $cartItemId;

        if ($quantity < 1) {
            $quantity = 1;
        }

        if (!$this->cart) {
            $this->updatingQuantity = null;
            return;
        }

        $cartItem = $this->cart->items()->find($cartItemId);
        if (!$cartItem) {
            $this->updatingQuantity = null;
            return;
        }

        // Check if quantity exceeds available stock
        $product = $cartItem->product;
        if ($quantity > $product->stock_quantity) {
            $this->dispatch('show-toast', [
                'message' => "Only {$product->stock_quantity} items available in stock",
                'type' => 'error'
            ]);
            $this->updatingQuantity = null;
            return;
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        $this->loadCart();
        $this->dispatch('cart-updated', ['count' => $this->cart->totalItems()]);
        $this->updatingQuantity = null;
    }

    public function removeItem($cartItemId)
    {
        if (!$this->cart) {
            return;
        }

        $cartItem = $this->cart->items()->find($cartItemId);
        if (!$cartItem) {
            return;
        }

        $cartItem->delete();
        $this->loadCart();
        $this->dispatch('cart-updated', ['count' => $this->cart ? $this->cart->totalItems() : 0]);
        $this->dispatch('show-toast', ['message' => 'Item removed from cart', 'type' => 'success']);
    }

    public function applyCoupon()
    {
        if (empty($this->couponCode)) {
            $this->couponMessage = 'Please enter a coupon code';
            return;
        }

        // Simple coupon logic - in a real app, you'd check against a database of valid coupons
        $validCoupons = [
            'SHOE10' => 10,
            'SHOE20' => 20,
            'WELCOME15' => 15
        ];

        if (array_key_exists(strtoupper($this->couponCode), $validCoupons)) {
            $discountValue = $validCoupons[strtoupper($this->couponCode)];
            $discountAmount = ($this->cart->subtotal() * $discountValue) / 100;

            $this->cart->coupon_code = strtoupper($this->couponCode);
            $this->cart->coupon_value = $discountAmount;
            $this->cart->save();

            $this->couponApplied = true;
            $this->couponMessage = "Coupon applied! You saved $" . number_format($discountAmount, 2);
            $this->dispatch('show-toast', ['message' => 'Coupon applied successfully', 'type' => 'success']);
        } else {
            $this->couponApplied = false;
            $this->couponMessage = 'Invalid coupon code';
            $this->dispatch('show-toast', ['message' => 'Invalid coupon code', 'type' => 'error']);
        }

        $this->loadCart();
    }

    public function removeCoupon()
    {
        if ($this->cart) {
            $this->cart->coupon_code = null;
            $this->cart->coupon_value = null;
            $this->cart->save();

            $this->couponApplied = false;
            $this->couponCode = '';
            $this->couponMessage = '';
            $this->dispatch('show-toast', ['message' => 'Coupon removed', 'type' => 'info']);
            $this->loadCart();
        }
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
