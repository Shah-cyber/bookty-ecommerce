<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ToyyibPayService
{
    private $userSecretKey;
    private $categoryCode;

    public function __construct()
    {
        $this->userSecretKey = config('services.toyyibpay.secret_key');
        $this->categoryCode = config('services.toyyibpay.category_code');
    }

    /**
     * Create a category for ToyyibPay
     */
    public function createCategory($name, $description)
    {
        $data = [
            'catname' => $name,
            'catdescription' => $description,
            'userSecretKey' => $this->userSecretKey
        ];

        try {
            $response = Http::asForm()->post('https://dev.toyyibpay.com/index.php/api/createCategory', $data);
            
            if ($response->successful()) {
                $result = $response->json();
                if (isset($result[0]['CategoryCode'])) {
                    return $result[0]['CategoryCode'];
                }
            }
            
            Log::error('ToyyibPay Category Creation Failed', [
                'response' => $response->body(),
                'status' => $response->status()
            ]);
            
            return false;
        } catch (\Exception $e) {
            Log::error('ToyyibPay Category Creation Exception', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Create a bill for payment
     */
    public function createBill($orderData)
    {
        $data = [
            'userSecretKey' => $this->userSecretKey,
            'categoryCode' => $this->categoryCode,
            'billName' => $orderData['bill_name'],
            'billDescription' => $orderData['bill_description'],
            'billPriceSetting' => 1, // Fixed amount
            'billPayorInfo' => 1, // Require payer information
            'billAmount' => $orderData['amount'], // Amount in cents
            'billReturnUrl' => $orderData['return_url'],
            'billCallbackUrl' => $orderData['callback_url'],
            'billExternalReferenceNo' => $orderData['reference_no'],
            'billTo' => $orderData['customer_name'],
            'billEmail' => $orderData['customer_email'],
            'billPhone' => $orderData['customer_phone'],
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => 0, // FPX only
            'billContentEmail' => $orderData['email_content'] ?? '',
            'billChargeToCustomer' => 0, // Charge FPX to customer
            'billExpiryDays' => 3 // Bill expires in 3 days
        ];

        try {
            $response = Http::asForm()->post('https://dev.toyyibpay.com/index.php/api/createBill', $data);
            
            if ($response->successful()) {
                $result = $response->json();
                if (isset($result[0]['BillCode'])) {
                    return [
                        'success' => true,
                        'bill_code' => $result[0]['BillCode'],
                        'payment_url' => 'https://dev.toyyibpay.com/' . $result[0]['BillCode']
                    ];
                }
            }
            
            Log::error('ToyyibPay Bill Creation Failed', [
                'response' => $response->body(),
                'status' => $response->status(),
                'data' => $data
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to create payment bill'
            ];
        } catch (\Exception $e) {
            Log::error('ToyyibPay Bill Creation Exception', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);
            
            return [
                'success' => false,
                'message' => 'Payment service unavailable'
            ];
        }
    }

    /**
     * Get bill transaction status
     */
    public function getBillTransactions($billCode, $status = null)
    {
        $data = [
            'userSecretKey' => $this->userSecretKey,
            'billCode' => $billCode
        ];

        if ($status) {
            $data['billpaymentStatus'] = $status;
        }

        try {
            $response = Http::asForm()->post('https://dev.toyyibpay.com/index.php/api/getBillTransactions', $data);
            
            if ($response->successful()) {
                $result = $response->json();
                return $result;
            }
            
            Log::error('ToyyibPay Get Transactions Failed', [
                'response' => $response->body(),
                'status' => $response->status()
            ]);
            
            return false;
        } catch (\Exception $e) {
            Log::error('ToyyibPay Get Transactions Exception', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get category details
     */
    public function getCategoryDetails()
    {
        $data = [
            'userSecretKey' => $this->userSecretKey,
            'categoryCode' => $this->categoryCode
        ];

        try {
            $response = Http::asForm()->post('https://dev.toyyibpay.com/index.php/api/getCategoryDetails', $data);
            
            if ($response->successful()) {
                $result = $response->json();
                return $result;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('ToyyibPay Get Category Exception', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Inactive a bill
     */
    public function inactiveBill($billCode)
    {
        $data = [
            'secretKey' => $this->userSecretKey,
            'billCode' => $billCode
        ];

        try {
            $response = Http::asForm()->post('https://dev.toyyibpay.com/index.php/api/inactiveBill', $data);
            
            if ($response->successful()) {
                $result = $response->json();
                return $result;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('ToyyibPay Inactive Bill Exception', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Convert amount to cents (ToyyibPay requirement)
     */
    public function convertToCents($amount)
    {
        return (int) round($amount * 100);
    }

    /**
     * Convert cents to amount
     */
    public function convertFromCents($cents)
    {
        return $cents / 100;
    }
}
