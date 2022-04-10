<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\DeleteWorkEntry;

use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;

final class DeleteWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkEntryDeletor $delector
    )
    {
    }

    public function __invoke(DeleteWorkEntryCommand $command): void
    {
        $this->delector->__invoke(
            new WorkEntryId($command->id),
            new EmployeeId($command->employeeId),
        );
    }
}
