<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    public function show(Product $product, RecommendationService $recommendationService)
    {
        // Get similar products
        $similarProducts = $recommendationService->getSimilarProducts($product);
        
        // Get frequently bought together products
        $frequentlyBoughtTogether = $recommendationService->getFrequentlyBoughtTogether($product);
        
        return view('products.show', compact('product', 'similarProducts', 'frequentlyBoughtTogether'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")
                             ->orWhere('description', 'LIKE', "%{$query}%")
                             ->orWhere('brand', 'LIKE', "%{$query}%")
                             ->select('name', 'slug')
                             ->take(10)
                             ->get();

        return response()->json($products);
    }
}
