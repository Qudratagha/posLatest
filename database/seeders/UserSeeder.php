<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Owner',
                'email' => 'owner@email.com',
                'role' => '1',
                'password' => Hash::make('owner'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'role' => '1',
                'password' => Hash::make('admin'),
            ],
            
        ];

        foreach ($users as $key => $user){
            User::create($user);
        }
    }
}
