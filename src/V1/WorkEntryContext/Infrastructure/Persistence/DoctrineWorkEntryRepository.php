<?php

namespace Api\V1\WorkEntryContext\Infrastructure\Persistence;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;
use Api\V1\WorkEntryContext\Domain\WorkEntry;
use Api\V1\WorkEntryContext\Domain\WorkEntryRepository;

final class DoctrineWorkEntryRepository implements WorkEntryRepository
{
    public function create(WorkEntry $workEntry): void
    {
        //
    }

    public function findAllByEmployeeId(EmployeeId $employeeId): array
    {
        return [];
    }

    public function findById(WorkEntryId $workEntryId): ?WorkEntry
    {
        return null;
    }

    public function update(WorkEntry $workEntry): void
    {
        //
    }
}