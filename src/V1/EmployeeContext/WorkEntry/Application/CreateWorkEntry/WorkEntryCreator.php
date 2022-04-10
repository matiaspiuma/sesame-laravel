<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeNotExistsException;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class WorkEntryCreator
{
    public function __construct(
        private WorkEntryRepository $repository,
        private EmployeeRepository  $employeeRepository
    )
    {
    }

    public function __invoke(
        WorkEntryId        $workEntryId,
        EmployeeId         $employeeId,
        WorkEntryStartDate $workEntryStartDate,
        ?WorkEntryEndDate  $workEntryEndDate = null,
    ): WorkEntry
    {
        $employee = $this->employeeRepository->findById($employeeId);

        if (null === $employee) {
            throw new EmployeeNotExistsException();
        }

        $workEntry = WorkEntry::create(
            $workEntryId,
            $workEntryStartDate,
            $employeeId,
            $workEntryEndDate,
        );

        $this->repository->create($workEntry);

        return $workEntry;
    }
}
