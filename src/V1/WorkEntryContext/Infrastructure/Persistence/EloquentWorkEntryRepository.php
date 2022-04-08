<?php

namespace Api\V1\WorkEntryContext\Infrastructure\Persistence;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\WorkEntryContext\Domain\WorkEntry;
use Api\V1\WorkEntryContext\Domain\WorkEntryRepository;
use Illuminate\Support\Facades\DB;

final class EloquentWorkEntryRepository implements WorkEntryRepository
{
    public function create(WorkEntry $workEntry): void
    {
        //
    }

    public function findAllByEmployeeId(EmployeeId $employeeId): array
    {
        $query = 'SELECT * FROM work_entries WHERE employee_id = ? AND deleted_at IS NULL';

        $workEntries = DB::select(
            query: $query,
            bindings: [
                $employeeId->value(),
            ]
        );

        return \array_map(
            fn ($workEntry) => WorkEntry::fromPrimitives(
                id: $workEntry->id,
                employeeId: $workEntry->employee_id,
                startDate: $workEntry->start_date,
                endDate: $workEntry->end_date,
                createdAt: $workEntry->created_at,
                updatedAt: $workEntry->updated_at,
            ),
            $workEntries
        );
    }
}
