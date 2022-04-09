<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;

final class UpdateWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkEntryUpdator $updator
    ) {
    }

    public function __invoke(UpdateWorkEntryCommand $command): void
    {
        $this->updator->__invoke(
            new WorkEntryId($command->id),
            new WorkEntryStartDate(
                value: \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i:s', 
                    $command->startDate
                )
            ),
            new WorkEntryEndDate(
                value: \DateTimeImmutable::createFromFormat(
                    'Y-m-d H:i:s', 
                    $command->endDate
                )
            ),
        );
    }
}
