<?php

declare(strict_types=1);

namespace Tests\Unit\WorkEntryContext\Application\FindAddWorkEntriesByEmployeeId;

use Api\V1\WorkEntryContext\Application\FindAllWorkEntriesByEmployeeId\FindAllWorkEntriesByEmployeeIdQuery;
use Api\V1\WorkEntryContext\Application\FindAllWorkEntriesByEmployeeId\FindAllWorkEntriesByEmployeeIdQueryHandler;
use Api\V1\WorkEntryContext\Application\FindAllWorkEntriesByEmployeeId\WorkEntriesByEmployeeIdFinder;
use Tests\TestCase;

final class FindAllWorkEntriesByEmployeeIdQueryHandlerTest extends TestCase
{
    /** @test */
    public function it_should_find_all_work_entries_by_employee_id(): void
    {
        // Given
        $workEntry = $this->makeAnWorkEntry();

        $this->workEntryRepository()
            ->shouldReceive('findAllByEmployeeId')
            ->once();

        // When
        $query = new FindAllWorkEntriesByEmployeeIdQueryHandler(
            finder: new WorkEntriesByEmployeeIdFinder(
                repository: $this->workEntryRepository()
            )
        );

        $query(new FindAllWorkEntriesByEmployeeIdQuery(
            employeeId: $workEntry['employee_id']
        ));
    }
}
