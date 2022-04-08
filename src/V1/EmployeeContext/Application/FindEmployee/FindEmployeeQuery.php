<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\FindEmployee;

use Api\V1\SharedContext\Application\CQRS\Query\QueryInterface;

final class FindEmployeeQuery implements QueryInterface
{
    public function __construct(
        private string $id
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
}
