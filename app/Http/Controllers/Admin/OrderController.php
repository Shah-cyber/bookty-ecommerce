<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view orders')->only(['index', 'show', 'invoice', 'invoicePdf']);
        $this->middleware('permission:manage orders')->only(['create', 'store', 'edit', 'update', 'destroy', 'quickUpdate']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

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
                  ->orWhere('public_id', 'like', "%{$search}%")
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

        $perPage = $request->per_page ?? 10;
        $orders = $query->paginate($perPage);
        
        // Get order statuses for filter
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.orders._table', compact('orders', 'statuses', 'paymentStatuses'))->render(),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                    'total' => $orders->total(),
                    'from' => $orders->firstItem(),
                    'to' => $orders->lastItem(),
                ]
            ]);
        }

        return view('admin.orders.index', compact('orders', 'statuses', 'paymentStatuses'));
    }

    /**
     * Quick update order status via AJAX.
     */
    public function quickUpdate(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'sometimes|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded',
            'tracking_number' => 'nullable|string|max:50',
        ]);

        $updateData = [];
        
        if ($request->has('status')) {
            $wasCompleted = $order->status === 'completed';
            $updateData['status'] = $request->status;
            
            // Track purchase interaction when marked as completed
            if (!$wasCompleted && $request->status === 'completed') {
                foreach ($order->items as $item) {
                    \App\Models\UserBookInteraction::record(
                        $order->user_id,
                        $item->book_id,
                        'purchase'
                    );
                }
            }
        }
        
        if ($request->has('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
        }
        
        if ($request->has('tracking_number')) {
            $updateData['tracking_number'] = $request->tracking_number;
        }

        $order->update($updateData);
        $order->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'order' => [
                'id' => $order->id,
                'public_id' => $order->public_id,
                'status' => $order->status,
                'status_badge' => $order->getStatusBadgeClass(),
                'payment_status' => $order->payment_status,
                'payment_badge' => $order->getPaymentStatusBadgeClass(),
                'tracking_number' => $order->tracking_number,
            ]
        ]);
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

        // Track 'purchase' interaction when order is marked as completed
        $wasCompleted = $order->status === 'completed';
        $isNowCompleted = $request->status === 'completed';
        
        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'admin_notes' => $request->admin_notes,
            'tracking_number' => $request->tracking_number,
        ]);

        // If order was just marked as completed, track purchase interactions
        if (!$wasCompleted && $isNowCompleted) {
            foreach ($order->items as $item) {
                \App\Models\UserBookInteraction::record(
                    $order->user_id,
                    $item->book_id,
                    'purchase'
                );
            }
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', "✅ Order #" . ($order->public_id ?? $order->id) . " has been updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Order $order)
    {
        $orderId = $order->public_id ?? $order->id;
        
        // Check if the order can be deleted (e.g., only cancelled orders)
        if ($order->status !== 'cancelled') {
            $errorMessage = "Only cancelled orders can be deleted. Order #{$orderId} is currently '{$order->status}'.";
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 422);
            }
            return redirect()->route('admin.orders.index')
                ->with('error', "⚠️ " . $errorMessage);
        }
        
        // Delete order items first
        $order->items()->delete();
        
        // Delete the order
        $order->delete();

        $successMessage = "Order #{$orderId} has been deleted successfully!";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage
            ]);
        }

        return redirect()->route('admin.orders.index')
            ->with('success', "🗑️ " . $successMessage);
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
