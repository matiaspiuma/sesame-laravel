<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\SearchEmployees;

use Api\V1\EmployeeContext\Domain\EmployeeRepository;

final class EmployeesFinder
{
    public function __construct(
        private EmployeeRepository $repository
    ) {
    }

    public function __invoke(): array
    {
        return $this->repository->findAll();
    }
}
