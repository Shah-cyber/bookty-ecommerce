<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        
        // Book permissions
        Permission::firstOrCreate(['name' => 'view books']);
        Permission::firstOrCreate(['name' => 'create books']);
        Permission::firstOrCreate(['name' => 'edit books']);
        Permission::firstOrCreate(['name' => 'delete books']);
        
        // Genre permissions
        Permission::firstOrCreate(['name' => 'view genres']);
        Permission::firstOrCreate(['name' => 'create genres']);
        Permission::firstOrCreate(['name' => 'edit genres']);
        Permission::firstOrCreate(['name' => 'delete genres']);
        
        // Trope permissions
        Permission::firstOrCreate(['name' => 'view tropes']);
        Permission::firstOrCreate(['name' => 'create tropes']);
        Permission::firstOrCreate(['name' => 'edit tropes']);
        Permission::firstOrCreate(['name' => 'delete tropes']);
        
        // Order permissions
        Permission::firstOrCreate(['name' => 'view orders']);
        Permission::firstOrCreate(['name' => 'manage orders']);
        
        // Customer permissions
        Permission::firstOrCreate(['name' => 'view customers']);
        
        // Discount & Promotion permissions
        Permission::firstOrCreate(['name' => 'view discounts']);
        Permission::firstOrCreate(['name' => 'create discounts']);
        Permission::firstOrCreate(['name' => 'edit discounts']);
        Permission::firstOrCreate(['name' => 'delete discounts']);
        
        // Coupon permissions
        Permission::firstOrCreate(['name' => 'view coupons']);
        Permission::firstOrCreate(['name' => 'create coupons']);
        Permission::firstOrCreate(['name' => 'edit coupons']);
        Permission::firstOrCreate(['name' => 'delete coupons']);
        
        // Flash sale permissions
        Permission::firstOrCreate(['name' => 'view flash sales']);
        Permission::firstOrCreate(['name' => 'create flash sales']);
        Permission::firstOrCreate(['name' => 'edit flash sales']);
        Permission::firstOrCreate(['name' => 'delete flash sales']);
        
        // Report permissions
        Permission::firstOrCreate(['name' => 'view reports']);
        Permission::firstOrCreate(['name' => 'export reports']);
        
        // Review permissions
        Permission::firstOrCreate(['name' => 'view reviews']);
        Permission::firstOrCreate(['name' => 'manage reviews']);
        
        // Settings permissions
        Permission::firstOrCreate(['name' => 'view settings']);
        Permission::firstOrCreate(['name' => 'edit settings']);
        
        // Postage permissions
        Permission::firstOrCreate(['name' => 'view postage rates']);
        Permission::firstOrCreate(['name' => 'manage postage rates']);
        
        // Recommendation permissions
        Permission::firstOrCreate(['name' => 'view recommendations']);
        Permission::firstOrCreate(['name' => 'manage recommendations']);
        
        // Access permissions
        Permission::firstOrCreate(['name' => 'access admin']);
        Permission::firstOrCreate(['name' => 'access superadmin']);
        
        // Admin management permissions (superadmin only)
        Permission::firstOrCreate(['name' => 'manage admins']);
        Permission::firstOrCreate(['name' => 'manage roles']);
        Permission::firstOrCreate(['name' => 'manage permissions']);
        Permission::firstOrCreate(['name' => 'manage system settings']);
        
        // Create roles and assign permissions
        
        // Customer role
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->syncPermissions([
            'view books',
        ]);
        
        // Admin role - can access admin panel and manage store content
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions([
            // Access
            'access admin',
            
            // Books
            'view books',
            'create books',
            'edit books',
            'delete books',
            
            // Genres
            'view genres',
            'create genres',
            'edit genres',
            'delete genres',
            
            // Tropes
            'view tropes',
            'create tropes',
            'edit tropes',
            'delete tropes',
            
            // Orders
            'view orders',
            'manage orders',
            
            // Customers
            'view customers',
            
            // Discounts
            'view discounts',
            'create discounts',
            'edit discounts',
            'delete discounts',
            
            // Coupons
            'view coupons',
            'create coupons',
            'edit coupons',
            'delete coupons',
            
            // Flash Sales
            'view flash sales',
            'create flash sales',
            'edit flash sales',
            'delete flash sales',
            
            // Reports
            'view reports',
            'export reports',
            
            // Reviews
            'view reviews',
            'manage reviews',
            
            // Settings (view only for admin)
            'view settings',
            
            // Postage
            'view postage rates',
            'manage postage rates',
            
            // Recommendations
            'view recommendations',
            'manage recommendations',
        ]);
        
        // Superadmin role - gets ALL permissions
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $superadminRole->syncPermissions(Permission::all());
        
        // Create default superadmin user if not exists
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@bookty.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );
        if (!$superadmin->hasRole('superadmin')) {
            $superadmin->assignRole($superadminRole);
        }
        
        // Create default admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@bookty.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
        
        // Create default customer user if not exists
        $customer = User::firstOrCreate(
            ['email' => 'customer@bookty.com'],
            [
                'name' => 'Customer User',
                'password' => bcrypt('password'),
            ]
        );
        if (!$customer->hasRole('customer')) {
            $customer->assignRole($customerRole);
        }
    }
}
