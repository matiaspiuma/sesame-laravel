<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\SearchEmployees;

use Api\V1\SharedContext\Application\CQRS\Query\QueryHandlerInterface;

final class SearchEmployeesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeesFinder $employeeFinder
    ) {
    }

    public function __invoke(SearchEmployeesQuery $query): mixed
    {
        return $this->employeeFinder->__invoke();
    }
}
