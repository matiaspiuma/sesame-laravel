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
    )
    {
    }

    public function __invoke(
        WorkEntryId        $workEntryId,
        WorkEntryStartDate $workEntryStartDate,
        WorkEntryEndDate   $workEntryEndDate,
        EmployeeId         $employeeId,
    ): WorkEntry
    {
        $workEntry = WorkEntry::create(
            id: $workEntryId,
            startDate: $workEntryStartDate,
            endDate: $workEntryEndDate,
            employeeId: $employeeId,
        );

        $this->repository->create(
            workEntry: $workEntry
        );

        return $workEntry;
    }
}
