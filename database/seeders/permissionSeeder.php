<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'View Users']);
        Permission::create(['name' => 'Add User']);
        Permission::create(['name' => 'Edit User']);
        Permission::create(['name' => 'Delete User']);
        Permission::create(['name' => 'View Owner Account']);
        Permission::create(['name' => 'View Admin Account']);
        Permission::create(['name' => 'View Permissions']);
        Permission::create(['name' => 'View User Permissions']);
        Permission::create(['name' => 'Assign Permissions To User']);
        Permission::create(['name' => 'Add Role']);
        Permission::create(['name' => 'View Roles']);
        Permission::create(['name' => 'Assign Role To User']);
        Permission::create(['name' => 'View Reports']);
        Permission::create(['name' => 'View Purchases']);
        Permission::create(['name' => 'Create Purchase']);
        Permission::create(['name' => 'Edit Purchase']);
        Permission::create(['name' => 'Delete Purchase']);
        Permission::create(['name' => 'Pay Purchase Payments']);
        Permission::create(['name' => 'Receive Purchase Products']);
        Permission::create(['name' => 'View Sales']);
        Permission::create(['name' => 'Create Sale']);
        Permission::create(['name' => 'Receive Sale Payments']);
        Permission::create(['name' => 'Edit Sale']);
        Permission::create(['name' => 'Delete Sale']);
        Permission::create(['name' => 'View Warehouses']);
        Permission::create(['name' => 'Add Warehouse']);
        Permission::create(['name' => 'Edit Warehouse']);
        Permission::create(['name' => 'Delete Warehouse']);
        Permission::create(['name' => 'View Units']);
        Permission::create(['name' => 'Add Unit']);
        Permission::create(['name' => 'Edit Unit']);
        Permission::create(['name' => 'Delete Unit']);
        Permission::create(['name' => 'View Products']);
        Permission::create(['name' => 'Add Products']);
        Permission::create(['name' => 'Edit Product']);
        Permission::create(['name' => 'Delete Product']);
        Permission::create(['name' => 'View Brands']);
        Permission::create(['name' => 'Edit Brand']);
        Permission::create(['name' => 'Delete Brand']);
        Permission::create(['name' => 'View Categories']);
        Permission::create(['name' => 'Edit Category']);
        Permission::create(['name' => 'Delete Category']);
        Permission::create(['name' => 'View Accounts']);
        Permission::create(['name' => 'Edit Account']);
        Permission::create(['name' => 'Delete Account']);

        $role = Role::findByName('Owner');
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
    }
}
