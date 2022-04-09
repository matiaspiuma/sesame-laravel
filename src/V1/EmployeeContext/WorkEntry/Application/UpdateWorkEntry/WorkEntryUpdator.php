<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;

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
