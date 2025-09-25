<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 
        'slug', 
        'author', 
        'synopsis', 
        'price', 
        'cost_price',
        'stock', 
        'cover_image', 
        'genre_id'
    ];
    
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
    
    public function tropes(): BelongsToMany
    {
        return $this->belongsToMany(Trope::class);
    }
    
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
    
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get the wishlist entries for the book.
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
    
    /**
     * Get the users who have this book in their wishlist.
     */
    public function wishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }
    
    /**
     * Calculate the average rating for the book.
     * 
     * @return float|null
     */
    public function getAverageRatingAttribute(): ?float
    {
        $count = $this->reviews()->where('is_approved', true)->count();
        
        if ($count === 0) {
            return null;
        }
        
        return round($this->reviews()->where('is_approved', true)->avg('rating'), 1);
    }
    
    /**
     * Get the count of reviews for the book.
     * 
     * @return int
     */
    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->where('is_approved', true)->count();
    }
    
    /**
     * Get the active discount for the book.
     */
    public function discount(): HasOne
    {
        return $this->hasOne(BookDiscount::class)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }
    
    /**
     * Get the flash sale items for the book.
     */
    public function flashSaleItems(): HasMany
    {
        return $this->hasMany(FlashSaleItem::class);
    }
    
    /**
     * Get the flash sales for the book.
     */
    public function flashSales(): BelongsToMany
    {
        return $this->belongsToMany(FlashSale::class, 'flash_sale_items')
            ->withPivot('special_price')
            ->withTimestamps();
    }
    
    /**
     * Get the active flash sale for the book.
     */
    public function getActiveFlashSaleAttribute()
    {
        return $this->flashSales()
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->first();
    }
    
    /**
     * Check if the book has an active discount.
     * 
     * @return bool
     */
    public function hasDiscount(): bool
    {
        return $this->discount()->exists() || $this->active_flash_sale !== null;
    }
    
    /**
     * Get the final price of the book after applying any discounts.
     * 
     * @return float
     */
    public function getFinalPriceAttribute(): float
    {
        // Check for flash sale first (they have priority)
        if ($this->active_flash_sale) {
            $flashSaleItem = $this->flashSaleItems()
                ->where('flash_sale_id', $this->active_flash_sale->id)
                ->first();
                
            if ($flashSaleItem && $flashSaleItem->special_price) {
                return $flashSaleItem->special_price;
            }
            
            return $this->active_flash_sale->getDiscountedPrice($this->price);
        }
        
        // Then check for regular discount
        $discount = $this->discount;
        if ($discount) {
            return $discount->getDiscountedPrice($this->price);
        }
        
        // No discount applies
        return $this->price;
    }
    
    /**
     * Get the discount percentage.
     * 
     * @return float|null
     */
    public function getDiscountPercentAttribute(): ?float
    {
        if (!$this->hasDiscount()) {
            return null;
        }
        
        $discountAmount = $this->price - $this->final_price;
        $discountPercent = ($discountAmount / $this->price) * 100;
        
        return round($discountPercent, 0);
    }
    
    /**
     * Check if the book is on sale.
     * 
     * @return bool
     */
    public function getIsOnSaleAttribute(): bool
    {
        return $this->final_price < $this->price;
    }
    
    /**
     * Get the profit per unit for the book.
     * 
     * @return float|null
     */
    public function getProfitPerUnitAttribute(): ?float
    {
        if (!$this->cost_price) {
            return null;
        }
        
        return $this->price - $this->cost_price;
    }
    
    /**
     * Get the profit margin percentage for the book.
     * 
     * @return float|null
     */
    public function getProfitMarginAttribute(): ?float
    {
        if (!$this->cost_price || $this->price <= 0) {
            return null;
        }
        
        $profit = $this->profit_per_unit;
        return round(($profit / $this->price) * 100, 2);
    }
    
    /**
     * Check if the book has cost price data.
     * 
     * @return bool
     */
    public function hasCostData(): bool
    {
        return !is_null($this->cost_price) && $this->cost_price > 0;
    }
}
