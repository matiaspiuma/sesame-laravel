<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\FindEmployeeById;

use Api\V1\SharedContext\Application\CQRS\Query\QueryInterface;

final class FindEmployeeByIdQuery implements QueryInterface
{
    public function __construct(
        public readonly string $id
    )
    {
    }
}
