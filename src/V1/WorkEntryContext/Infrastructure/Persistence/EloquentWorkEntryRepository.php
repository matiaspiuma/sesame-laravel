<?php

namespace Api\V1\WorkEntryContext\Infrastructure\Persistence;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;
use Api\V1\WorkEntryContext\Domain\WorkEntry;
use Api\V1\WorkEntryContext\Domain\WorkEntryRepository;
use Illuminate\Support\Facades\DB;

final class EloquentWorkEntryRepository implements WorkEntryRepository
{
    public function create(WorkEntry $workEntry): void
    {
        $query = 'INSERT INTO work_entries (id, employee_id, start_date, end_date, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)';

        try {
            DB::insert(
                query: $query,
                bindings: [
                    $workEntry->id()->value(),
                    $workEntry->employeeId()->value(),
                    (string) $workEntry->startDate(),
                    (string) $workEntry->endDate(),
                    (string) $workEntry->createdAt(),
                    (string) $workEntry->updatedAt(),
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception('Error creating work entry');
        }
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

    public function findById(WorkEntryId $workEntryId): WorkEntry
    {
        $query = 'SELECT * FROM work_entries WHERE id = ? AND deleted_at IS NULL LIMIT 1';

        $workEntries = DB::select(
            query: $query,
            bindings: [
                $workEntryId->value(),
            ]
        );

        if (\count($workEntries) === 0) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException(
                \sprintf('Work entry with id "%s" does not exist.', $workEntryId->value())
            );
        }

        return WorkEntry::fromPrimitives(
            id: $workEntries[0]->id,
            employeeId: $workEntries[0]->employee_id,
            startDate: $workEntries[0]->start_date,
            endDate: $workEntries[0]->end_date,
            createdAt: $workEntries[0]->created_at,
            updatedAt: $workEntries[0]->updated_at,
        );
    }

    public function update(WorkEntry $workEntry): void
    {
        $query = 'UPDATE work_entries SET start_date = ?, end_date = ?, updated_at = ? WHERE id = ? AND deleted_at IS NULL';

        try {
            DB::update(
                query: $query,
                bindings: [
                    (string) $workEntry->startDate(),
                    (string) $workEntry->endDate(),
                    (string) $workEntry->updatedAt(),
                    $workEntry->id()->value(),
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception('Error updating work entry');
        }
    }

    public function delete(WorkEntry $workEntry): void
    {
        $query = 'UPDATE work_entries SET deleted_at = ? WHERE id = ? AND deleted_at IS NULL';

        try {
            DB::update(
                query: $query,
                bindings: [
                    (string) $workEntry->deletedAt(),
                    $workEntry->id()->value()
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception('Error deleting work entry');
        }
    }
}
