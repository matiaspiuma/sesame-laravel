<?php

declare(strict_types=1);

namespace Tests\Unit\WorkEntryContext\Application\UpdateWorkEntry;

use Api\V1\WorkEntryContext\Application\UpdateWorkEntry\UpdateWorkEntryCommand;
use Api\V1\WorkEntryContext\Application\UpdateWorkEntry\UpdateWorkEntryCommandHandler;
use Api\V1\WorkEntryContext\Application\UpdateWorkEntry\WorkEntryUpdator;
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
                $this->workEntryRepository()
            )
        );

        $commad(new UpdateWorkEntryCommand(
            $workEntry->id()->value(),
            (string) $workEntry->startDate(),
            (string) $workEntry->endDate(),
        ));
    }
}
