<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DeleteEmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_delete_an_employee(): void
    {
        $employee = $this->makeEmployee(true);

        $response = $this->delete('/api/v1/employees/'.$employee->id()->value());

        $response->assertNoContent();
    }

    /** @test */
    public function it_should_response_not_found(): void
    {
        $employee = $this->makeEmployee();

        $response = $this->delete('/api/v1/employees/'.$employee->id()->value());

        $response->assertNotFound();
    }
}
