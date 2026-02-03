@extends('layouts.superadmin')

@section('header', 'System Settings')

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-serif font-semibold text-bookty-black mb-6">System Settings</h2>

            <form action="{{ route('superadmin.settings.update') }}" method="POST">
                @csrf

                <!-- General Settings -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-bookty-black mb-4 pb-2 border-b border-gray-200">General Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="settings[site_name]" class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                            <input type="text" name="settings[site_name]" id="settings[site_name]" 
                                value="{{ $settings->has('general') && $settings['general']->where('key', 'site_name')->first() ? $settings['general']->where('key', 'site_name')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                        
                        <div>
                            <label for="settings[site_description]" class="block text-sm font-medium text-gray-700 mb-1">Site Description</label>
                            <input type="text" name="settings[site_description]" id="settings[site_description]" 
                                value="{{ $settings->has('general') && $settings['general']->where('key', 'site_description')->first() ? $settings['general']->where('key', 'site_description')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                        
                        <div>
                            <label for="settings[contact_email]" class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                            <input type="email" name="settings[contact_email]" id="settings[contact_email]" 
                                value="{{ $settings->has('general') && $settings['general']->where('key', 'contact_email')->first() ? $settings['general']->where('key', 'contact_email')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                        
                        <div>
                            <label for="settings[contact_phone]" class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                            <input type="text" name="settings[contact_phone]" id="settings[contact_phone]" 
                                value="{{ $settings->has('general') && $settings['general']->where('key', 'contact_phone')->first() ? $settings['general']->where('key', 'contact_phone')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="settings[address]" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea name="settings[address]" id="settings[address]" rows="2"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">{{ $settings->has('general') && $settings['general']->where('key', 'address')->first() ? $settings['general']->where('key', 'address')->first()->value : '' }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- E-commerce Settings -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-bookty-black mb-4 pb-2 border-b border-gray-200">E-commerce Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="settings[currency]" class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                            <input type="text" name="settings[currency]" id="settings[currency]" 
                                value="{{ $settings->has('ecommerce') && $settings['ecommerce']->where('key', 'currency')->first() ? $settings['ecommerce']->where('key', 'currency')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                        
                        <div>
                            <label for="settings[tax_rate]" class="block text-sm font-medium text-gray-700 mb-1">Tax Rate (%)</label>
                            <input type="number" step="0.01" name="settings[tax_rate]" id="settings[tax_rate]" 
                                value="{{ $settings->has('ecommerce') && $settings['ecommerce']->where('key', 'tax_rate')->first() ? $settings['ecommerce']->where('key', 'tax_rate')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                        
                        <div>
                            <label for="settings[shipping_fee]" class="block text-sm font-medium text-gray-700 mb-1">Shipping Fee</label>
                            <input type="number" step="0.01" name="settings[shipping_fee]" id="settings[shipping_fee]" 
                                value="{{ $settings->has('ecommerce') && $settings['ecommerce']->where('key', 'shipping_fee')->first() ? $settings['ecommerce']->where('key', 'shipping_fee')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                        
                        <div>
                            <label for="settings[free_shipping_min]" class="block text-sm font-medium text-gray-700 mb-1">Minimum Order for Free Shipping</label>
                            <input type="number" step="0.01" name="settings[free_shipping_min]" id="settings[free_shipping_min]" 
                                value="{{ $settings->has('ecommerce') && $settings['ecommerce']->where('key', 'free_shipping_min')->first() ? $settings['ecommerce']->where('key', 'free_shipping_min')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Settings -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-bookty-black mb-4 pb-2 border-b border-gray-200">Social Media Links</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="settings[facebook_url]" class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                            <input type="url" name="settings[facebook_url]" id="settings[facebook_url]" 
                                value="{{ $settings->has('social') && $settings['social']->where('key', 'facebook_url')->first() ? $settings['social']->where('key', 'facebook_url')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                        
                        <div>
                            <label for="settings[instagram_url]" class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                            <input type="url" name="settings[instagram_url]" id="settings[instagram_url]" 
                                value="{{ $settings->has('social') && $settings['social']->where('key', 'instagram_url')->first() ? $settings['social']->where('key', 'instagram_url')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                        
                        <div>
                            <label for="settings[twitter_url]" class="block text-sm font-medium text-gray-700 mb-1">Twitter URL</label>
                            <input type="url" name="settings[twitter_url]" id="settings[twitter_url]" 
                                value="{{ $settings->has('social') && $settings['social']->where('key', 'twitter_url')->first() ? $settings['social']->where('key', 'twitter_url')->first()->value : '' }}"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bookty-purple-500">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700 transition-colors duration-200">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
