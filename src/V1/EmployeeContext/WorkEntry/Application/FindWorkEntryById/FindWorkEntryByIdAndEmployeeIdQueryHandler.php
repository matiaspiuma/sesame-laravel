<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntryById;

use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\SharedContext\Application\CQRS\Query\QueryHandlerInterface;

final class FindWorkEntryByIdAndEmployeeIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WorkEntryByIdFinder $finder
    )
    {
    }

    public function __invoke(FindWorkEntryByIdAndEmployeeIdQuery $query): WorkEntry
    {
        return $this->finder->__invoke(
            new WorkEntryId($query->id),
            new EmployeeId($query->employeeId)
        );
    }
}
