<?php

namespace Database\Seeders;

use Database\Factories\EmployeeFactory;
use DateInterval;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $employeeId = $faker->uuid();

            DB::table('employees')->insert([
                'id' => $employeeId,
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'createdAt' => now(),
                'updatedAt' => now(),
            ]);

            for ($j = 0; $j < 10; $j++) {
                $entry = $faker->dateTimeBetween('-1 years', 'now');
                DB::table('work_entries')->insert([
                    'id' => $faker->uuid(),
                    'employeeId' => $employeeId,
                    'startDate' => $entry,
                    'endDate' => $entry->add(
                        DateInterval::createFromDateString(
                            $faker->numberBetween(60, 480) . ' minutes'
                        )
                    ),
                    'createdAt' => now(),
                    'updatedAt' => now(),
                ]);
            }
        }
    }
}
