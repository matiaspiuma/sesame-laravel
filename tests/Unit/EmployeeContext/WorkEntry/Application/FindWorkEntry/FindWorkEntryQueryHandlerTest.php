<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\WorkEntry\Application\FindWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntryById\FindWorkEntryByIdAndEmployeeIdQuery;
use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntryById\FindWorkEntryByIdAndEmployeeIdQueryHandler;
use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntryById\WorkEntryByIdFinder;
use Tests\TestCase;

final class FindWorkEntryQueryHandlerTest extends TestCase
{
    /** @test */
    public function it_should_find_an_work_entry(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry();

        $this->workEntryRepository()
            ->shouldReceive('findByIdAndEmployeeId')
            ->once()
            ->andReturn($workEntry);

        // When
        $query = new FindWorkEntryByIdAndEmployeeIdQueryHandler(
            new WorkEntryByIdFinder($this->workEntryRepository())
        );

        $query(new FindWorkEntryByIdAndEmployeeIdQuery(
            $workEntry->id()->value(),
            $workEntry->employeeId()->value()
        ));
    }
}
