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

        /*
         * Permissions
         * Keep this list in sync with the permissions you manage from the SuperAdmin UI,
         * so new deployments (and fresh databases) get the same capabilities as local.
         */

        $permissions = [
            // Book permissions
            'view books',
            'create books',
            'edit books',
            'delete books',

            // Genre permissions
            'view genres',
            'create genres',
            'edit genres',
            'delete genres',

            // Trope permissions
            'view tropes',
            'create tropes',
            'edit tropes',
            'delete tropes',

            // Order permissions
            'view orders',
            'manage orders',

            // Customer permissions
            'view customers',

            // Discount permissions
            'view discounts',
            'create discounts',
            'edit discounts',
            'delete discounts',

            // Coupon permissions
            'view coupons',
            'create coupons',
            'edit coupons',
            'delete coupons',

            // Flash sale permissions
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

            // Settings
            'view settings',
            'edit settings',

            // Postage rates
            'view postage rates',
            'manage postage rates',

            // Recommendations
            'view recommendations',
            'manage recommendations',

            // Admin / system permissions
            'access admin',
            'manage admins',
            'manage roles',
            'manage permissions',
            'manage system settings',
            'access superadmin',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        // Create roles and assign permissions to match your current local database

        // Customer role
        $customerRole = Role::firstOrCreate(
            ['name' => 'customer', 'guard_name' => 'web']
        );
        $customerRole->syncPermissions([
            'view books',
        ]);

        // Admin role
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web']
        );
        $adminRole->syncPermissions([
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

            // Orders & customers
            'view orders',
            'manage orders',
            'view customers',

            // Promotions
            'view discounts',
            'create discounts',
            'edit discounts',
            'delete discounts',

            'view coupons',
            'create coupons',
            'edit coupons',
            'delete coupons',

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

            // Settings & postage
            'view settings',
            'view postage rates',
            'manage postage rates',

            // Recommendations
            'view recommendations',
            'manage recommendations',
        ]);

        // Superadmin role – full access to everything
        $superadminRole = Role::firstOrCreate(
            ['name' => 'superadmin', 'guard_name' => 'web']
        );
        $superadminRole->syncPermissions(Permission::all());

        // Create / update default users and assign roles

        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@bookty.com'],
            ['name' => 'Super Admin', 'password' => bcrypt('password')]
        );
        $superadmin->assignRole($superadminRole);

        $admin = User::firstOrCreate(
            ['email' => 'admin@bookty.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        $admin->assignRole($adminRole);

        $customer = User::firstOrCreate(
            ['email' => 'customer@bookty.com'],
            ['name' => 'Customer User', 'password' => bcrypt('password')]
        );
        $customer->assignRole($customerRole);
    }
}
