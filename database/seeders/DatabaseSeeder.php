<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for($i = 1; $i < 6; $i++) {
            Department::factory()->create([
                'name' => 'department ' . $i
            ]);
        }

        User::factory()->create([
            'first_name' => 'Ibrahim',
            'last_name' => 'Ali',
            'email' => 'admin@admin.com',
            'phone' => '01096121030',
            'department_id' => Department::pluck('id')->random(),
            'role' => RolesEnum::ADMIN,
        ]);

         User::factory(10)->create([
             'department_id' => Department::pluck('id')->random(),
             'manager_id' => 1,
             'role' => RolesEnum::EMPLOYEE,
         ]);


    }
}
