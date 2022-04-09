<?php

declare(strict_types=1);

namespace Tests\Unit\WorkEntry\Application\UpdateWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry\UpdateWorkEntryCommand;
use Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry\UpdateWorkEntryCommandHandler;
use Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry\WorkEntryUpdator;
use Tests\TestCase;

final class UpdateWorkEntryCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_update_an_work_entry(): void
    {
        // Given
        $workEntry = $this->makeAnWorkEntry(asObject: true);

        $this->workEntryRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn($workEntry);

        $this->workEntryRepository()
            ->shouldReceive('update')
            ->once()
            ->andReturnNull();

        // When
        $commad = new UpdateWorkEntryCommandHandler(
            updator: new WorkEntryUpdator(
                repository: $this->workEntryRepository()
            )
        );

        $commad(new UpdateWorkEntryCommand(
            (string) $workEntry->id,
            (string) $workEntry->startDate(),
            (string) $workEntry->endDate(),
        ));
    }
}
