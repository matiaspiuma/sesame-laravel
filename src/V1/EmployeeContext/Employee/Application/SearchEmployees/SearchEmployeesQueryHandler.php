<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\SearchEmployees;

use Api\V1\SharedContext\Application\CQRS\Query\QueryHandlerInterface;

final class SearchEmployeesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeesFinder $employeesFinder
    ) {
    }

    public function __invoke(SearchEmployeesQuery $query): mixed
    {
        return $this->employeesFinder->__invoke();
    }
}