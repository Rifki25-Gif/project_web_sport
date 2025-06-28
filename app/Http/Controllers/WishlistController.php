<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add a product to the user's wishlist.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);
        
        $userId = Auth::id();
        $productId = $request->product_id;
        
        // Check if the product is already in the wishlist
        $exists = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
            
        if ($exists) {
            return redirect()->back()->with('info', 'This product is already in your wishlist.');
        }
        
        // Add to wishlist
        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
        
        return redirect()->back()->with('success', 'Product added to your wishlist.');
    }

    /**
     * Remove a product from the user's wishlist.
     */
    public function remove($id)
    {
        $wishlistItem = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $wishlistItem->delete();
        
        return redirect()->back()->with('success', 'Product removed from your wishlist.');
    }
    
    /**
     * Toggle a product in the user's wishlist (add if not present, remove if present).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);
        
        $userId = Auth::id();
        $productId = $request->input('product_id');
        
        // Check if the product is already in the wishlist
        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
            
        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
            $message = 'Product removed from your wishlist.';
            $status = 'removed';
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $message = 'Product added to your wishlist.';
            $status = 'added';
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => $status,
                'message' => $message
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }
}
