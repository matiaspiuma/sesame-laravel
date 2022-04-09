<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\SearchEmployees;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeCollection;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;

final class EmployeesFinder
{
    public function __construct(
        private EmployeeRepository $repository
    ) {
    }

    public function __invoke(): EmployeeCollection
    {
        return $this->repository->findAll();
    }
}
