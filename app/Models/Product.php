<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock_quantity',
        'sku',
        'category_id',
        'brand',
        'material',
        'color',
        'sizes',
        'images',
        'featured_image',
        'surface_type',
        'performance_rating',
        'is_featured',
        'is_active',
        'rating',
    ];

    protected $casts = [
        'sizes' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            
            if (empty($product->sku)) {
                $product->sku = 'SHOE-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get the wishlist items for the product.
     */
    public function wishlistItems(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Calculate discount percentage
     */
    public function discountPercentage()
    {
        if ($this->sale_price && $this->price > $this->sale_price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Check if product is in stock
     */
    public function inStock()
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Get the current price (either sale price or regular price)
     */
    public function getCurrentPrice()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Get related products based on category
     */
    public function getRelatedProducts($limit = 4)
    {
        return self::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->take($limit)
            ->get();
    }
    
    /**
     * Get available sizes
     */
    public function getAvailableSizes()
    {
        return $this->sizes ? json_decode($this->sizes) : [];
    }
    
    /**
     * Get first image or placeholder
     */
    public function getFirstImage()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        
        if ($this->images && count(json_decode($this->images)) > 0) {
            return asset('storage/' . json_decode($this->images)[0]);
        }
        
        return asset('images/placeholder.jpg');
    }
    
    /**
     * Get all images
     */
    public function getAllImages()
    {
        $images = [];
        
        if ($this->images) {
            foreach (json_decode($this->images) as $image) {
                $images[] = asset('storage/' . $image);
            }
        }
        
        if (empty($images)) {
            $images[] = asset('images/placeholder.jpg');
        }
        
        return $images;
    }
    
    /**
     * Check if product is in user's wishlist
     */
    public function isInWishlist($userId = null)
    {
        if (!$userId && !auth()->check()) {
            return false;
        }
        
        $userId = $userId ?? auth()->id();
        
        return $this->wishlistItems()->where('user_id', $userId)->exists();
    }
}
