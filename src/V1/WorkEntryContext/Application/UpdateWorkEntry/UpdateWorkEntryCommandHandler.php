<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\UpdateWorkEntry;

use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;
use Api\V1\WorkEntryContext\Application\UpdateWorkEntry\WorkEntryUpdator;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryStartDate;

final class UpdateWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkEntryUpdator $workEntryUpdator
    ) {
    }

    public function __invoke(UpdateWorkEntryCommand $command): void
    {
        $this->workEntryUpdator->__invoke(
            new WorkEntryId($command->id()),
            new WorkEntryStartDate(
                value: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $command->startDate())
            ),
            new WorkEntryEndDate(
                value: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $command->endDate())
            ),
        );
    }
}
