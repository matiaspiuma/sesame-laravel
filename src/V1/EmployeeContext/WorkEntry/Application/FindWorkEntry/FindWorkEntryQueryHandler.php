<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\SharedContext\Application\CQRS\Query\QueryHandlerInterface;

final class FindWorkEntryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WorkEntryFinder $finder
    ) {
    }

    public function __invoke(FindWorkEntryQuery $query): mixed
    {
        return $this->finder->__invoke(
            workEntryId: new WorkEntryId($query->id()),
        );
    }
}
