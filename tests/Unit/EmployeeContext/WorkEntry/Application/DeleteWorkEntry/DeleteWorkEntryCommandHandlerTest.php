<?php

declare(strict_types=1);

namespace Tests\Unit\WorkEntry\Application\DeleteWorkEntry;

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
        $workEntry = $this->makeAnWorkEntry(asObject: true);

        $this->workEntryRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn($workEntry);

        $this->workEntryRepository()
            ->shouldReceive('delete')
            ->once()
            ->andReturnNull();

        // When
        $commad = new DeleteWorkEntryCommandHandler(
            workEntryDelector: new WorkEntryDeletor(
                repository: $this->workEntryRepository()
            )
        );

        $commad(new DeleteWorkEntryCommand(
            id: (string) $workEntry->id
        ));
    }
}
