<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order ID or customer name/email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Sort orders
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'total_asc':
                $query->orderBy('total_amount', 'asc');
                break;
            case 'total_desc':
                $query->orderBy('total_amount', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $orders = $query->paginate(15);
        
        // Get order statuses for filter
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];

        return view('admin.orders.index', compact('orders', 'statuses', 'paymentStatuses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.book']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load(['user', 'items.book']);
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];
        
        return view('admin.orders.edit', compact('order', 'statuses', 'paymentStatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'admin_notes' => 'nullable|string',
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', "✅ Order #{$order->id} has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Check if the order can be deleted (e.g., only cancelled orders)
        if ($order->status !== 'cancelled') {
            return redirect()->route('admin.orders.index')
                ->with('error', "⚠️ Only cancelled orders can be deleted. Order #{$order->id} is currently '{$order->status}'.");
        }

        // Delete order items first
        $order->items()->delete();
        
        // Delete the order
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', "🗑️ Order #{$order->id} has been deleted successfully!");
    }
}
