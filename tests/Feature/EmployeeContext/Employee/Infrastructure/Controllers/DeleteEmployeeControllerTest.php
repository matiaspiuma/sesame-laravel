<?php

declare(strict_types=1);

namespace Tests\Feature\EmployeeContext\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class DeleteEmployeeControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_should_delete_an_employee(): void
    {
        $employee = $this->makeAnEmployeeAsObject(
            employee: $this->createAnEmployee()
        );

        $response = $this->delete('/api/v1/employees/'.$employee->id);

        $response->assertNoContent();
    }

    /** @test */
    public function it_should_response_not_found(): void
    {
        $employeeId = EmployeeId::make();

        $response = $this->delete('/api/v1/employees/'.$employeeId->id);

        $response->assertNotFound();
    }
}
