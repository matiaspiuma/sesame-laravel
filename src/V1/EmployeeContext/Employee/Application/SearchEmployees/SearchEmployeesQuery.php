<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\SearchEmployees;

use Api\V1\SharedContext\Application\CQRS\Query\QueryInterface;

final class SearchEmployeesQuery implements QueryInterface
{
    public function __construct()
    {
    }
}
