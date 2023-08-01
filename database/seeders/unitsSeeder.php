<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class unitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'code' => '112233',
                'name' => 'Unit 1',
                'operator' => '*',
                'value' => '10'
            ],
            [
                'code' => '332211',
                'name' => 'Unit 2',
                'operator' => '*',
                'value' => '10'
            ],
            
        ];

        foreach ($units as $key => $unit){
            Unit::create($unit);
        }
    }
}
