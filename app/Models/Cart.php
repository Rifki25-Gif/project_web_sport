<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'is_checked_out',
        'total',
        'coupon_code',
        'coupon_value',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items in the cart.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
    
    /**
     * Calculate total price of items in cart
     */
    public function total()
    {
        return $this->items->sum(function($item) {
            return $item->quantity * $item->price;
        });
    }
    
    /**
     * Get the total number of items in cart
     */
    public function totalItems()
    {
        return $this->items->sum('quantity');
    }
    
    /**
     * Calculate subtotal of cart
     */
    public function subtotal(): float
    {
        $subtotal = 0;
        
        foreach ($this->items as $item) {
            $subtotal += $item->price * $item->quantity;
        }
        
        return $subtotal;
    }
    
    /**
     * Calculate discount of cart
     */
    public function discount(): float
    {
        if ($this->coupon_code && $this->coupon_value) {
            return $this->coupon_value;
        }
        
        return 0;
    }
    
    /**
     * Calculate tax of cart
     */
    public function tax(): float
    {
        $taxRate = 0.1; // 10% tax
        return ($this->subtotal() - $this->discount()) * $taxRate;
    }
    
    /**
     * Calculate final total of cart
     */
    public function finalTotal(): float
    {
        return $this->subtotal() - $this->discount() + $this->tax();
    }
}
