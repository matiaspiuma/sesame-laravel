<?php

namespace Database\Seeders;

use Database\Factories\EmployeeFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('employees')->insert([
                'id' => $faker->uuid(),
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
