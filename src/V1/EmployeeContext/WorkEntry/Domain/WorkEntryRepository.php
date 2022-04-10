<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Domain;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

interface WorkEntryRepository
{
    public function create(WorkEntry $workEntry): void;

    public function findAllByEmployeeId(EmployeeId $employeeId): WorkEntries;

    public function findByIdAndEmployeeId(WorkEntryId $workEntryId, EmployeeId $employeeId): ?WorkEntry;

    public function update(WorkEntry $workEntry): void;

    public function delete(WorkEntry $workEntry): void;
}
