<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PostEmployeeWorkEntryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_create_an_employee_work_entry(): void
    {
        $employee = $this->makeEmployee(true);
        $workEntry = $this->makeWorkEntry();

        $response = $this->post('/api/v1/employees/'.$employee->id()->value().'/workentries', [
            'startDate' => (string) $workEntry->startDate(),
            'endDate' => (string) $workEntry->endDate(),
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'employeeId' => $employee->id()->value(),
            'startDate' => (string) $workEntry->startDate(),
            'endDate' => (string) $workEntry->endDate(),
        ]);
    }

    /** @test */
    public function it_should_create_an_work_entry_with_nullable_end_date(): void
    {
        $employee = $this->makeEmployee(true);
        $workEntry = $this->makeWorkEntry();

        $response = $this->post('/api/v1/employees/'.$employee->id()->value().'/workentries', [
            'startDate' => (string) $workEntry->startDate()
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'employeeId' => $employee->id()->value(),
            'startDate' => (string) $workEntry->startDate(),
            'endDate' => '',
        ]);
    }

    /** @test */
    public function it_should_not_create_an_work_entry(): void
    {
        $employee = $this->makeEmployee(true);

        $response = $this->post('/api/v1/employees/'.$employee->id().'/workentries', [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }
}
