<?php

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Persistence;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;

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

    public function delete(WorkEntry $workEntry): void
    {
    }
}
