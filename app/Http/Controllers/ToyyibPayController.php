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
                        // Keep status as 'pending' (Order Placed) - admin will update to 'processing' when preparing
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
        // ToyyibPay sends invoice number as 'transaction_id' in return URL, not 'refno'
        $refNo = $request->transaction_id ?? $request->refno; // Invoice/Reference number
        $transactionTime = $request->transaction_time; // Payment date/time
        
        Log::info('ToyyibPay Return: Extracted Parameters', [
            'status_id' => $statusId,
            'billcode' => $billCode,
            'transaction_id' => $request->transaction_id,
            'refno' => $request->refno,
            'transaction_time' => $transactionTime,
            'all_params' => $request->all()
        ]);

        // Find the order
        $order = Order::where('toyyibpay_bill_code', $billCode)
                     ->orWhere('public_id', $orderId)
                     ->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        // Update order with payment information from return URL
        try {
            DB::beginTransaction();
            
            $updateData = [];
            
            // If payment is successful, update invoice and payment date
            if ($statusId == 1) {
                $updateData['payment_status'] = 'paid';
                // Keep status as 'pending' (Order Placed) - admin will update to 'processing' when preparing
                
                // Update invoice number if provided
                if ($refNo) {
                    $updateData['toyyibpay_invoice_no'] = $refNo;
                }
                
                // Update payment date
                if ($transactionTime) {
                    // Handle ToyyibPay format: DD-MM-YYYY HH:MM:SS
                    if (preg_match('/(\d{2})-(\d{2})-(\d{4}) (\d{2}:\d{2}:\d{2})/', $transactionTime, $matches)) {
                        $updateData['toyyibpay_payment_date'] = $matches[3] . '-' . $matches[2] . '-' . $matches[1] . ' ' . $matches[4];
                    } else {
                        $updateData['toyyibpay_payment_date'] = now();
                    }
                } else {
                    $updateData['toyyibpay_payment_date'] = now();
                }
                
                // If invoice number not in return URL, try to fetch from API
                // Note: Invoice number is usually generated after payment, so it might not be in return URL
                if (!$refNo && $billCode) {
                    Log::info('ToyyibPay Return: Fetching transaction details from API', [
                        'bill_code' => $billCode,
                        'order_id' => $order->id
                    ]);
                    
                    $transactions = $this->toyyibPayService->getBillTransactions($billCode);
                    
                    Log::info('ToyyibPay Return: API Response', [
                        'bill_code' => $billCode,
                        'transactions' => $transactions
                    ]);
                    
                    if ($transactions && is_array($transactions) && !empty($transactions)) {
                        // Try to find the first successful transaction
                        $transaction = null;
                        foreach ($transactions as $txn) {
                            if (isset($txn['billpaymentStatus']) && $txn['billpaymentStatus'] == '1') {
                                $transaction = $txn;
                                break;
                            }
                        }
                        // If no successful transaction found, use the first one
                        if (!$transaction && isset($transactions[0])) {
                            $transaction = $transactions[0];
                        }
                        
                        if ($transaction) {
                            Log::info('ToyyibPay Return: Processing Transaction', [
                                'transaction' => $transaction
                            ]);
                            
                            // Try multiple possible field names for invoice number
                            // Note: ToyyibPay API uses 'billpaymentInvoiceNo' for the invoice number
                            $invoiceNo = $transaction['billpaymentInvoiceNo'] ??
                                        $transaction['refno'] ?? 
                                        $transaction['transaction_id'] ?? 
                                        $transaction['invoice_no'] ?? 
                                        $transaction['transactionId'] ??
                                        $transaction['RefNo'] ??
                                        $transaction['billpaymentInvoiceNo'] ??
                                        null;
                            
                            if ($invoiceNo && !empty($invoiceNo)) {
                                $updateData['toyyibpay_invoice_no'] = $invoiceNo;
                                Log::info('ToyyibPay Return: Invoice number found', ['invoice_no' => $invoiceNo]);
                            } else {
                                Log::warning('ToyyibPay Return: No invoice number in transaction', [
                                    'transaction_keys' => array_keys($transaction)
                                ]);
                            }
                            
                            // Try multiple possible field names for transaction time
                            // Note: ToyyibPay API uses 'billPaymentDate' for the payment date
                            $transTime = $transaction['billPaymentDate'] ??
                                        $transaction['transactionTime'] ?? 
                                        $transaction['transaction_time'] ?? 
                                        $transaction['paid_at'] ??
                                        $transaction['TransactionTime'] ??
                                        null;
                            
                            if ($transTime && !empty($transTime)) {
                                $dateStr = $transTime;
                                if (preg_match('/(\d{2})-(\d{2})-(\d{4}) (\d{2}:\d{2}:\d{2})/', $dateStr, $matches)) {
                                    $updateData['toyyibpay_payment_date'] = $matches[3] . '-' . $matches[2] . '-' . $matches[1] . ' ' . $matches[4];
                                } elseif (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}:\d{2}:\d{2})/', $dateStr, $matches)) {
                                    // Already in correct format
                                    $updateData['toyyibpay_payment_date'] = $dateStr;
                                }
                                Log::info('ToyyibPay Return: Payment date found', ['payment_date' => $updateData['toyyibpay_payment_date'] ?? null]);
                            }
                        } else {
                            Log::warning('ToyyibPay Return: No valid transaction found', [
                                'transactions_count' => count($transactions)
                            ]);
                        }
                    } else {
                        Log::warning('ToyyibPay Return: No transactions returned from API', [
                            'bill_code' => $billCode
                        ]);
                    }
                }
            } elseif ($statusId == 3) {
                // Payment failed
                $updateData['payment_status'] = 'failed';
                $updateData['status'] = 'cancelled';
                
                if ($refNo) {
                    $updateData['toyyibpay_invoice_no'] = $refNo;
                }
                if ($transactionTime) {
                    if (preg_match('/(\d{2})-(\d{2})-(\d{4}) (\d{2}:\d{2}:\d{2})/', $transactionTime, $matches)) {
                        $updateData['toyyibpay_payment_date'] = $matches[3] . '-' . $matches[2] . '-' . $matches[1] . ' ' . $matches[4];
                    } else {
                        $updateData['toyyibpay_payment_date'] = now();
                    }
                }
            }
            
            // Update order if we have data to update
            if (!empty($updateData)) {
                $order->update($updateData);
                Log::info('ToyyibPay Return: Order Updated', [
                    'order_id' => $order->id,
                    'status_id' => $statusId,
                    'update_data' => $updateData
                ]);
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ToyyibPay Return: Update Error', [
                'message' => $e->getMessage(),
                'order_id' => $order->id
            ]);
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