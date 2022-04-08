<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\UpdateEmployee;

use Api\V1\EmployeeContext\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeName;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;

final class EmployeeUpdator
{
    public function __construct(
        private EmployeeRepository $employeeRepository
    ) {
    }

    public function __invoke(
        EmployeeId $employeeId,
        EmployeeName $employeeName,
        EmployeeEmail $employeeEmail
    ): void {
        $employee = $this->employeeRepository->findById($employeeId);

        $employee->update(
            name: $employeeName,
            email: $employeeEmail,
        );

        $this->employeeRepository->update($employee);
    }
}
