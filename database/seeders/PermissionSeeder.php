<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'manage_users', 'display_name' => 'Manage Users', 'description' => 'Create, edit, and delete users'],
            ['name' => 'manage_visitors', 'display_name' => 'Manage Visitors', 'description' => 'Create, edit, and delete visitors'],
            ['name' => 'manage_prearrival', 'display_name' => 'Manage Pre-Arrival', 'description' => 'Create and manage pre-arrival forms'],
            ['name' => 'manage_housing', 'display_name' => 'Manage Housing', 'description' => 'Manage buildings, floors, rooms, and assignments'],
            ['name' => 'view_reports', 'display_name' => 'View Reports', 'description' => 'View and export reports'],
            ['name' => 'import_export', 'display_name' => 'Import/Export', 'description' => 'Import and export data'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Assign all permissions to super-admin
        $superAdmin = Role::where('name', 'super-admin')->first();
        if ($superAdmin) {
            $superAdmin->permissions()->sync(Permission::pluck('id'));
        }

        // Assign most permissions to admin (except manage_users)
        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $admin->permissions()->sync(
                Permission::where('name', '!=', 'manage_users')->pluck('id')
            );
        }

        // Assign limited permissions to staff
        $staff = Role::where('name', 'staff')->first();
        if ($staff) {
            $staff->permissions()->sync(
                Permission::whereIn('name', ['manage_visitors', 'view_reports'])->pluck('id')
            );
        }
    }
}
