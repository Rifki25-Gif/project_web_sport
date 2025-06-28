<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user']);
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%")
                  ->orWhereHas('product', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('status')) {
            $status = $request->status === 'approved';
            $query->where('is_approved', $status);
        }
        
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        $reviews = $query->latest()->paginate(10);
        $products = Product::orderBy('name')->get();
        
        return view('admin.reviews.index', compact('reviews', 'products'));
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Update the review approval status.
     */
    public function approve(Review $review)
    {
        $review->is_approved = true;
        $review->save();
        
        // Update product rating
        $this->updateProductRating($review->product);
        
        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    /**
     * Update the review approval status.
     */
    public function reject(Review $review)
    {
        $review->is_approved = false;
        $review->save();
        
        // Update product rating
        $this->updateProductRating($review->product);
        
        return redirect()->back()->with('success', 'Review rejected successfully.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        $product = $review->product;
        $review->delete();
        
        // Update product rating
        $this->updateProductRating($product);
        
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }
    
    /**
     * Bulk actions for reviews
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:delete,approve,reject',
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id',
        ]);
        
        $action = $request->action;
        $reviewIds = $request->review_ids;
        $affectedProducts = [];
        
        if ($action === 'delete') {
            // Get products before deletion
            $reviews = Review::whereIn('id', $reviewIds)->get();
            foreach ($reviews as $review) {
                $affectedProducts[$review->product_id] = $review->product;
            }
            
            Review::whereIn('id', $reviewIds)->delete();
            
            $message = 'Selected reviews deleted successfully.';
        } elseif ($action === 'approve') {
            $reviews = Review::whereIn('id', $reviewIds)->get();
            foreach ($reviews as $review) {
                $review->is_approved = true;
                $review->save();
                $affectedProducts[$review->product_id] = $review->product;
            }
            
            $message = 'Selected reviews approved successfully.';
        } elseif ($action === 'reject') {
            $reviews = Review::whereIn('id', $reviewIds)->get();
            foreach ($reviews as $review) {
                $review->is_approved = false;
                $review->save();
                $affectedProducts[$review->product_id] = $review->product;
            }
            
            $message = 'Selected reviews rejected successfully.';
        }
        
        // Update product ratings
        foreach ($affectedProducts as $product) {
            $this->updateProductRating($product);
        }
        
        return redirect()->route('admin.reviews.index')->with('success', $message);
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