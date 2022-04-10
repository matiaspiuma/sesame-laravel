<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\FindAllEmployees;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Employee\Domain\Employees;

final class EmployeesFinder
{
    public function __construct(
        private EmployeeRepository $repository
    ) {
    }

    public function __invoke(): Employees
    {
        return $this->repository->findAll();
    }
}
