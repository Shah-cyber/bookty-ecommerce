<?php

namespace Database\Seeders;

use App\Services\PostageRateService;
use Illuminate\Database\Seeder;

class PostageRateHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder initializes history records for all existing postage rates.
     * Run this ONCE after adding the postage_rate_history table.
     */
    public function run(): void
    {
        $service = new PostageRateService();
        
        $this->command->info('Initializing postage rate history...');
        
        $count = $service->initializeHistory();
        
        if ($count > 0) {
            $this->command->info("✓ Created {$count} initial history record(s)");
        } else {
            $this->command->warn('No new history records created (they may already exist)');
        }
        
        // Display current rates
        $this->command->info("\nCurrent postage rates:");
        $this->command->table(
            ['Region', 'Customer Price', 'Actual Cost', 'Profit Margin'],
            \App\Models\PostageRate::all()->map(function ($rate) {
                return [
                    $rate->region,
                    'RM ' . number_format($rate->customer_price, 2),
                    'RM ' . number_format($rate->actual_cost, 2),
                    number_format($rate->getProfitMargin(), 2) . '%',
                ];
            })
        );
        
        $this->command->info("\n✓ Postage rate history initialized successfully!");
    }
}
