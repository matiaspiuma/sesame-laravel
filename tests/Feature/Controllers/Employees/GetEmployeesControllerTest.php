<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class GetEmployeesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_get_all_employees(): void
    {
        $employee = $this->makeEmployee(true);

        $response = $this->get('/api/v1/employees');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $employee->name()->value(),
            'email' => $employee->email()->value(),
        ]);
    }
}
