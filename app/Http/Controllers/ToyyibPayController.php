<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ToyyibPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ToyyibPayController extends Controller
{
    protected $toyyibPayService;

    public function __construct(ToyyibPayService $toyyibPayService)
    {
        $this->toyyibPayService = $toyyibPayService;
    }

    /**
     * Handle ToyyibPay callback (server-side notification)
     * This is called by ToyyibPay when payment status changes
     */
    public function callback(Request $request)
    {
        Log::info('ToyyibPay Callback Received', $request->all());

        // Validate required parameters
        $request->validate([
            'refno' => 'required|string',
            'status' => 'required|integer',
            'reason' => 'nullable|string',
            'billcode' => 'required|string',
            'order_id' => 'nullable|string',
            'amount' => 'required|numeric',
            'transaction_time' => 'nullable|string',
            'settlement_reference' => 'nullable|string',
            'settlement_date' => 'nullable|string',
        ]);

        $billCode = $request->billcode;
        $status = $request->status;
        $refNo = $request->refno;
        $amount = $request->amount;
        $orderId = $request->order_id;

        try {
            // Find the order by bill code or external reference
            $order = Order::where('toyyibpay_bill_code', $billCode)
                         ->orWhere('public_id', $orderId)
                         ->first();

            if (!$order) {
                Log::error('ToyyibPay Callback: Order not found', [
                    'bill_code' => $billCode,
                    'order_id' => $orderId,
                    'refno' => $refNo
                ]);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            DB::beginTransaction();

            // Update order based on payment status
            switch ($status) {
                case 1: // Success
                    $updateData = [
                        'payment_status' => 'paid',
                        'status' => 'processing',
                        'toyyibpay_invoice_no' => $refNo,
                        'toyyibpay_payment_date' => now(),
                    ];
                    
                    // Handle transaction_time if provided (ToyyibPay format: DD-MM-YYYY HH:MM:SS)
                    if ($request->has('transaction_time') && $request->transaction_time) {
                        $dateStr = $request->transaction_time;
                        if (preg_match('/(\d{2})-(\d{2})-(\d{4}) (\d{2}:\d{2}:\d{2})/', $dateStr, $matches)) {
                            $updateData['toyyibpay_payment_date'] = $matches[3] . '-' . $matches[2] . '-' . $matches[1] . ' ' . $matches[4];
                        }
                    }
                    
                    // Add settlement fields if provided
                    if ($request->has('settlement_reference') && $request->settlement_reference) {
                        $updateData['toyyibpay_settlement_reference'] = $request->settlement_reference;
                    }
                    
                    if ($request->has('settlement_date') && $request->settlement_date) {
                        $updateData['toyyibpay_settlement_date'] = $request->settlement_date;
                    }
                    
                    $order->update($updateData);
                    
                    Log::info('ToyyibPay Payment Success', [
                        'order_id' => $order->id,
                        'bill_code' => $billCode,
                        'amount' => $amount
                    ]);
                    break;

                case 2: // Pending
                    $order->update([
                        'payment_status' => 'pending',
                    ]);
                    
                    Log::info('ToyyibPay Payment Pending', [
                        'order_id' => $order->id,
                        'bill_code' => $billCode
                    ]);
                    break;

                case 3: // Failed
                    $updateData = [
                        'payment_status' => 'failed',
                        'status' => 'cancelled',
                        'toyyibpay_invoice_no' => $refNo,
                        'toyyibpay_payment_date' => now(),
                    ];
                    
                    // Handle transaction_time if provided
                    if ($request->has('transaction_time') && $request->transaction_time) {
                        $dateStr = $request->transaction_time;
                        if (preg_match('/(\d{2})-(\d{2})-(\d{4}) (\d{2}:\d{2}:\d{2})/', $dateStr, $matches)) {
                            $updateData['toyyibpay_payment_date'] = $matches[3] . '-' . $matches[2] . '-' . $matches[1] . ' ' . $matches[4];
                        }
                    }
                    
                    $order->update($updateData);
                    
                    Log::info('ToyyibPay Payment Failed', [
                        'order_id' => $order->id,
                        'bill_code' => $billCode,
                        'reason' => $request->reason
                    ]);
                    break;

                default:
                    Log::warning('ToyyibPay Unknown Status', [
                        'order_id' => $order->id,
                        'status' => $status
                    ]);
                    break;
            }

            DB::commit();

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('ToyyibPay Callback Error', [
                'message' => $e->getMessage(),
                'bill_code' => $billCode,
                'order_id' => $orderId
            ]);

            return response()->json(['status' => 'error', 'message' => 'Processing failed'], 500);
        }
    }

    /**
     * Handle ToyyibPay return URL (customer redirected back)
     * This is called when customer returns from ToyyibPay
     */
    public function return(Request $request)
    {
        Log::info('ToyyibPay Return URL Accessed', $request->all());

        $statusId = $request->status_id;
        $billCode = $request->billcode;
        $orderId = $request->order_id;

        // Find the order
        $order = Order::where('toyyibpay_bill_code', $billCode)
                     ->orWhere('public_id', $orderId)
                     ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        // Redirect based on payment status
        switch ($statusId) {
            case 1: // Success
                return redirect()->route('checkout.success', ['order' => $order->id])
                    ->with('success', 'Payment completed successfully!');

            case 2: // Pending
                return redirect()->route('profile.orders.show', $order)
                    ->with('info', 'Your payment is being processed. You will be notified once completed.');

            case 3: // Failed
                return redirect()->route('profile.orders.show', $order)
                    ->with('error', 'Payment failed. Please try again or contact support.');

            default:
                return redirect()->route('profile.orders.show', $order)
                    ->with('warning', 'Payment status unknown. Please contact support.');
        }
    }

    /**
     * Check payment status manually
     */
    public function checkStatus(Request $request, Order $order)
    {
        if (!$order->hasToyyibPayPayment()) {
            return response()->json(['error' => 'Order does not have ToyyibPay payment'], 400);
        }

        $transactions = $this->toyyibPayService->getBillTransactions($order->toyyibpay_bill_code);

        if (!$transactions) {
            return response()->json(['error' => 'Unable to fetch payment status'], 500);
        }

        return response()->json([
            'order' => $order,
            'transactions' => $transactions
        ]);
    }
}