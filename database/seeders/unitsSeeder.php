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
                'name' => '1 in box',
                'operator' => '*',
                'value' => '1'
            ],
            [
                'code' => '332211',
                'name' => '2 in box',
                'operator' => '*',
                'value' => '2'
            ],
            [
                'code' => '332211',
                'name' => '10 in box',
                'operator' => '*',
                'value' => '10'
            ]

        ];

        foreach ($units as $key => $unit){
            Unit::create($unit);
        }
    }
}
