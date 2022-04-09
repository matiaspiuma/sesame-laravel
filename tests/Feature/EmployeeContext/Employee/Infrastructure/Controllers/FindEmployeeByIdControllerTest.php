<?php

declare(strict_types=1);

namespace Tests\Feature\EmployeeContext\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class FindEmployeeByIdControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_should_find_an_employee(): void
    {
        $employee = $this->makeAnEmployeeAsObject(
            employee: $this->createAnEmployee()
        );

        $response = $this->get('/api/v1/employees/'.$employee->id);

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

        $response = $this->get('/api/v1/employees/'.$employeeId->id);

        $response->assertNotFound();
    }
}
