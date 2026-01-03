<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostageRate;
use App\Services\PostageRateService;
use Illuminate\Http\Request;

class PostageRateController extends Controller
{
    protected PostageRateService $service;
    
    public function __construct(PostageRateService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rates = PostageRate::with('currentHistory')->orderBy('region')->paginate(10);
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
     * Now uses PostageRateService to create history records (Hybrid Approach!)
     */
    public function update(Request $request, PostageRate $postage_rate)
    {
        $validated = $request->validate([
            'region' => 'required|in:sm,sabah,sarawak',
            'customer_price' => 'required|numeric|min:0',
            'actual_cost' => 'required|numeric|min:0',
            'comment' => 'nullable|string|max:500', // New: comment for audit trail
        ]);

        if ($validated['customer_price'] < $validated['actual_cost']) {
            return back()->withInput()->with('error', __('messages.postage.price_vs_cost'));
        }

        // HYBRID APPROACH: Use service to update rate and create history
        $this->service->updateRate(
            region: $postage_rate->region,
            newCustomerPrice: $validated['customer_price'],
            newActualCost: $validated['actual_cost'],
            comment: $validated['comment'] ?? null
        );

        return redirect()->route('admin.postage-rates.index')
            ->with('success', __('messages.postage.updated'));
    }
    
    /**
     * Display history timeline for a specific region
     */
    public function history(string $region)
    {
        $rate = PostageRate::where('region', $region)->firstOrFail();
        $timeline = $this->service->getHistoryTimeline($region, 50);
        
        return view('admin.postage-rates.history', compact('rate', 'timeline', 'region'));
    }
    
    /**
     * Display all history across all regions
     */
    public function allHistory(Request $request)
    {
        $query = \App\Models\PostageRateHistory::with(['postageRate', 'updater'])
            ->orderBy('created_at', 'desc');
        
        // Filter by region if provided
        if ($request->has('region') && $request->region) {
            $query->forRegion($request->region);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('updater', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }
        
        $history = $query->paginate(20);
        $regions = PostageRate::pluck('region');
        
        return view('admin.postage-rates.all-history', compact('history', 'regions'));
    }
    
    /**
     * Display data integrity verification
     */
    public function verifyIntegrity()
    {
        $results = $this->service->verifyDataIntegrity();
        return view('admin.postage-rates.verify', compact('results'));
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


