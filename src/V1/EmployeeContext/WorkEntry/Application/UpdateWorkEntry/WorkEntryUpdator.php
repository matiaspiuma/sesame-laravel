<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry;

use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;

final class WorkEntryUpdator
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
        EmployeeId         $employeeId
    ): WorkEntry
    {
        $workEntry = $this->repository->findByIdAndEmployeeId(
            workEntryId: $workEntryId,
            employeeId: $employeeId
        );

        $workEntry->update(
            startDate: $workEntryStartDate,
            endDate: $workEntryEndDate,
        );

        $this->repository->update($workEntry);

        return $workEntry;
    }
}
