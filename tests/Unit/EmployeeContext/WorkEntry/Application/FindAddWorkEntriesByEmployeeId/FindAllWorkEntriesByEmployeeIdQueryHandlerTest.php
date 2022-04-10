<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\WorkEntry\Application\FindAddWorkEntriesByEmployeeId;

use Api\V1\EmployeeContext\WorkEntry\Application\FindAllWorkEntriesByEmployeeId\FindAllWorkEntriesByEmployeeIdQuery;
use Api\V1\EmployeeContext\WorkEntry\Application\FindAllWorkEntriesByEmployeeId\FindAllWorkEntriesByEmployeeIdQueryHandler;
use Api\V1\EmployeeContext\WorkEntry\Application\FindAllWorkEntriesByEmployeeId\WorkEntriesByEmployeeIdFinder;
use Tests\TestCase;

final class FindAllWorkEntriesByEmployeeIdQueryHandlerTest extends TestCase
{
    /** @test */
    public function it_should_find_all_work_entries_by_employeeId(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry();

        $this->workEntryRepository()
            ->shouldReceive('findAllByEmployeeId')
            ->once();

        // When
        $query = new FindAllWorkEntriesByEmployeeIdQueryHandler(
            new WorkEntriesByEmployeeIdFinder($this->workEntryRepository())
        );

        $query(
            new FindAllWorkEntriesByEmployeeIdQuery(
                $workEntry->employeeId()->value()
            )
        );
    }
}
