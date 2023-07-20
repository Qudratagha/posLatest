<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'QudratUllah',
            'email' => 'qudrat@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('qudrat123'),
        ]);
    }
}
