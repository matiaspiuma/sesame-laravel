<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetEmployeeWorkEntriesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_get_all_employees_work_entries(): void
    {
        $workEntry = $this->makeWorkEntry(true);

        $response = $this->get('/api/v1/employees/'.$workEntry->employeeId()->value().'/workentries');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'startDate' => (string) $workEntry->startDate(),
            'endDate' => (string) $workEntry->endDate(),
        ]);
    }
}
