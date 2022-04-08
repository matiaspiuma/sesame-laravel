<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\FindAllWorkEntriesByEmployeeId;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\WorkEntryContext\Domain\WorkEntryRepository;

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