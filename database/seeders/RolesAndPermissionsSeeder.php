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
        Permission::create(['name' => 'view books']);
        Permission::create(['name' => 'create books']);
        Permission::create(['name' => 'edit books']);
        Permission::create(['name' => 'delete books']);
        
        // Genre permissions
        Permission::create(['name' => 'view genres']);
        Permission::create(['name' => 'create genres']);
        Permission::create(['name' => 'edit genres']);
        Permission::create(['name' => 'delete genres']);
        
        // Trope permissions
        Permission::create(['name' => 'view tropes']);
        Permission::create(['name' => 'create tropes']);
        Permission::create(['name' => 'edit tropes']);
        Permission::create(['name' => 'delete tropes']);
        
        // Order permissions
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'manage orders']);
        
        // Customer permissions
        Permission::create(['name' => 'view customers']);
        
        // Admin permissions
        Permission::create(['name' => 'access admin']);
        Permission::create(['name' => 'manage admins']);
        
        // Create roles and assign permissions
        
        // Customer role
        $customerRole = Role::create(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'view books',
        ]);
        
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'access admin',
            'view books',
            'create books',
            'edit books',
            'delete books',
            'view genres',
            'create genres',
            'edit genres',
            'delete genres',
            'view tropes',
            'create tropes',
            'edit tropes',
            'delete tropes',
            'view orders',
            'manage orders',
            'view customers',
        ]);
        
        // Superadmin role
        $superadminRole = Role::create(['name' => 'superadmin']);
        $superadminRole->givePermissionTo(Permission::all());
        
        // Create default superadmin user
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@bookty.com',
            'password' => bcrypt('password'),
        ]);
        $superadmin->assignRole($superadminRole);
        
        // Create default admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@bookty.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);
        
        // Create default customer user
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@bookty.com',
            'password' => bcrypt('password'),
        ]);
        $customer->assignRole($customerRole);
    }
}
