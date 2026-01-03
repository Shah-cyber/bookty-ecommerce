<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class PostageRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'region',
        'customer_price',
        'actual_cost',
    ];
    
    protected $casts = [
        'customer_price' => 'decimal:2',
        'actual_cost' => 'decimal:2',
    ];
    
    /**
     * Relationships
     */
    
    /**
     * Get all history records for this rate
     */
    public function history(): HasMany
    {
        return $this->hasMany(PostageRateHistory::class)
                    ->orderBy('created_at', 'desc');
    }
    
    /**
     * Get the current active history record
     */
    public function currentHistory(): HasOne
    {
        return $this->hasOne(PostageRateHistory::class)
                    ->whereNull('valid_until')
                    ->latest('valid_from');
    }
    
    /**
     * Get all orders that used this rate's history
     */
    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(
            Order::class,
            PostageRateHistory::class,
            'postage_rate_id',        // Foreign key on postage_rate_history
            'postage_rate_history_id', // Foreign key on orders
            'id',                      // Local key on postage_rates
            'id'                       // Local key on postage_rate_history
        );
    }
    
    /**
     * Helper Methods
     */
    
    /**
     * Get profit margin percentage
     */
    public function getProfitMargin(): float
    {
        if ($this->customer_price == 0) {
            return 0;
        }
        
        return (($this->customer_price - $this->actual_cost) / $this->customer_price) * 100;
    }
    
    /**
     * Check if this rate has history records
     */
    public function hasHistory(): bool
    {
        return $this->history()->exists();
    }
}


