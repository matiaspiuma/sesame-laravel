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
        private WorkEntryRepository $workDateRepository
    ) {
    }

    public function __invoke(
        WorkEntryId $workDateId,
        WorkEntryStartDate $workDateStartDate,
        WorkEntryEndDate $workDateEndDate
    ): void {
        $workDate = $this->workDateRepository->findById($workDateId);

        $workDate->update(
            startDate: $workDateStartDate,
            endDate: $workDateEndDate,
        );

        $this->workDateRepository->update($workDate);
    }
}
