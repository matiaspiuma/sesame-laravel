<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\DeleteEmployee;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\EmployeeContext\Domain\EmployeeRepository;

final class EmployeeDeletor
{
    public function __construct(
        private EmployeeRepository $employeeRepository
    ) {
    }

    public function __invoke(
        EmployeeId $employeeId,
    ): void {
        $employee = $this->employeeRepository->findById($employeeId);

        $employee->delete();

        $this->employeeRepository->delete($employee);
    }
}
