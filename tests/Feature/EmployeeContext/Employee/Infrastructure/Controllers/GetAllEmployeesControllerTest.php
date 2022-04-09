<?php

declare(strict_types=1);

namespace Tests\Feature\EmployeeContext\Infrastructure\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class GetAllEmployeeControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_should_get_all_employees(): void
    {
        $employee = $this->makeAnEmployeeAsObject(
            employee: $this->createAnEmployee()
        );

        $response = $this->get('/api/v1/employees');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $employee->name()->value(),
            'email' => $employee->email()->value(),
        ]);
    }
}
