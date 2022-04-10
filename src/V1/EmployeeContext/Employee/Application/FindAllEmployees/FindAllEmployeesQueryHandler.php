<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\FindAllEmployees;

use Api\V1\EmployeeContext\Employee\Domain\Employees;
use Api\V1\SharedContext\Application\CQRS\Query\QueryHandlerInterface;

final class FindAllEmployeesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeesFinder $employeesFinder
    ) {
    }

    public function __invoke(FindAllEmployeesQuery $query): Employees
    {
        return $this->employeesFinder->__invoke();
    }
}
