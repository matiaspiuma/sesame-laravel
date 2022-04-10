<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PutEmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_update_an_employee(): void
    {
        $employee = $this->makeEmployee(true);

        $newEmployee = $this->makeEmployee();

        $response = $this->put('/api/v1/employees/'.$employee->id()->value(), [
            'name' => $newEmployee->name()->value(),
            'email' => $newEmployee->email()->value(),
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'name' => $newEmployee->name()->value(),
            'email' => $newEmployee->email()->value(),
        ]);
    }

    /** @test */
    public function it_should_not_update_an_employee(): void
    {
        $employee = $this->makeEmployee(true);

        $response = $this->put('/api/v1/employees/'.$employee->id()->value(), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_should_respond_not_found(): void
    {
        $employee = $this->makeEmployee();

        $response = $this->put('/api/v1/employees/'.$employee->id()->value(), [
            'name' => $employee->name()->value(),
            'email' => $employee->email()->value(),
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertNotFound();
    }
}
