<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\CreateEmployee;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeName;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

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
