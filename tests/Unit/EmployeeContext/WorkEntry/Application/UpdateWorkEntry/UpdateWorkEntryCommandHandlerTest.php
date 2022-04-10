<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\WorkEntry\Application\UpdateWorkEntry;

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
        $workEntry = $this->makeWorkEntry();

        $this->workEntryRepository()
            ->shouldReceive('findByIdAndEmployeeId')
            ->once()
            ->andReturn($workEntry);

        $this->workEntryRepository()
            ->shouldReceive('update')
            ->once()
            ->andReturnNull();

        // When
        $command = new UpdateWorkEntryCommandHandler(
            new WorkEntryUpdator($this->workEntryRepository())
        );

        $command(new UpdateWorkEntryCommand(
            $workEntry->id()->value(),
            (string)$workEntry->employeeId(),
            (string)$workEntry->startDate(),
            (string)$workEntry->endDate(),
        ));
    }
}
