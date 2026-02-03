<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Validate a coupon code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validate(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);
        
        $code = $request->code;
        $amount = $request->amount;
        
        // Find the coupon
        $coupon = Coupon::where('code', $code)->first();
        
        // Check if coupon exists
        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code.'
            ]);
        }
        
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'valid' => false,
                'message' => 'You must be logged in to use a coupon.'
            ]);
        }
        
        $user = Auth::user();
        
        // Validate coupon
        if (!$coupon->isValidFor($user, $amount)) {
            // Check specific validation issues
            if (!$coupon->is_active) {
                return response()->json([
                    'valid' => false,
                    'message' => 'This coupon is not active.'
                ]);
            }
            
            $now = now();
            if ($coupon->starts_at > $now) {
                return response()->json([
                    'valid' => false,
                    'message' => 'This coupon is not yet valid.'
                ]);
            }
            
            if ($coupon->expires_at < $now) {
                return response()->json([
                    'valid' => false,
                    'message' => 'This coupon has expired.'
                ]);
            }
            
            if ($coupon->min_purchase_amount !== null && $amount < $coupon->min_purchase_amount) {
                return response()->json([
                    'valid' => false,
                    'message' => "This coupon requires a minimum purchase of RM {$coupon->min_purchase_amount}."
                ]);
            }
            
            if ($coupon->max_uses_total && $coupon->usages()->count() >= $coupon->max_uses_total) {
                return response()->json([
                    'valid' => false,
                    'message' => 'This coupon has reached its maximum usage limit.'
                ]);
            }
            
            if ($coupon->max_uses_per_user) {
                $userUsages = $coupon->usages()->where('user_id', $user->id)->count();
                if ($userUsages >= $coupon->max_uses_per_user) {
                    return response()->json([
                        'valid' => false,
                        'message' => 'You have already used this coupon the maximum number of times.'
                    ]);
                }
            }
            
            // Generic error if none of the above
            return response()->json([
                'valid' => false,
                'message' => 'This coupon cannot be applied.'
            ]);
        }
        
        // Calculate discount
        $discountAmount = $coupon->calculateDiscount($amount);
        
        // Return success response
        return response()->json([
            'valid' => true,
            'message' => $coupon->free_shipping ? 'Coupon applied! Free shipping activated.' : 'Coupon applied successfully!',
            'discount_amount' => (float) $discountAmount,
            'free_shipping' => (bool) $coupon->free_shipping,
            'coupon' => [
                'code' => $coupon->code,
                'id' => $coupon->id,
                'description' => $coupon->description,
            ]
        ]);
    }
}
