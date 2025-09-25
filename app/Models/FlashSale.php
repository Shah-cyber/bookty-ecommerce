<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FlashSale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'starts_at',
        'ends_at',
        'discount_type',
        'discount_value',
        'is_active',
    ];
    
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the items for the flash sale.
     */
    public function items(): HasMany
    {
        return $this->hasMany(FlashSaleItem::class);
    }
    
    /**
     * Get the books for the flash sale.
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'flash_sale_items')
            ->withPivot('special_price')
            ->withTimestamps();
    }
    
    /**
     * Scope a query to only include active flash sales.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }
    
    /**
     * Calculate the discounted price for a given original price.
     */
    public function getDiscountedPrice($originalPrice, $specialPrice = null)
    {
        // If a special price is provided, use that
        if ($specialPrice !== null) {
            return $specialPrice;
        }
        
        // Otherwise calculate based on discount type and value
        if ($this->discount_type === 'fixed') {
            return max(0, $originalPrice - $this->discount_value);
        }
        
        if ($this->discount_type === 'percentage') {
            return max(0, $originalPrice * (1 - $this->discount_value / 100));
        }
        
        return $originalPrice;
    }
    
    /**
     * Check if the flash sale is currently active.
     */
    public function isActive(): bool
    {
        $now = now();
        return $this->is_active && 
               $this->starts_at <= $now && 
               $this->ends_at >= $now;
    }
    
    /**
     * Get the remaining time for the flash sale.
     */
    public function getRemainingTime()
    {
        if (!$this->isActive()) {
            return null;
        }
        
        return $this->ends_at->diffForHumans(['parts' => 3]);
    }
}
