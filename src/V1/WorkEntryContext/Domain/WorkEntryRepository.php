<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Domain;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;

interface WorkEntryRepository
{
    public function create(WorkEntry $workEntry): void;

    public function findAllByEmployeeId(EmployeeId $employeeId): array;

    public function findById(WorkEntryId $workEntryId): ?WorkEntry;

    public function update(WorkEntry $workEntry): void;

    public function delete(WorkEntry $workEntry): void;
}