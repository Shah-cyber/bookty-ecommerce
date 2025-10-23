<?php

namespace App\Console\Commands;

use App\Services\ToyyibPayService;
use Illuminate\Console\Command;

class SetupToyyibPayCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toyyibpay:setup-category {--name=Bookty Orders} {--description=E-commerce book orders}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a ToyyibPay category for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name');
        $description = $this->option('description');

        $this->info('Creating ToyyibPay category...');
        $this->info("Name: {$name}");
        $this->info("Description: {$description}");

        $toyyibPay = new ToyyibPayService();
        $categoryCode = $toyyibPay->createCategory($name, $description);

        if ($categoryCode) {
            $this->info("✅ Category created successfully!");
            $this->info("Category Code: {$categoryCode}");
            $this->newLine();
            $this->info("Add this to your .env file:");
            $this->line("TOYYIBPAY_CATEGORY_CODE={$categoryCode}");
        } else {
            $this->error("❌ Failed to create category. Please check your ToyyibPay configuration.");
            $this->newLine();
            $this->info("Make sure you have set the following in your .env file:");
            $this->line("TOYYIBPAY_SECRET_KEY=your_secret_key_here");
            $this->line("TOYYIBPAY_CATEGORY_CODE=your_category_code_here");
        }
    }
}