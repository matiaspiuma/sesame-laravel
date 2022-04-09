<?php

declare(strict_types=1);

namespace Tests\Unit\WorkEntry\Application\FindWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntry\FindWorkEntryQuery;
use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntry\FindWorkEntryQueryHandler;
use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntry\WorkEntryFinder;
use Tests\TestCase;

final class FindWorkEntryQueryHandlerTest extends TestCase
{
    /** @test */
    public function it_should_find_an_work_entry(): void
    {
        // Given
        $workEntry = $this->makeAnWorkEntry(asObject: true);

        $this->workEntryRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn($workEntry);

        // When
        $query = new FindWorkEntryQueryHandler(
            finder: new WorkEntryFinder(
                repository: $this->workEntryRepository()
            )
        );

        $query(new FindWorkEntryQuery(
            id: (string) $workEntry->id
        ));
    }
}
