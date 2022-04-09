<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class WorkEntryCreator
{
    public function __construct(
        private WorkEntryRepository $repository
    ) {
    }

    public function __invoke(
        EmployeeId         $employeeId,
        WorkEntryId        $workEntryId,
        WorkEntryStartDate $workEntryStartDate,
        WorkEntryEndDate   $workEntryEndDate,
    ): void {
        $this->repository->create(
            workEntry: WorkEntry::create(
                employeeId: $employeeId,
                id: $workEntryId,
                startDate: $workEntryStartDate,
                endDate: $workEntryEndDate
            )
        );
    }
}
