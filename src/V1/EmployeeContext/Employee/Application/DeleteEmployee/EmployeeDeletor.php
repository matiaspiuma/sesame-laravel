<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\DeleteEmployee;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;

final class EmployeeDeletor
{
    public function __construct(
        private EmployeeRepository $repository
    ) {
    }

    public function __invoke(
        EmployeeId $employeeId,
    ): void {
        $employee = $this->repository->findById($employeeId);

        $employee->delete();

        $this->repository->delete($employee);
    }
}
