<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\FindAllWorkEntriesByEmployeeId;

use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntries;
use Api\V1\SharedContext\Application\CQRS\Query\QueryHandlerInterface;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class FindAllWorkEntriesByEmployeeIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WorkEntriesByEmployeeIdFinder $finder
    )
    {
    }

    public function __invoke(FindAllWorkEntriesByEmployeeIdQuery $query): WorkEntries
    {
        return $this->finder->__invoke(
            new EmployeeId($query->employeeId)
        );
    }
}
