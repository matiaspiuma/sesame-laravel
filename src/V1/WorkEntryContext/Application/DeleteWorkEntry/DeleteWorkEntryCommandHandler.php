<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\DeleteWorkEntry;

use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;

final class DeleteWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkEntryDeletor $workEntryDelector
    ) {
    }

    public function __invoke(DeleteWorkEntryCommand $command): void
    {
        $this->workEntryDelector->__invoke(
            workEntryId: new WorkEntryId($command->id()),
        );
    }
}
