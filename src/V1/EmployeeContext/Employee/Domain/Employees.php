<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Domain;

use Api\V1\SharedContext\Domain\Collection;

class Employees extends Collection
{
    protected function type(): string
    {
        return Employee::class;
    }
}
