<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\FindEmployeeById;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\SharedContext\Application\CQRS\Query\QueryHandlerInterface;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class FindEmployeeByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeeFinderById $employeeFinder
    ) {
    }

    public function __invoke(FindEmployeeByIdQuery $query): ?Employee
    {
        return $this->employeeFinder->__invoke(
            new EmployeeId($query->id),
        );
    }
}
