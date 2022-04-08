<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\FindAllWorkEntriesByEmployeeId;

use Api\V1\SharedContext\Application\CQRS\Query\QueryHandlerInterface;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;

final class FindAllWorkEntriesByEmployeeIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WorkEntriesByEmployeeIdFinder $workEntriesByEmployeeIdFinder
    ) {
    }

    public function __invoke(FindAllWorkEntriesByEmployeeIdQuery $findAllWorkEntriesByEmployeeIdQuery): array
    {
        return $this->workEntriesByEmployeeIdFinder->__invoke(
            employeeId: new EmployeeId($findAllWorkEntriesByEmployeeIdQuery->employeeId())
        );
    }
}