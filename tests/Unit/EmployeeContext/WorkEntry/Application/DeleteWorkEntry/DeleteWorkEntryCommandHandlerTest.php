<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\WorkEntry\Application\DeleteWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Application\DeleteWorkEntry\DeleteWorkEntryCommand;
use Api\V1\EmployeeContext\WorkEntry\Application\DeleteWorkEntry\DeleteWorkEntryCommandHandler;
use Api\V1\EmployeeContext\WorkEntry\Application\DeleteWorkEntry\WorkEntryDeletor;
use Tests\TestCase;

final class DeleteWorkEntryCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_delete_a_work_entry(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry();

        $this->workEntryRepository()
            ->shouldReceive('findByIdAndEmployeeId')
            ->once()
            ->andReturn($workEntry);

        $this->workEntryRepository()
            ->shouldReceive('delete')
            ->once()
            ->andReturnNull();

        // When
        $command = new DeleteWorkEntryCommandHandler(
            new WorkEntryDeletor($this->workEntryRepository())
        );

        $command(
            new DeleteWorkEntryCommand(
                $workEntry->id()->value(),
                $workEntry->employeeId()->value()
            )
        );
    }
}
