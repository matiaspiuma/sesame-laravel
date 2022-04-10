<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Employees;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetEmployeeWorkEntryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_get_an_employees_work_entry(): void
    {
        $workEntry = $this->makeWorkEntry(true);

        $response = $this->get('/api/v1/employees/' . $workEntry->employeeId()->value() . '/workentries/' . $workEntry->id()->value());

        $response->assertStatus(200);
        $response->assertJsonFragment($workEntry->toPrimitives());
    }
}
