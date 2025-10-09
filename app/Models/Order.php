<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_status',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_region',
        'shipping_customer_price',
        'shipping_actual_cost',
        'is_free_shipping',
        'shipping_postal_code',
        'shipping_phone',
        'admin_notes',
        'tracking_number',
        'coupon_id',
        'discount_amount',
        'coupon_code',
        'public_id',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    
    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (!$order->public_id) {
                $order->public_id = self::generateUniquePublicId();
            }
        });
    }

    public static function generateUniquePublicId(): string
    {
        do {
            $token = strtoupper(substr(bin2hex(random_bytes(8)), 0, 12));
        } while (self::where('public_id', $token)->exists());
        return $token;
    }

    /**
     * Get the status badge class.
     *
     * @return string
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-indigo-100 text-indigo-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    
    /**
     * Get the payment status badge class.
     *
     * @return string
     */
    public function getPaymentStatusBadgeClass(): string
    {
        return match($this->payment_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    
    /**
     * Calculate the total quantity of items in the order.
     *
     * @return int
     */
    public function getTotalQuantity(): int
    {
        return $this->items->sum('quantity');
    }
    
    /**
     * Get the coupon used for this order.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
    
    /**
     * Get the coupon usage for this order.
     */
    public function couponUsage(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }
    
    /**
     * Get the subtotal amount (before discount).
     *
     * @return float
     */
    public function getSubtotalAttribute(): float
    {
        return $this->total_amount + $this->discount_amount;
    }
    
    /**
     * Apply a coupon to the order.
     *
     * @param Coupon $coupon
     * @return bool
     */
    public function applyCoupon(Coupon $coupon): bool
    {
        if (!$coupon->isValidFor($this->user, $this->total_amount)) {
            return false;
        }
        
        $discountAmount = $coupon->calculateDiscount($this->total_amount);
        $newTotal = $this->total_amount - $discountAmount;
        
        $this->coupon_id = $coupon->id;
        $this->coupon_code = $coupon->code;
        $this->discount_amount = $discountAmount;
        $this->total_amount = $newTotal;
        $this->save();
        
        // Record coupon usage
        CouponUsage::create([
            'coupon_id' => $coupon->id,
            'user_id' => $this->user_id,
            'order_id' => $this->id,
            'discount_amount' => $discountAmount
        ]);
        
        return true;
    }
    
    /**
     * Remove a coupon from the order.
     *
     * @return bool
     */
    public function removeCoupon(): bool
    {
        if (!$this->coupon_id) {
            return false;
        }
        
        $this->total_amount += $this->discount_amount;
        
        // Delete coupon usage record
        $this->couponUsage()->delete();
        
        $this->coupon_id = null;
        $this->coupon_code = null;
        $this->discount_amount = 0;
        $this->save();
        
        return true;
    }
    
    /**
     * Get the J&T Express tracking URL for this order.
     *
     * @return string|null
     */
    public function getJtTrackingUrl(): ?string
    {
        if (!$this->tracking_number) {
            return null;
        }
        
        return 'https://www.jtexpress.my/track.php?awb=' . $this->tracking_number;
    }
    
    /**
     * Check if the order has a tracking number.
     *
     * @return bool
     */
    public function hasTrackingNumber(): bool
    {
        return !empty($this->tracking_number);
    }
}
