<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\UpdateEmployee;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeNotExistsException;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeName;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class EmployeeUpdator
{
    public function __construct(
        private EmployeeRepository $repository
    )
    {
    }

    public function __invoke(
        EmployeeId    $employeeId,
        EmployeeName  $employeeName,
        EmployeeEmail $employeeEmail
    ): Employee
    {
        $employee = $this->repository->findById($employeeId);

        if (null === $employee) {
            throw new EmployeeNotExistsException();
        }

        $employee->update($employeeName, $employeeEmail);

        $this->repository->update($employee);

        return $employee;
    }
}
