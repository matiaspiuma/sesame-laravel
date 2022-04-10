<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class CreateWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkEntryCreator $creator
    )
    {
    }

    public function __invoke(CreateWorkEntryCommand $command): WorkEntry
    {
        return $this->creator->__invoke(
            new WorkEntryId($command->id),
            new EmployeeId($command->employeeId),
            new WorkEntryStartDate(
                new \DateTimeImmutable($command->startDate)
            ),
            $command->endDate ? new WorkEntryEndDate(
                new \DateTimeImmutable($command->endDate)
            ) : null,
        );
    }
}
