<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostageRateHistory extends Model
{
    protected $table = 'postage_rate_history';
    
    /**
     * Immutable records - no updated_at column!
     * This ensures historical records are never modified.
     */
    const UPDATED_AT = null;
    
    protected $fillable = [
        'postage_rate_id',
        'customer_price',
        'actual_cost',
        'updated_by',
        'comment',
        'valid_from',
        'valid_until',
    ];
    
    protected $casts = [
        'customer_price' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'created_at' => 'datetime',
    ];
    
    /**
     * Relationships
     */
    
    public function postageRate(): BelongsTo
    {
        return $this->belongsTo(PostageRate::class);
    }
    
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'postage_rate_history_id');
    }
    
    /**
     * Scopes
     */
    
    /**
     * Get only current (active) history records
     */
    public function scopeCurrent($query)
    {
        return $query->whereNull('valid_until');
    }
    
    /**
     * Get history valid at a specific datetime
     */
    public function scopeValidAt($query, $datetime)
    {
        return $query->where('valid_from', '<=', $datetime)
            ->where(function($q) use ($datetime) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>', $datetime);
            });
    }
    
    /**
     * Get history for a specific region
     */
    public function scopeForRegion($query, $region)
    {
        return $query->whereHas('postageRate', function($q) use ($region) {
            $q->where('region', $region);
        });
    }
    
    /**
     * Helper Methods
     */
    
    /**
     * Check if this is the current active history record
     */
    public function isCurrent(): bool
    {
        return $this->valid_until === null;
    }
    
    /**
     * Get the updater's name (or "System" if null)
     */
    public function getUpdaterNameAttribute(): string
    {
        return $this->updater?->name ?? 'System';
    }
    
    /**
     * Get the profit margin for this rate
     */
    public function getProfitMargin(): float
    {
        if ($this->actual_cost == 0) {
            return 0;
        }
        
        return (($this->customer_price - $this->actual_cost) / $this->customer_price) * 100;
    }
    
    /**
     * Get the duration this rate was valid
     */
    public function getValidDuration(): ?string
    {
        if (!$this->valid_until) {
            return 'Current';
        }
        
        return $this->valid_from->diffForHumans($this->valid_until, true);
    }
}
