<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetEmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_find_an_employee(): void
    {
        $employee = $this->makeEmployee(true);

        $response = $this->get('/api/v1/employees/'.$employee->id()->value());

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $employee->name()->value(),
            'email' => $employee->email()->value(),
        ]);
    }

    /** @test */
    public function it_should_response_not_found(): void
    {
        $employeeId = EmployeeId::make();

        $response = $this->get('/api/v1/employees/'.$employeeId->value());

        $response->assertNotFound();
    }
}
