<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntryById\FindWorkEntryByIdAndEmployeeIdQuery;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;

final class FindWorkEntryByIdController
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(
        Request $request,
        string  $employeeId,
        string  $workEntryId
    ): WorkEntry
    {
        return $this->queryBus->execute(
            new FindWorkEntryByIdAndEmployeeIdQuery($workEntryId, $employeeId)
        );
    }
}
