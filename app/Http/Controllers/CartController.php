<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        return view('checkout.cart');
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;
        $size = $request->size;
        $color = $request->color;
        $userId = Auth::id();
        $sessionId = Session::getId();

        // Get the product to verify stock
        $product = Product::findOrFail($productId);
        
        // Check if product is in stock
        if ($product->stock_quantity <= 0) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock',
                ], 400);
            }
            
            return redirect()->back()->with('error', 'Product is out of stock');
        }
        
        // Check if requested quantity is available
        if ($product->stock_quantity < $quantity) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$product->stock_quantity} items available in stock",
                ], 400);
            }
            
            return redirect()->back()->with('error', "Only {$product->stock_quantity} items available in stock");
        }

        // Find or create cart
        $cart = Cart::firstOrCreate([
            'user_id' => $userId,
            'session_id' => $userId ? null : $sessionId,
            'is_checked_out' => false,
        ]);

        // Check if product exists in cart with same attributes
        $cartItem = $cart->items()
            ->where('product_id', $productId)
            ->where('size', $size)
            ->where('color', $color)
            ->first();

        if ($cartItem) {
            // Check if adding more would exceed stock
            if (($cartItem->quantity + $quantity) > $product->stock_quantity) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot add more. Stock limit reached.',
                    ], 400);
                }
                
                return redirect()->back()->with('error', 'Cannot add more. Stock limit reached.');
            }
            
            // Update quantity if product exists
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Add product to cart
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->getCurrentPrice(),
                'size' => $size,
                'color' => $color,
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cart_count' => $cart->totalItems(),
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
        ]);

        $userId = Auth::id();
        $sessionId = Session::getId();

        $cart = Cart::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found',
            ], 404);
        }

        $cartItem = $cart->items()->find($request->cart_item_id);
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cartItem->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart successfully',
                'cart_count' => $cart->items()->sum('quantity'),
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from cart successfully');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $sessionId = Session::getId();

        $cart = Cart::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found',
            ], 404);
        }

        $cartItem = $cart->items()->find($request->cart_item_id);
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $cart->items()->sum('quantity'),
                'item_total' => $cartItem->quantity * $cartItem->price,
                'cart_total' => $cart->total(),
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated successfully');
    }
}
