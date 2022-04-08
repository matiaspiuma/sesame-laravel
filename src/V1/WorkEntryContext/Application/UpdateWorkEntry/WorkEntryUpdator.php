<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\UpdateWorkEntry;

use Api\V1\WorkEntryContext\Domain\WorkEntryRepository;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryStartDate;

final class WorkEntryUpdator
{
    public function __construct(
        private WorkEntryRepository $repository
    ) {
    }

    public function __invoke(
        WorkEntryId $workDateId,
        WorkEntryStartDate $workEntryStartDate,
        WorkEntryEndDate $workDateEndDate
    ): void {
        $workDate = $this->repository->findById($workDateId);

        $workDate->update(
            startDate: $workEntryStartDate,
            endDate: $workDateEndDate,
        );

        $this->repository->update($workDate);
    }
}
