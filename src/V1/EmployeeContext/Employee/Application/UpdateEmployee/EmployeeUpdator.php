<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\UpdateEmployee;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeName;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class EmployeeUpdator
{
    public function __construct(
        private EmployeeRepository $repository
    ) {
    }

    public function __invoke(
        EmployeeId $employeeId,
        EmployeeName $employeeName,
        EmployeeEmail $employeeEmail
    ): void {
        $employee = $this->repository->findById($employeeId);

        $employee->update(
            name: $employeeName,
            email: $employeeEmail,
        );

        $this->repository->update($employee);
    }
}
