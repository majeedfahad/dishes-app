<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'manage dishes']);
        Permission::create(['name' => 'manage companies']);
        Permission::create(['name' => 'view reports']);

        // Create roles and assign existing permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo(['manage dishes', 'manage companies']);

        $staff = Role::create(['name' => 'staff']);
        $staff->givePermissionTo(['manage dishes']);
    }
}
