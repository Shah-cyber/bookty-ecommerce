<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General settings
        Setting::setValue('site_name', 'Bookty Enterprise', 'general');
        Setting::setValue('site_description', 'Malaysian Romance Novel E-commerce', 'general');
        Setting::setValue('contact_email', 'contact@bookty.com', 'general');
        Setting::setValue('contact_phone', '+60123456789', 'general');
        Setting::setValue('address', 'Kuala Lumpur, Malaysia', 'general');
        
        // E-commerce settings
        Setting::setValue('currency', 'MYR', 'ecommerce');
        Setting::setValue('tax_rate', '6', 'ecommerce');
        Setting::setValue('shipping_fee', '10', 'ecommerce');
        Setting::setValue('free_shipping_min', '100', 'ecommerce');
        
        // Social media links
        Setting::setValue('facebook_url', 'https://facebook.com/bookty', 'social');
        Setting::setValue('instagram_url', 'https://instagram.com/bookty', 'social');
        Setting::setValue('twitter_url', 'https://twitter.com/bookty', 'social');
    }
}
