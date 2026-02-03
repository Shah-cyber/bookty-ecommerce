<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_purchase_amount',
        'max_uses_per_user',
        'max_uses_total',
        'starts_at',
        'expires_at',
        'is_active',
        'free_shipping',
    ];
    
    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'free_shipping' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the usages for the coupon.
     */
    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }
    
    /**
     * Scope a query to only include active coupons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now());
    }
    
    /**
     * Check if the coupon is valid for the given user and order amount.
     */
    public function isValidFor($user, $orderAmount)
    {
        // Check if coupon is active
        if (!$this->is_active) {
            return false;
        }
        
        // Check if coupon is within valid date range
        $now = now();
        if ($this->starts_at > $now || $this->expires_at < $now) {
            return false;
        }
        
        // Check minimum purchase amount
        if ($orderAmount < $this->min_purchase_amount) {
            return false;
        }
        
        // Check if max total uses is reached
        if ($this->max_uses_total && $this->usages()->count() >= $this->max_uses_total) {
            return false;
        }
        
        // Check if max uses per user is reached
        if ($this->max_uses_per_user && $user) {
            $userUsages = $this->usages()->where('user_id', $user->id)->count();
            if ($userUsages >= $this->max_uses_per_user) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Calculate the discount amount for the given order amount.
     */
    public function calculateDiscount($orderAmount)
    {
        if ($this->free_shipping) {
            return 0;
        }
        if ($this->discount_type === 'fixed') {
            return min($this->discount_value, $orderAmount);
        }
        
        if ($this->discount_type === 'percentage') {
            return ($orderAmount * $this->discount_value) / 100;
        }
        
        return 0;
    }
}
