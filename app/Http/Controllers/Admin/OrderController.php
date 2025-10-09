<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $orders = $query->paginate(6);
        
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
            'tracking_number' => 'nullable|string|max:50',
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'admin_notes' => $request->admin_notes,
            'tracking_number' => $request->tracking_number,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', "✅ Order #" . ($order->public_id ?? $order->id) . " has been updated successfully!");
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

    /**
     * Printable invoice view for an order.
     */
    public function invoice(Order $order)
    {
        $order->load(['user', 'items.book']);

        // Seller/business details (replace with settings table if available)
        $seller = [
            'company' => config('app.name', 'Bookty'),
            'address' => '123 Book Street, Kuala Lumpur, MY',
            'tax_number' => 'TAX-1234567890',
            'email' => 'accounts@bookty.local',
            'phone' => '+60 12-345 6789',
        ];

        // Generate an invoice number (public facing); prefer public_id, add date suffix
        $invoiceNumber = ($order->public_id ?? $order->id) . '-' . $order->created_at->format('Ymd');

        // Tax configuration (simple example: 0% or 6% SST)
        $taxRate = 0.06; // 6%
        $subTotal = $order->items->sum(function($i){ return $i->price * $i->quantity; });
        $discount = $order->discount_amount ?? 0;
        $taxable = max(0, $subTotal - $discount);
        $taxAmount = round($taxable * $taxRate, 2);
        $grandTotal = $taxable + $taxAmount;

        return view('admin.orders.invoice', compact('order', 'seller', 'invoiceNumber', 'taxRate', 'subTotal', 'discount', 'taxAmount', 'grandTotal'));
    }

    /**
     * Download invoice as PDF.
     */
    public function invoicePdf(Order $order)
    {
        $order->load(['user', 'items.book']);
        $seller = [
            'company' => config('app.name', 'Bookty'),
            'address' => '123 Book Street, Kuala Lumpur, MY',
            'tax_number' => 'TAX-1234567890',
            'email' => 'accounts@bookty.local',
            'phone' => '+60 12-345 6789',
        ];
        $invoiceNumber = ($order->public_id ?? $order->id) . '-' . $order->created_at->format('Ymd');
        $taxRate = 0.06;
        $subTotal = $order->items->sum(function($i){ return $i->price * $i->quantity; });
        $discount = $order->discount_amount ?? 0;
        $taxable = max(0, $subTotal - $discount);
        $taxAmount = round($taxable * $taxRate, 2);
        $grandTotal = $taxable + $taxAmount;

        $pdf = Pdf::loadView('admin.orders.invoice-pdf', compact('order', 'seller', 'invoiceNumber', 'taxRate', 'subTotal', 'discount', 'taxAmount', 'grandTotal'))
            ->setPaper('a4');

        return $pdf->download('invoice_'.$invoiceNumber.'.pdf');
    }
}
