<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntryById;

use Api\V1\SharedContext\Application\CQRS\Query\QueryInterface;

final class FindWorkEntryByIdAndEmployeeIdQuery implements QueryInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $employeeId
    )
    {
    }
}
