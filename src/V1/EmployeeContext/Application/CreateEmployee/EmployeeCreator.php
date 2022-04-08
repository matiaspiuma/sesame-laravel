<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\CreateEmployee;

use Api\V1\EmployeeContext\Domain\Employee;
use Api\V1\EmployeeContext\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeName;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;

final class EmployeeCreator
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
        $employee = Employee::create(
            $employeeId,
            $employeeName,
            $employeeEmail
        );

        $this->repository->create($employee);
    }
}
