<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\FindEmployeeById;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\EmployeeContext\Domain\Employee;
use Api\V1\EmployeeContext\Domain\EmployeeRepository;

final class EmployeeFinderById
{
    public function __construct(
        private EmployeeRepository $repository
    ) {
    }

    public function __invoke(EmployeeId $employeeId): Employee
    {
        return $this->repository->findById($employeeId);
    }
}
