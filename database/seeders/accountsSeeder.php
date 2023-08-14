<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class accountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'name' => 'Cash',
                'type' => 'business',
                'category' => 'cash',
                'accountNumber' => '01',
            ],
            [
                'name' => 'ABC Bank',
                'type' => 'business',
                'category' => 'bank',
                'accountNumber' => '02',
            ],
            [
                'name' => 'ABC Customer',
                'type' => 'customer',
                'accountNumber' => '04',
            ],
            [
                'name' => 'ABC Supplier',
                'type' => 'supplier',
                'accountNumber' => '03',
            ],
            
        ];

        foreach ($accounts as $key => $account){
            Account::create($account);
        }
    }
}
