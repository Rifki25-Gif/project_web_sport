<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display reviews for a product.
     */
    public function index(Product $product)
    {
        $reviews = $product->reviews()
            ->approved()
            ->with('user')
            ->latest()
            ->paginate(10);
            
        return view('products.reviews', compact('product', 'reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Product $product)
    {
        // Check if user has purchased the product
        $hasPurchased = OrderItem::whereHas('order', function($query) {
                $query->where('user_id', Auth::id())
                    ->where('status', 'completed');
            })
            ->where('product_id', $product->id)
            ->exists();
            
        // Check if user has already reviewed this product
        $hasReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();
            
        if ($hasReviewed) {
            return redirect()->route('products.show', $product->slug)
                ->with('error', 'You have already reviewed this product.');
        }
        
        return view('products.review-form', compact('product', 'hasPurchased'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        // Check if user has already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();
            
        if ($existingReview) {
            return redirect()->route('products.show', $product->slug)
                ->with('error', 'You have already reviewed this product.');
        }
        
        // Check if user has purchased the product
        $orderItem = OrderItem::whereHas('order', function($query) {
                $query->where('user_id', Auth::id())
                    ->where('status', 'completed');
            })
            ->where('product_id', $product->id)
            ->first();
            
        $isVerifiedPurchase = $orderItem ? true : false;

        // Create the review
        $review = new Review([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_item_id' => $orderItem ? $orderItem->id : null,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_verified_purchase' => $isVerifiedPurchase,
            'is_approved' => true, // Auto-approve for now, could be changed to require moderation
        ]);
        
        $review->save();
        
        // Update product average rating
        $this->updateProductRating($product);

        return redirect()->route('products.show', $product->slug)
            ->with('success', 'Thank you for your review!');
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);
        
        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);
        
        // Update product average rating
        $this->updateProductRating($review->product);
        
        return redirect()->route('products.show', $review->product->slug)
            ->with('success', 'Your review has been updated.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        // Check if user owns this review or is admin
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $product = $review->product;
        $review->delete();
        
        // Update product average rating
        $this->updateProductRating($product);
        
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
    
    /**
     * Update the product's average rating.
     */
    private function updateProductRating(Product $product)
    {
        $averageRating = $product->reviews()->approved()->avg('rating');
        $product->rating = $averageRating ?? 0;
        $product->save();
    }
} 