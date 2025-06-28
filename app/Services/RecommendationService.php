<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RecommendationService
{
    /**
     * Get personalized recommendations for a user
     */
    public function getPersonalizedRecommendations(User $user = null, int $limit = 8)
    {
        // If no user is provided or user is not authenticated, return trending products
        if (!$user || !$user->id) {
            return $this->getTrendingProducts($limit);
        }
        
        // Get products the user has purchased
        $purchasedProductIds = OrderItem::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->pluck('product_id')
            ->toArray();
            
        // If user has no purchase history, return trending products
        if (empty($purchasedProductIds)) {
            return $this->getTrendingProducts($limit);
        }
        
        // Get categories of purchased products
        $purchasedCategories = Product::whereIn('id', $purchasedProductIds)
            ->pluck('category_id')
            ->unique()
            ->toArray();
            
        // Get brands of purchased products
        $purchasedBrands = Product::whereIn('id', $purchasedProductIds)
            ->pluck('brand')
            ->unique()
            ->toArray();
            
        // Find similar products based on categories and brands, excluding already purchased products
        $recommendations = Product::where('is_active', true)
            ->whereNotIn('id', $purchasedProductIds)
            ->where(function ($query) use ($purchasedCategories, $purchasedBrands) {
                $query->whereIn('category_id', $purchasedCategories)
                    ->orWhereIn('brand', $purchasedBrands);
            })
            ->orderBy('rating', 'desc')
            ->take($limit)
            ->get();
            
        // If we don't have enough recommendations, add trending products
        if ($recommendations->count() < $limit) {
            $trendingProducts = $this->getTrendingProducts($limit - $recommendations->count(), $purchasedProductIds);
            $recommendations = $recommendations->merge($trendingProducts);
        }
        
        return $recommendations;
    }
    
    /**
     * Get trending products based on order frequency
     */
    public function getTrendingProducts(int $limit = 8, array $excludeIds = [])
    {
        return Product::where('is_active', true)
            ->whereNotIn('id', $excludeIds)
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
    
    /**
     * Get similar products based on a specific product
     */
    public function getSimilarProducts(Product $product, int $limit = 4)
    {
        // Find products in the same category with similar attributes
        $similarProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                    ->orWhere('brand', $product->brand)
                    ->orWhere('surface_type', $product->surface_type);
            })
            ->orderBy('rating', 'desc')
            ->take($limit)
            ->get();
            
        // If we don't have enough similar products, add some from the same category
        if ($similarProducts->count() < $limit) {
            $categoryProducts = Product::where('is_active', true)
                ->where('id', '!=', $product->id)
                ->whereNotIn('id', $similarProducts->pluck('id')->toArray())
                ->where('category_id', $product->category_id)
                ->orderBy('rating', 'desc')
                ->take($limit - $similarProducts->count())
                ->get();
                
            $similarProducts = $similarProducts->merge($categoryProducts);
        }
        
        return $similarProducts;
    }
    
    /**
     * Get frequently bought together products
     */
    public function getFrequentlyBoughtTogether(Product $product, int $limit = 4)
    {
        // Find products that are frequently purchased together with the given product
        $frequentlyBoughtProductIds = DB::table('order_items as oi1')
            ->join('order_items as oi2', 'oi1.order_id', '=', 'oi2.order_id')
            ->where('oi1.product_id', $product->id)
            ->where('oi2.product_id', '!=', $product->id)
            ->select('oi2.product_id', DB::raw('COUNT(*) as frequency'))
            ->groupBy('oi2.product_id')
            ->orderBy('frequency', 'desc')
            ->limit($limit)
            ->pluck('product_id')
            ->toArray();
            
        // Get the products
        $frequentlyBoughtProducts = Product::whereIn('id', $frequentlyBoughtProductIds)->get();
        
        // If we don't have enough products, add some similar products
        if ($frequentlyBoughtProducts->count() < $limit) {
            $additionalProducts = $this->getSimilarProducts(
                $product, 
                $limit - $frequentlyBoughtProducts->count()
            );
            
            $frequentlyBoughtProducts = $frequentlyBoughtProducts->merge($additionalProducts);
        }
        
        return $frequentlyBoughtProducts;
    }
    
    /**
     * Get popular products by category
     */
    public function getPopularProductsByCategory(int $categoryId, int $limit = 8)
    {
        return Product::where('is_active', true)
            ->where('category_id', $categoryId)
            ->orderBy('rating', 'desc')
            ->take($limit)
            ->get();
    }
    
    /**
     * Get new arrivals
     */
    public function getNewArrivals(int $limit = 8)
    {
        return Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
    
    /**
     * Get best sellers
     */
    public function getBestSellers(int $limit = 8)
    {
        $bestSellerIds = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit($limit)
            ->pluck('product_id')
            ->toArray();
            
        // Preserve the order of best sellers
        $bestSellers = Product::whereIn('id', $bestSellerIds)->get();
        
        // Sort the collection based on the order in $bestSellerIds
        $bestSellers = $bestSellers->sortBy(function($model) use ($bestSellerIds) {
            return array_search($model->id, $bestSellerIds);
        });
        
        return $bestSellers->values();
    }
} 