<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Owner',
            'email' => 'owner@email.com',
            'password' => Hash::make('owner'),
            'warehouseId' => 1,
        ])->assignRole('Owner');


        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin'),
            'warehouseId' => 1,
        ])->assignRole('Admin');

        User::create([
            'name' => 'Cashier',
            'email' => 'cashier@email.com',
            'password' => Hash::make('cashier'),
            'warehouseId' => 1,
        ])->assignRole('Cashier');
    }
}
