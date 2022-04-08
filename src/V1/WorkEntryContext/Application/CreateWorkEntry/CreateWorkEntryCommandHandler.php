<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\CreateWorkEntry;

use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryStartDate;

final class CreateWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkEntryCreator $employeeCreator
    ) {
    }

    public function __invoke(CreateWorkEntryCommand $command): void
    {
        $this->employeeCreator->__invoke(
            employeeId: new EmployeeId(id: $command->employeeId()),
            workEntryId: new WorkEntryId(id: $command->id()),
            workEntryStartDate: new WorkEntryStartDate(
                value: new \DateTimeImmutable(
                    datetime: $command->startDate()
                )
            ),
            workEntryEndDate: new WorkEntryEndDate(
                value: new \DateTimeImmutable(
                    datetime: $command->endDate()
                )
            ),
        );
    }
}
