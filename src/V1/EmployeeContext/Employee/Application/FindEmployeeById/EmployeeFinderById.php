<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\FindEmployeeById;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

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
