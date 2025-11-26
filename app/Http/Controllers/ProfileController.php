<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    
    /**
     * Display the user's orders.
     */
    public function orders(Request $request): View
    {
        $orders = $request->user()->orders()->latest()->paginate(10);
        
        return view('profile.orders', [
            'orders' => $orders,
        ]);
    }
    
    /**
     * Display a specific order.
     */
    public function showOrder(Request $request, $id): View
    {
        $order = Order::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->with(['items.book'])
            ->firstOrFail();
        
        return view('profile.order-detail', [
            'order' => $order,
        ]);
    }
    
    /**
     * Display invoice for a specific order.
     */
    public function invoice(Request $request, $id): View
    {
        $order = Order::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->with(['items.book', 'user'])
            ->firstOrFail();

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

        // Calculate proper invoice totals
        $taxRate = 0.00; // 0% - Tax not included
        $subTotal = $order->items->sum(function($i){ return $i->price * $i->quantity; });
        $discount = $order->discount_amount ?? 0;
        $shippingCost = $order->is_free_shipping ? 0 : ($order->shipping_customer_price ?? 0);
        $taxable = max(0, $subTotal - $discount);
        $taxAmount = 0; // No tax
        $grandTotal = $taxable + $shippingCost; // Subtotal + Shipping

        return view('profile.invoice', compact('order', 'seller', 'invoiceNumber', 'taxRate', 'subTotal', 'discount', 'shippingCost', 'taxAmount', 'grandTotal'));
    }

    /**
     * Download invoice as PDF for a specific order.
     */
    public function invoicePdf(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->with(['items.book', 'user'])
            ->firstOrFail();
            
        $seller = [
            'company' => config('app.name', 'Bookty'),
            'address' => '123 Book Street, Kuala Lumpur, MY',
            'tax_number' => 'TAX-1234567890',
            'email' => 'accounts@bookty.local',
            'phone' => '+60 12-345 6789',
        ];
        $invoiceNumber = ($order->public_id ?? $order->id) . '-' . $order->created_at->format('Ymd');
        $taxRate = 0.00; // 0% - Tax not included
        $subTotal = $order->items->sum(function($i){ return $i->price * $i->quantity; });
        $discount = $order->discount_amount ?? 0;
        $shippingCost = $order->is_free_shipping ? 0 : ($order->shipping_customer_price ?? 0);
        $taxable = max(0, $subTotal - $discount);
        $taxAmount = 0; // No tax
        $grandTotal = $taxable + $shippingCost; // Subtotal + Shipping

        $pdf = Pdf::loadView('profile.invoice-pdf', compact('order', 'seller', 'invoiceNumber', 'taxRate', 'subTotal', 'discount', 'shippingCost', 'taxAmount', 'grandTotal'))
            ->setPaper('a4');

        return $pdf->download('invoice_'.$invoiceNumber.'.pdf');
    }
}