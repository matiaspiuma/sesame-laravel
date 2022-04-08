<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\CreateWorkEntry;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\WorkEntryContext\Domain\WorkEntry;
use Api\V1\WorkEntryContext\Domain\WorkEntryRepository;

final class WorkEntryCreator
{
    public function __construct(
        private WorkEntryRepository $workEntryRepository
    ) {
    }

    public function __invoke(
        EmployeeId         $employeeId,
        WorkEntryId        $workEntryId,
        WorkEntryStartDate $workEntryStartDate,
        WorkEntryEndDate   $workEntryEndDate,
    ): void {
        $this->workEntryRepository->create(
            workEntry: WorkEntry::create(
                employeeId: $employeeId,
                id: $workEntryId,
                startDate: $workEntryStartDate,
                endDate: $workEntryEndDate
            )
        );
    }
}