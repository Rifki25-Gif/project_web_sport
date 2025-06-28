<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartIcon extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cart-updated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount($params = null)
    {
        if ($params && isset($params['count'])) {
            $this->cartCount = $params['count'];
            return;
        }

        $userId = Auth::id();
        $sessionId = Session::getId();

        $cart = Cart::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })
        ->where('is_checked_out', false)
        ->first();

        $this->cartCount = $cart ? $cart->totalItems() : 0;
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
