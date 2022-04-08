<?php

declare(strict_types=1);

namespace Tests\Feature\EmployeeContext\Infrastructure\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class CreateEmployeeControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_should_create_an_employee(): void
    {
        $name = $this->faker->name;
        $email = $this->faker->email;

        $response = $this->post('/api/v1/employees', [
            'name' => $name,
            'email' => $email,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => $name,
                'email' => $email,
            ],
        ]);
    }
}
