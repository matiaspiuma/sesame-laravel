<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\FindEmployeeById\FindEmployeeByIdQuery;
use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Infrastructure\Responses\EmployeeResponseInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;

final class FindEmployeeByIdController
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(
        Request $request,
        string  $employeeId
    ): Employee
    {
        return $this->queryBus->execute(
            new FindEmployeeByIdQuery($employeeId)
        );
    }
}
