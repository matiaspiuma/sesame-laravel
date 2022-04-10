<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\FindAllEmployees\FindAllEmployeesQuery;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeCollection;
use Api\V1\EmployeeContext\Employee\Domain\Employees;
use Api\V1\EmployeeContext\Employee\Infrastructure\Responses\EmployeeResponseInterface;
use Api\V1\EmployeeContext\Employee\Infrastructure\Responses\EmployeesResponse;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;

final class SearchEmployeesController
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(): Employees
    {
        return $this->queryBus->execute(
            new FindAllEmployeesQuery()
        );
    }
}
