<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Domain;

use Api\V1\SharedContext\Infrastructure\Utils\Collection;
use stdClass;

class EmployeeCollection extends Collection
{
    public function __construct(array $employees = [])
    {
        $this->items = $employees;
    }

}
