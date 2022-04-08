<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
