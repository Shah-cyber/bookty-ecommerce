<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookDiscount extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'book_id',
        'discount_amount',
        'discount_percent',
        'starts_at',
        'ends_at',
        'is_active',
        'description',
    ];
    
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the book that owns the discount.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
    
    /**
     * Scope a query to only include active discounts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
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
     * Calculate the discounted price for a given original price.
     */
    public function getDiscountedPrice($originalPrice)
    {
        if ($this->discount_amount) {
            return max(0, $originalPrice - $this->discount_amount);
        }
        
        if ($this->discount_percent) {
            return $originalPrice * (1 - $this->discount_percent / 100);
        }
        
        return $originalPrice;
    }
}
