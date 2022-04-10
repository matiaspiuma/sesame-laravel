<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\WorkEntry\Application\FindAllWorkEntriesByEmployeeId\FindAllWorkEntriesByEmployeeIdQuery;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntries;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;

final class FindWorkEntriesByEmployeeIdController
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(
        Request $request,
        string  $employeeId,
    ): WorkEntries
    {
        return $this->queryBus->execute(
            new FindAllWorkEntriesByEmployeeIdQuery($employeeId)
        );
    }
}
