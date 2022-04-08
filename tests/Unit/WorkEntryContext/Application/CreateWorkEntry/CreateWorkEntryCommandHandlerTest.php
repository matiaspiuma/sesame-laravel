<?php

declare(strict_types=1);

namespace Tests\Unit\WorkEntryContext\Application\CreateWorkEntry;

use Api\V1\WorkEntryContext\Application\CreateWorkEntry\CreateWorkEntryCommand;
use Api\V1\WorkEntryContext\Application\CreateWorkEntry\CreateWorkEntryCommandHandler;
use Api\V1\WorkEntryContext\Application\CreateWorkEntry\WorkEntryCreator;
use Tests\TestCase;

final class CreateWorkEntryCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_create_a_work_entry(): void
    {
        // Given
        $workEntry = $this->makeAnWorkEntry();

        $this->workEntryRepository()
            ->shouldReceive('create')
            ->once()
            ->andReturnNull();

        // When
        $commad = new CreateWorkEntryCommandHandler(
            creator: new WorkEntryCreator(
                $this->workEntryRepository()
            )
        );

        $commad(new CreateWorkEntryCommand(
            employeeId: $workEntry['employee_id'],
            id: $workEntry['id'],
            startDate: $workEntry['start_date'],
            endDate: $workEntry['end_date']
        ));
    }
}