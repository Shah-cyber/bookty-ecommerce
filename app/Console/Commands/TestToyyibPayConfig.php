<?php

namespace App\Console\Commands;

use App\Services\ToyyibPayService;
use Illuminate\Console\Command;

class TestToyyibPayConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toyyibpay:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test ToyyibPay configuration and connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing ToyyibPay Configuration...');
        $this->newLine();

        // Check environment variables
        $secretKey = config('services.toyyibpay.secret_key');
        $categoryCode = config('services.toyyibpay.category_code');

        $this->info('Configuration Check:');
        $this->line("Secret Key: " . ($secretKey ? '✅ Set' : '❌ Not set'));
        $this->line("Category Code: " . ($categoryCode ? '✅ Set' : '❌ Not set'));
        $this->newLine();

        if (!$secretKey || !$categoryCode) {
            $this->error('❌ ToyyibPay configuration is incomplete!');
            $this->newLine();
            $this->info('Please add these to your .env file:');
            $this->line('TOYYIBPAY_SECRET_KEY=your_secret_key_here');
            $this->line('TOYYIBPAY_CATEGORY_CODE=your_category_code_here');
            return 1;
        }

        // Test API connection
        $this->info('Testing API Connection...');
        $toyyibPay = new ToyyibPayService();
        
        try {
            $categoryDetails = $toyyibPay->getCategoryDetails();
            
            if ($categoryDetails && is_array($categoryDetails) && count($categoryDetails) > 0) {
                $this->info('✅ API Connection Successful!');
                $this->line('Category Details:');
                if (isset($categoryDetails[0]) && is_array($categoryDetails[0])) {
                    foreach ($categoryDetails[0] as $key => $value) {
                        $this->line("  {$key}: {$value}");
                    }
                } else {
                    $this->line('  Response: ' . json_encode($categoryDetails));
                }
            } else {
                $this->error('❌ API Connection Failed!');
                $this->line('Please check your credentials and try again.');
            }
        } catch (\Exception $e) {
            $this->error('❌ API Connection Error: ' . $e->getMessage());
        }

        return 0;
    }
}