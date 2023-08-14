<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(roleSeeder::class);
        $this->call(permissionSeeder::class);
        $this->call([
            UserSeeder::class,
            PurchaseStatusSeeder::class,
            warehousesSeeder::class,
            brandsSeeder::class,
            unitsSeeder::class,
            categorySeeder::class,
            accountsSeeder::class,
        ]);
    }
}
