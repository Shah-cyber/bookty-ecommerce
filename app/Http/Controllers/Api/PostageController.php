<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostageRate;
use Illuminate\Http\Request;

class PostageController extends Controller
{
    public function rate(Request $request)
    {
        $request->validate([
            'state' => 'required|string',
            'coupon_code' => 'nullable|string',
        ]);

        $state = trim(strtolower($request->get('state')));
        [$region, $rate] = $this->resolveRegionAndRate($state);

        $isFreeShipping = false;
        // Check coupon free shipping
        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->is_active && now()->between($coupon->starts_at, $coupon->expires_at) && $coupon->free_shipping) {
                $isFreeShipping = true;
            }
        }
        // Check cart items for flash sale/book discount free shipping
        if (!$isFreeShipping && auth()->check()) {
            $cart = auth()->user()->cart;
            if ($cart) {
                $cart->load('items.book.flashSales', 'items.book.discount');
                foreach ($cart->items as $item) {
                    $book = $item->book;
                    if ($book->active_flash_sale && $book->active_flash_sale->free_shipping) {
                        $isFreeShipping = true;
                        break;
                    }
                    if ($book->discount && $book->discount->free_shipping) {
                        $isFreeShipping = true;
                        break;
                    }
                }
            }
        }

        $customerPrice = $rate?->customer_price ? (float) $rate->customer_price : 0.0;
        if ($isFreeShipping) {
            $customerPrice = 0.0;
        }

        return response()->json([
            'region' => $region,
            'customer_price' => $customerPrice,
            'is_free_shipping' => $isFreeShipping,
        ]);
    }

    private function resolveRegionAndRate(string $state): array
    {
        $smStates = [
            'johor','kedah','kelantan','melaka','negeri sembilan','pahang','perak','perlis','pulau pinang','penang','selangor','terengganu','kuala lumpur','putrajaya'
        ];
        $sabahStates = ['sabah'];
        $sarawakStates = ['sarawak'];
        $labuanStates = ['labuan','wilayah persekutuan labuan'];

        if (in_array($state, $labuanStates, true)) {
            // Labuan uses Sabah rate but we return region label as labuan
            $rate = PostageRate::where('region', 'sabah')->first();
            return ['labuan', $rate];
        }
        if (in_array($state, $sabahStates, true)) {
            $rate = PostageRate::where('region', 'sabah')->first();
            return ['sabah', $rate];
        }
        if (in_array($state, $sarawakStates, true)) {
            $rate = PostageRate::where('region', 'sarawak')->first();
            return ['sarawak', $rate];
        }
        if (in_array($state, $smStates, true)) {
            $rate = PostageRate::where('region', 'sm')->first();
            return ['sm', $rate];
        }

        // Default to SM if unknown
        $rate = PostageRate::where('region', 'sm')->first();
        return ['sm', $rate];
    }
}


