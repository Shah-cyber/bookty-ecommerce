<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostageRate;
use Illuminate\Http\Request;

class PostageRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rates = PostageRate::orderBy('region')->paginate(10);
        return view('admin.postage-rates.index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = ['sm', 'sabah', 'sarawak'];
        return view('admin.postage-rates.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'region' => 'required|in:sm,sabah,sarawak',
            'customer_price' => 'required|numeric|min:0',
            'actual_cost' => 'required|numeric|min:0',
        ]);

        // Ensure customer_price >= actual_cost
        if ($validated['customer_price'] < $validated['actual_cost']) {
            return back()->withInput()->with('error', __('messages.postage.price_vs_cost'));
        }

        PostageRate::create($validated);

        return redirect()->route('admin.postage-rates.index')
            ->with('success', __('messages.postage.created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostageRate $postage_rate)
    {
        $regions = ['sm', 'sabah', 'sarawak'];
        return view('admin.postage-rates.edit', ['rate' => $postage_rate, 'regions' => $regions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostageRate $postage_rate)
    {
        $validated = $request->validate([
            'region' => 'required|in:sm,sabah,sarawak',
            'customer_price' => 'required|numeric|min:0',
            'actual_cost' => 'required|numeric|min:0',
        ]);

        if ($validated['customer_price'] < $validated['actual_cost']) {
            return back()->withInput()->with('error', __('messages.postage.price_vs_cost'));
        }

        $postage_rate->update($validated);

        return redirect()->route('admin.postage-rates.index')
            ->with('success', __('messages.postage.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostageRate $postage_rate)
    {
        $postage_rate->delete();
        return redirect()->route('admin.postage-rates.index')
            ->with('success', __('messages.postage.deleted'));
    }
}


