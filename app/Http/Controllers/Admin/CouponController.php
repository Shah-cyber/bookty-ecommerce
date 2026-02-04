<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::withCount('usages')->latest()->paginate(6);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'description' => 'nullable|string|max:255',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'max_uses_per_user' => 'nullable|integer|min:1',
            'max_uses_total' => 'nullable|integer|min:1',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after:starts_at',
        ]);
        
        try {
            $coupon = new Coupon();
            $coupon->code = strtoupper($request->code);
            $coupon->description = $request->description;
            $coupon->discount_type = $request->discount_type;
            $coupon->discount_value = $request->discount_value;
            $coupon->min_purchase_amount = $request->min_purchase_amount ?? 0;
            $coupon->max_uses_per_user = $request->max_uses_per_user;
            $coupon->max_uses_total = $request->max_uses_total;
            $coupon->starts_at = $request->starts_at;
            $coupon->expires_at = $request->expires_at;
            $coupon->is_active = true;
            // Use boolean() so hidden "0" + optional "1" checkbox work correctly
            $coupon->free_shipping = $request->boolean('free_shipping');
            $coupon->save();
            
            return redirect()->route('admin.coupons.index')
                ->with('success', 'Coupon created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating coupon: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coupon = Coupon::with(['usages.user', 'usages.order'])->findOrFail($id);
        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);
        
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable|string|max:255',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'max_uses_per_user' => 'nullable|integer|min:1',
            'max_uses_total' => 'nullable|integer|min:1',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
        ]);
        
        try {
            $coupon->code = strtoupper($request->code);
            $coupon->description = $request->description;
            $coupon->discount_type = $request->discount_type;
            $coupon->discount_value = $request->discount_value;
            $coupon->min_purchase_amount = $request->min_purchase_amount ?? 0;
            $coupon->max_uses_per_user = $request->max_uses_per_user;
            $coupon->max_uses_total = $request->max_uses_total;
            $coupon->starts_at = $request->starts_at;
            $coupon->expires_at = $request->expires_at;
            // Hidden "0" + checkbox "1" pattern → read final boolean value
            $coupon->is_active = $request->boolean('is_active');
            $coupon->free_shipping = $request->boolean('free_shipping');
            $coupon->save();
            
            return redirect()->route('admin.coupons.index')
                ->with('success', 'Coupon updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating coupon: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            
            // Check if the coupon has been used
            if ($coupon->usages()->count() > 0) {
                return back()->with('error', 'Cannot delete coupon that has been used in orders.');
            }
            
            $coupon->delete();
            
            return redirect()->route('admin.coupons.index')
                ->with('success', 'Coupon deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting coupon: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle the active status of the coupon.
     */
    public function toggleActive(string $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->is_active = !$coupon->is_active;
            $coupon->save();
            
            $status = $coupon->is_active ? 'activated' : 'deactivated';
            return redirect()->route('admin.coupons.index')
                ->with('success', "Coupon {$status} successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating coupon status: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate a random coupon code.
     */
    public function generateCode()
    {
        $code = strtoupper(Str::random(8));
        
        // Ensure the code is unique
        while (Coupon::where('code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }
        
        return response()->json(['code' => $code]);
    }
}
