<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PutEmployeeWorkEntryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_update_an_work_entry(): void
    {
        $workEntry = $this->makeWorkEntry(true);

        $newWorkEntry = $this->makeWorkEntry();

        $response = $this->put('/api/v1/employees/' . $workEntry->employeeId() . '/workentries/' . $workEntry->id(), [
            'startDate' => (string)$newWorkEntry->startDate(),
            'endDate' => (string)$newWorkEntry->endDate(),
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'startDate' => (string)$newWorkEntry->startDate(),
            'endDate' => (string)$newWorkEntry->endDate(),
        ]);
    }

    /** @test */
    public function it_should_not_update_an_work_entry(): void
    {
        $workEntry = $this->makeEmployee(true);

        $response = $this->put('/api/v1/employees/' . $workEntry->id()->value(), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_should_respond_not_found(): void
    {
        $workEntry = $this->makeWorkEntry();

        $response = $this->put('/api/v1/employees/' . $workEntry->employeeId() . '/workentries/' . $workEntry->id(), [
            'startDate' => (string)$workEntry->startDate(),
            'endDate' => (string)$workEntry->endDate(),
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertNotFound();
    }
}
