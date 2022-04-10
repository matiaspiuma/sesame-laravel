<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\DeleteEmployee;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeNotExistsException;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class EmployeeDeletor
{
    public function __construct(
        private EmployeeRepository $repository
    )
    {
    }

    public function __invoke(
        EmployeeId $employeeId,
    ): void
    {
        $employee = $this->repository->findById($employeeId);

        if (null === $employee) {
            throw new EmployeeNotExistsException();
        }

        $employee->delete();

        $this->repository->delete($employee);
    }
}
