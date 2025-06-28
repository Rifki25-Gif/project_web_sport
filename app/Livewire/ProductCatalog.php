<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductCatalog extends Component
{
    use WithPagination;

    public $brands = [];
    public $selectedBrands = [];

    public $surfaceTypes = [];
    public $selectedSurfaceTypes = [];

    public $performanceRatings = [];
    public $selectedPerformanceRatings = [];

    public $minPrice = 0;
    public $maxPrice = 500;
    public $price;

    public $sizes = [];
    public $selectedSizes = [];

    public $sortBy = 'newest';

    public $quickViewProduct = null;
    public $quickViewOpen = false;
    public $addingToCart = null;
    public $quantity = 1;
    public $selectedSize = null;
    public $selectedColor = null;
    public $addingToWishlist = null;
    
    public $stockError = null;

    protected $listeners = ['refreshProducts' => '$refresh'];

    public function mount()
    {
        $this->price = $this->maxPrice;
        
        // Load filter options from database
        $this->loadFilterOptions();
    }
    
    protected function loadFilterOptions()
    {
        // Load brands
        $this->brands = Product::distinct()->pluck('brand')->filter()->values()->toArray();
        
        // Load surface types
        $this->surfaceTypes = Product::distinct()->pluck('surface_type')->filter()->values()->toArray();
        
        // Load performance ratings
        $this->performanceRatings = Product::distinct()
            ->whereNotNull('performance_rating')
            ->pluck('performance_rating')
            ->filter()
            ->values()
            ->toArray();
        
        // Load sizes
        $sizes = Product::whereNotNull('sizes')
            ->get()
            ->pluck('sizes')
            ->flatten()
            ->unique()
            ->values()
            ->toArray();
        $this->sizes = $sizes;
        
        // Set min and max price
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');
        
        if ($minPrice !== null && $maxPrice !== null) {
            $this->minPrice = floor($minPrice);
            $this->maxPrice = ceil($maxPrice);
            $this->price = $this->maxPrice;
        }
    }

    public function addToCart($productId)
    {
        try {
            $this->addingToCart = $productId;
            $this->stockError = null;
            
            $product = Product::findOrFail($productId);
            
            // Check if product is in stock
            if ($product->stock_quantity <= 0) {
                $this->stockError = 'Product is out of stock';
                $this->dispatch('show-toast', ['message' => 'Product is out of stock!', 'type' => 'error']);
                $this->addingToCart = null;
                return;
            }
            
            // Check if quantity requested is available
            if ($product->stock_quantity < $this->quantity) {
                $this->stockError = "Only {$product->stock_quantity} items available in stock";
                $this->dispatch('show-toast', ['message' => "Only {$product->stock_quantity} items available in stock!", 'type' => 'error']);
                $this->addingToCart = null;
                return;
            }
            
            // Check if size is selected when product has sizes
            if (!empty(json_decode($product->sizes)) && empty($this->selectedSize)) {
                $this->stockError = 'Please select a size';
                $this->dispatch('show-toast', ['message' => 'Please select a size!', 'type' => 'error']);
                $this->addingToCart = null;
                return;
            }
            
            $userId = Auth::id();
            $sessionId = Session::getId();
            
            // Find or create cart
            $cart = Cart::firstOrCreate([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'is_checked_out' => false
            ]);
            
            // Check if product exists in cart with same attributes
            $cartItem = $cart->items()->where('product_id', $productId)
                             ->where('size', $this->selectedSize ?? null)
                             ->where('color', $this->selectedColor ?? null)
                             ->first();
            
            if ($cartItem) {
                // Check if adding more would exceed stock
                if (($cartItem->quantity + $this->quantity) > $product->stock_quantity) {
                    $this->stockError = "Cannot add more. Stock limit reached.";
                    $this->dispatch('show-toast', ['message' => 'Cannot add more. Stock limit reached.', 'type' => 'error']);
                    $this->addingToCart = null;
                    return;
                }
                
                // Update quantity if product exists
                $cartItem->quantity += $this->quantity;
                $cartItem->save();
            } else {
                // Add product to cart
                $cart->items()->create([
                    'product_id' => $productId,
                    'quantity' => $this->quantity,
                    'price' => $product->getCurrentPrice(),
                    'size' => $this->selectedSize,
                    'color' => $this->selectedColor
                ]);
            }
            
            $this->dispatch('cart-updated', ['count' => $cart->totalItems()]);
            $this->addingToCart = null;
            $this->quantity = 1;
            $this->selectedSize = null;
            $this->selectedColor = null;
            
            if ($this->quickViewOpen) {
                $this->closeQuickView();
            }
            
            $this->dispatch('show-toast', ['message' => 'Product added to cart successfully!', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->stockError = 'An error occurred. Please try again.';
            $this->addingToCart = null;
            \Illuminate\Support\Facades\Log::error('Add to cart error: ' . $e->getMessage());
            $this->dispatch('show-toast', ['message' => 'An error occurred. Please try again.', 'type' => 'error']);
        }
    }

    public function addToWishlist($productId)
    {
        try {
            $this->addingToWishlist = $productId;
            
            // Check if user is logged in
            if (!Auth::check()) {
                $this->dispatch('show-toast', ['message' => 'Please login to add items to wishlist!', 'type' => 'error']);
                $this->addingToWishlist = null;
                return;
            }
            
            $userId = Auth::id();
            
            // Check if product already in wishlist
            $exists = Wishlist::where('user_id', $userId)
                ->where('product_id', $productId)
                ->exists();
                
            if ($exists) {
                // Remove from wishlist if already exists
                Wishlist::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->delete();
                    
                $this->dispatch('show-toast', ['message' => 'Product removed from wishlist!', 'type' => 'success']);
            } else {
                // Add to wishlist
                Wishlist::create([
                    'user_id' => $userId,
                    'product_id' => $productId
                ]);
                
                $this->dispatch('show-toast', ['message' => 'Product added to wishlist!', 'type' => 'success']);
            }
            
            $this->addingToWishlist = null;
        } catch (\Exception $e) {
            $this->addingToWishlist = null;
            \Illuminate\Support\Facades\Log::error('Add to wishlist error: ' . $e->getMessage());
            $this->dispatch('show-toast', ['message' => 'An error occurred. Please try again.', 'type' => 'error']);
        }
    }
    
    public function isInWishlist($productId)
    {
        try {
            if (!Auth::check()) {
                return false;
            }
            
            return Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
        } catch (\Exception $e) {
            // Log error
            \Illuminate\Support\Facades\Log::error('Wishlist check error: ' . $e->getMessage());
            return false;
        }
    }

    public function showQuickView($productId)
    {
        $this->quickViewProduct = Product::findOrFail($productId);
        $this->quickViewOpen = true;
        $this->quantity = 1;
        $this->selectedSize = null;
        $this->selectedColor = null;
        $this->stockError = null;
    }

    public function closeQuickView()
    {
        $this->quickViewProduct = null;
        $this->quickViewOpen = false;
        $this->quantity = 1;
        $this->selectedSize = null;
        $this->selectedColor = null;
        $this->stockError = null;
    }
    
    public function incrementQuantity()
    {
        if ($this->quickViewProduct && $this->quantity < $this->quickViewProduct->stock_quantity) {
            $this->quantity++;
        }
    }
    
    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
    
    public function selectSize($size)
    {
        $this->selectedSize = $size;
    }
    
    public function selectColor($color)
    {
        $this->selectedColor = $color;
    }

    public function render()
    {
        $query = Product::query()->where('is_active', true);

        // Apply filters
        if (!empty($this->selectedBrands)) {
            $query->whereIn('brand', $this->selectedBrands);
        }

        if ($this->price < $this->maxPrice) {
            $query->where('price', '<=', $this->price);
        }

        if (!empty($this->selectedSizes)) {
            $query->where(function($q) {
                foreach ($this->selectedSizes as $size) {
                    $q->orWhereJsonContains('sizes', $size);
                }
            });
        }

        if (!empty($this->selectedSurfaceTypes)) {
            $query->whereIn('surface_type', $this->selectedSurfaceTypes);
        }
        
        if (!empty($this->selectedPerformanceRatings)) {
            $query->whereIn('performance_rating', $this->selectedPerformanceRatings);
        }

        // Apply sorting
        if ($this->sortBy === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sortBy === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($this->sortBy === 'rating') {
            $query->orderBy('rating', 'desc');
        } elseif ($this->sortBy === 'newest') {
            $query->orderBy('created_at', 'desc');
        }
        
        $products = $query->paginate(9);

        return view('livewire.product-catalog', [
            'products' => $products,
        ]);
    }
}
