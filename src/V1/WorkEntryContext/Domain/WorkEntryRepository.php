<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Domain;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;

interface WorkEntryRepository
{
    public function create(WorkEntry $workEntry): void;

    public function findAllByEmployeeId(EmployeeId $employeeId): array;
}