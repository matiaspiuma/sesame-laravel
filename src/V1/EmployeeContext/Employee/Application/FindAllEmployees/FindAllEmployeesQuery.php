<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\FindAllEmployees;

use Api\V1\SharedContext\Application\CQRS\Query\QueryInterface;

final class FindAllEmployeesQuery implements QueryInterface
{
    public function __construct()
    {
    }
}
