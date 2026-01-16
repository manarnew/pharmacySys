<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define models
        $models = [
            'User',
            'Branch',
            'Customer',
            'Supplier',
            'Expense',
            'Role',
            'Permission',
            'Category',
            'Product',
            'Store',
            'Purchase',
            'Sale',
            'Inventory',
        ];

        // Define actions
        $actions = ['view', 'create', 'edit', 'delete'];

        // Create Permissions
        foreach ($models as $model) {
            foreach ($actions as $action) {
                Permission::findOrCreate(strtolower($action . '_' . $model), 'web');
            }
        }

        // Additional specific permissions
        Permission::findOrCreate('view_dashboard', 'web');
        Permission::findOrCreate('view_reports', 'web');
        
        // Stocktake Permissions
        Permission::findOrCreate('stocktake_view', 'web');
        Permission::findOrCreate('stocktake_create', 'web');
        Permission::findOrCreate('stocktake_approve', 'web');

        // Create Roles and assign permissions
        $adminRole = Role::findOrCreate('Administrator', 'web');
        $allPermissions = Permission::all();
        $adminRole->syncPermissions($allPermissions);

        $staffRole = Role::findOrCreate('Staff', 'web');
        $staffPermissions = [
            'view_customer', 'create_customer', 'edit_customer',
            'view_branch',
            'view_dashboard'
        ];
        $staffRole->syncPermissions($staffPermissions);

        // Assign Administrator role to the first user if exists
        $admin = User::where('email', 'admin@admin')->first();
        if ($admin) {
            $admin->assignRole($adminRole);
        }
    }
}
