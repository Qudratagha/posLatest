<?php

namespace Database\Seeders;

use App\Models\permissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class permissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'roleId' => 1,
                'permission' => "viewUsers",
            ],
            [
                'roleId' => 1,
                'permission' => "registerUser",
            ],
            [
                'roleId' => 1,
                'permission' => "createAdmin",
            ],
            [
                'roleId' => 1,
                'permission' => "createCashier",
            ]
        ];

        foreach ($permissions as $key => $permission){
            permissions::create($permission);
        }
    }
}
