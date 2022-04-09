<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\FindAllWorkEntriesByEmployeeId;

use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

class WorkEntriesByEmployeeIdFinder
{
    public function __construct(
        private WorkEntryRepository $repository
    )
    {
    }

    public function __invoke(EmployeeId $employeeId): array
    {
        return $this->repository->findAllByEmployeeId(
            employeeId: $employeeId
        );
    }
}
