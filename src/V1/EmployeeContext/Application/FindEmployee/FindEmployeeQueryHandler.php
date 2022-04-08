<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\FindEmployee;

use Api\V1\SharedContext\Application\CQRS\Query\QueryHandlerInterface;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;

final class FindEmployeeQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeeFinder $employeeFinder
    ) {
    }

    public function __invoke(FindEmployeeQuery $query): mixed
    {
        return $this->employeeFinder->__invoke(
            employeeId: new EmployeeId($query->id()),
        );
    }
}
