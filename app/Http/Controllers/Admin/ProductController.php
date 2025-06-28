<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }
        
        $products = $query->latest()->paginate(10);
        $categories = Category::all();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric|lt:price',
            'stock_quantity' => 'required|integer',
            'brand' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'sizes' => 'required|array',
            'sizes.*' => 'string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'surface_type' => 'nullable|string|max:255',
            'performance_rating' => 'nullable|numeric|min:0|max:5',
            'is_active' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $data = $request->except(['images', 'featured_image', 'sizes']);
        
        // Generate slug
        $slug = Str::slug($request->name);
        $count = Product::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-" . ($count + 1);
        }
        $data['slug'] = $slug;
        
        // Generate SKU if not provided
        if (empty($request->sku)) {
            $data['sku'] = 'SHOE-' . strtoupper(Str::random(8));
        }
        
        // Handle sizes
        $data['sizes'] = json_encode($request->sizes);
        
        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
            $data['images'] = json_encode($imagePaths);
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Shoe product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric|lt:price',
            'stock_quantity' => 'required|integer',
            'brand' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'sizes' => 'required|array',
            'sizes.*' => 'string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'surface_type' => 'nullable|string|max:255',
            'performance_rating' => 'nullable|numeric|min:0|max:5',
            'is_active' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $data = $request->except(['images', 'featured_image', 'sizes']);

        // Update slug if name changed
        if ($request->name !== $product->name) {
            $slug = Str::slug($request->name);
            $count = Product::where('slug', 'LIKE', "{$slug}%")->where('id', '!=', $product->id)->count();
            if ($count > 0) {
                $slug = "{$slug}-" . ($count + 1);
            }
            $data['slug'] = $slug;
        }
        
        // Handle sizes
        $data['sizes'] = json_encode($request->sizes);
        
        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old featured image if exists
            if ($product->featured_image) {
                Storage::disk('public')->delete($product->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('products', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            // Delete old images
            if ($product->images) {
                foreach (json_decode($product->images) as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
            $data['images'] = json_encode($imagePaths);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Shoe product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete featured image if exists
        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }
        
        // Delete multiple images if exist
        if ($product->images) {
            foreach (json_decode($product->images) as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Shoe product deleted successfully.');
    }
    
    /**
     * Bulk actions for products
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:delete,activate,deactivate',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);
        
        $action = $request->action;
        $productIds = $request->product_ids;
        
        if ($action === 'delete') {
            $products = Product::whereIn('id', $productIds)->get();
            
            foreach ($products as $product) {
                // Delete featured image if exists
                if ($product->featured_image) {
                    Storage::disk('public')->delete($product->featured_image);
                }
                
                // Delete multiple images if exist
                if ($product->images) {
                    foreach (json_decode($product->images) as $imagePath) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
                
                $product->delete();
            }
            
            return redirect()->route('admin.products.index')->with('success', count($productIds) . ' products deleted successfully.');
        } elseif ($action === 'activate') {
            Product::whereIn('id', $productIds)->update(['is_active' => true]);
            return redirect()->route('admin.products.index')->with('success', count($productIds) . ' products activated successfully.');
        } elseif ($action === 'deactivate') {
            Product::whereIn('id', $productIds)->update(['is_active' => false]);
            return redirect()->route('admin.products.index')->with('success', count($productIds) . ' products deactivated successfully.');
        }
        
        return redirect()->route('admin.products.index')->with('error', 'Invalid action.');
    }
}
