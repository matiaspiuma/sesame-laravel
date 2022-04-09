<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Domain;

use Api\V1\SharedContext\Infrastructure\Utils\Collection;

class EmployeeCollection extends Collection
{
    public function __construct(array $employees = [])
    {
        parent::__construct(items: $employees);
    }

}
