<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\ToyyibPayService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncToyyibPayPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toyyibpay:sync-payments 
                            {--order-id= : Sync specific order by ID}
                            {--all : Sync all orders with missing invoice numbers}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync ToyyibPay payment data (invoice number and payment date) for orders';

    protected $toyyibPayService;

    public function __construct(ToyyibPayService $toyyibPayService)
    {
        parent::__construct();
        $this->toyyibPayService = $toyyibPayService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->option('order-id');
        $syncAll = $this->option('all');

        if ($orderId) {
            $order = Order::find($orderId);
            if (!$order) {
                $this->error("Order #{$orderId} not found.");
                return 1;
            }
            $this->syncOrder($order);
        } elseif ($syncAll) {
            // Find all orders with bill code but missing invoice number
            $orders = Order::whereNotNull('toyyibpay_bill_code')
                          ->where(function($query) {
                              $query->whereNull('toyyibpay_invoice_no')
                                    ->orWhereNull('toyyibpay_payment_date');
                          })
                          ->where('payment_status', 'paid')
                          ->get();

            if ($orders->isEmpty()) {
                $this->info('No orders found that need syncing.');
                return 0;
            }

            $this->info("Found {$orders->count()} orders to sync.");
            $bar = $this->output->createProgressBar($orders->count());
            $bar->start();

            $synced = 0;
            $failed = 0;

            foreach ($orders as $order) {
                if ($this->syncOrder($order, false)) {
                    $synced++;
                } else {
                    $failed++;
                }
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info("Synced: {$synced}, Failed: {$failed}");
        } else {
            $this->error('Please specify --order-id=ID or --all flag.');
            $this->info('Usage: php artisan toyyibpay:sync-payments --order-id=32');
            $this->info('   or: php artisan toyyibpay:sync-payments --all');
            return 1;
        }

        return 0;
    }

    protected function syncOrder(Order $order, $verbose = true)
    {
        if (!$order->toyyibpay_bill_code) {
            if ($verbose) {
                $this->warn("Order #{$order->id} has no bill code. Skipping.");
            }
            return false;
        }

        if ($verbose) {
            $this->info("Fetching payment data for Order #{$order->id} (Bill Code: {$order->toyyibpay_bill_code})...");
        }

        $transactions = $this->toyyibPayService->getBillTransactions($order->toyyibpay_bill_code);

        if (!$transactions || !is_array($transactions) || empty($transactions)) {
            if ($verbose) {
                $this->warn("No transaction data found for bill code: {$order->toyyibpay_bill_code}");
            }
            Log::warning('SyncToyyibPayPayments: No transactions', [
                'order_id' => $order->id,
                'bill_code' => $order->toyyibpay_bill_code
            ]);
            return false;
        }

        // Find the first successful transaction
        $transaction = null;
        foreach ($transactions as $txn) {
            if (isset($txn['billpaymentStatus']) && $txn['billpaymentStatus'] == '1') {
                $transaction = $txn;
                break;
            }
        }
        
        // If no successful transaction, use the first one
        if (!$transaction && isset($transactions[0])) {
            $transaction = $transactions[0];
        }

        if (!$transaction) {
            if ($verbose) {
                $this->warn("No valid transaction found for bill code: {$order->toyyibpay_bill_code}");
            }
            return false;
        }

        $updateData = [];
        $updated = false;

        // Try multiple possible field names for invoice number
        // Note: ToyyibPay API uses 'billpaymentInvoiceNo' for the invoice number
        $invoiceNo = $transaction['billpaymentInvoiceNo'] ??
                    $transaction['refno'] ?? 
                    $transaction['transaction_id'] ?? 
                    $transaction['invoice_no'] ?? 
                    $transaction['transactionId'] ??
                    $transaction['RefNo'] ??
                    null;

        if ($invoiceNo && !empty($invoiceNo) && !$order->toyyibpay_invoice_no) {
            $updateData['toyyibpay_invoice_no'] = $invoiceNo;
            $updated = true;
            if ($verbose) {
                $this->info("  ✓ Invoice Number: {$invoiceNo}");
            }
        }

        // Try multiple possible field names for transaction time
        // Note: ToyyibPay API uses 'billPaymentDate' for the payment date
        $transTime = $transaction['billPaymentDate'] ??
                    $transaction['transactionTime'] ?? 
                    $transaction['transaction_time'] ?? 
                    $transaction['paid_at'] ??
                    $transaction['TransactionTime'] ??
                    null;

        if ($transTime && !empty($transTime) && !$order->toyyibpay_payment_date) {
            $dateStr = $transTime;
            if (preg_match('/(\d{2})-(\d{2})-(\d{4}) (\d{2}:\d{2}:\d{2})/', $dateStr, $matches)) {
                $updateData['toyyibpay_payment_date'] = $matches[3] . '-' . $matches[2] . '-' . $matches[1] . ' ' . $matches[4];
            } elseif (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}:\d{2}:\d{2})/', $dateStr, $matches)) {
                $updateData['toyyibpay_payment_date'] = $dateStr;
            }
            
            if (isset($updateData['toyyibpay_payment_date'])) {
                $updated = true;
                if ($verbose) {
                    $this->info("  ✓ Payment Date: {$updateData['toyyibpay_payment_date']}");
                }
            }
        }

        if ($updated) {
            $order->update($updateData);
            if ($verbose) {
                $this->info("  ✓ Order #{$order->id} updated successfully!");
            }
            Log::info('SyncToyyibPayPayments: Order updated', [
                'order_id' => $order->id,
                'update_data' => $updateData
            ]);
            return true;
        } else {
            if ($verbose) {
                $this->warn("  No new data to update for Order #{$order->id}");
            }
            return false;
        }
    }
}
