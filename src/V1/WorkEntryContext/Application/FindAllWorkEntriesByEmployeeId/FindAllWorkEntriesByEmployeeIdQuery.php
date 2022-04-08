<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\FindAllWorkEntriesByEmployeeId;


use Api\V1\SharedContext\Application\CQRS\Query\QueryInterface;

final class FindAllWorkEntriesByEmployeeIdQuery implements QueryInterface
{
    public function __construct(
        private string $employeeId
    ) {
    }

    public function employeeId(): string
    {
        return $this->employeeId;
    }
}