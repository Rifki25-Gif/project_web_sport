<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(RecommendationService $recommendationService)
    {
        // Get featured products
        $featuredProducts = Product::where('is_featured', true)
                                  ->where('is_active', true)
                                  ->take(6)
                                  ->get();
        
        // Get new arrivals
        $newArrivals = $recommendationService->getNewArrivals(8);
        
        // Get best sellers
        $bestSellers = $recommendationService->getBestSellers(8);
        
        // Get personalized recommendations for authenticated user
        $personalizedRecommendations = $recommendationService->getPersonalizedRecommendations(Auth::user(), 8);
        
        // Get categories with products
        $categories = Category::withCount('products')->orderBy('products_count', 'desc')->take(6)->get();
        
        return view('welcome', compact(
            'featuredProducts',
            'newArrivals',
            'bestSellers',
            'personalizedRecommendations',
            'categories'
        ));
    }
}
