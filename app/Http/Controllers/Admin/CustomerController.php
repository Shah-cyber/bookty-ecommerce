<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view customers')->only(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::role('customer');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }
        
        // Filter by registration date
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Filter by has orders
        if ($request->has('has_orders')) {
            if ($request->has_orders === 'yes') {
                $query->whereHas('orders');
            } elseif ($request->has_orders === 'no') {
                $query->whereDoesntHave('orders');
            }
        }
        
        // Sorting
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $customers = $query->withCount('orders')->paginate(6);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = User::findOrFail($id);
        $orders = $customer->orders()->latest()->get();
        
        // Calculate customer statistics
        $totalSpent = $orders->where('status', 'completed')->sum('total_amount');
        $orderCount = $orders->count();
        $completedOrderCount = $orders->where('status', 'completed')->count();
        $pendingOrderCount = $orders->where('status', 'pending')->count();
        
        return view('admin.customers.show', compact(
            'customer', 
            'orders', 
            'totalSpent', 
            'orderCount', 
            'completedOrderCount', 
            'pendingOrderCount'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
