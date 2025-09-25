<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'book_id',
        'quantity',
        'price',
        'cost_price',
        'total_selling',
        'total_cost'
    ];
    
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
    
    /**
     * Get the review associated with this order item.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    
    /**
     * Get the profit for this order item.
     * 
     * @return float|null
     */
    public function getProfitAttribute(): ?float
    {
        if (!$this->cost_price) {
            return null;
        }
        
        return $this->total_selling - $this->total_cost;
    }
    
    /**
     * Get the profit margin percentage for this order item.
     * 
     * @return float|null
     */
    public function getProfitMarginAttribute(): ?float
    {
        if (!$this->cost_price || $this->total_selling <= 0) {
            return null;
        }
        
        $profit = $this->profit;
        return round(($profit / $this->total_selling) * 100, 2);
    }
    
    /**
     * Check if this order item has cost data.
     * 
     * @return bool
     */
    public function hasCostData(): bool
    {
        return !is_null($this->cost_price) && $this->cost_price > 0;
    }
}
