<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PostEmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_create_an_employee(): void
    {
        $employee = $this->makeEmployee();

        $response = $this->post('/api/v1/employees', [
            'name' => $employee->name()->value(),
            'email' => $employee->email()->value(),
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => $employee->name()->value(),
            'email' => $employee->email()->value(),
        ]);
    }

    /** @test */
    public function it_should_not_create_an_employee(): void
    {
        $employee = $this->makeEmployee(true);

        $response = $this->post('/api/v1/employees', [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }
}
