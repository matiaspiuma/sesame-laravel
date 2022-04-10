<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DeleteEmployeeWorkEntryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_delete_an_work_entry(): void
    {
        $workEntry = $this->makeWorkEntry(true);

        $response = $this->delete('/api/v1/employees/'.$workEntry->employeeId().'/workentries/'.$workEntry->id()->value());

        $response->assertNoContent();
    }

    /** @test */
    public function it_should_response_not_found(): void
    {
        $workEntry = $this->makeWorkEntry();

        $response = $this->delete('/api/v1/employees/'.$workEntry->employeeId().'/workentries/'.$workEntry->id()->value());

        $response->assertNotFound();
    }
}
