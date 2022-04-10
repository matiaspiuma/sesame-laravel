<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Domain;

use Api\V1\SharedContext\Domain\Collection;

class WorkEntries extends Collection
{
    protected function type(): string
    {
        return WorkEntry::class;
    }
}
