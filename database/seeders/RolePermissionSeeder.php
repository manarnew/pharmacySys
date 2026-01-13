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
            'Clinic',
            'Patient',
            'Examination',
            'Prescription',
            'Order',
            'Supplier',
            'Expense',
            'Role',
            'Permission'
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

        // Create Roles and assign permissions
        $adminRole = Role::findOrCreate('Administrator', 'web');
        $allPermissions = Permission::all();
        $adminRole->syncPermissions($allPermissions);

        $receptionistRole = Role::findOrCreate('Receptionist', 'web');
        $receptionistPermissions = [
            'view_patient', 'create_patient', 'edit_patient',
            'view_clinic',
            'view_dashboard'
        ];
        $receptionistRole->syncPermissions($receptionistPermissions);

        $doctorRole = Role::findOrCreate('Doctor', 'web');
        $doctorPermissions = [
            'view_patient',
            'view_examination', 'create_examination', 'edit_examination',
            'view_prescription', 'create_prescription', 'edit_prescription',
            'view_dashboard'
        ];
        $doctorRole->syncPermissions($doctorPermissions);

        // Assign Administrator role to the first user if exists
        $admin = User::where('email', 'admin@admin')->first();
        if ($admin) {
            $admin->assignRole($adminRole);
        }
    }
}
