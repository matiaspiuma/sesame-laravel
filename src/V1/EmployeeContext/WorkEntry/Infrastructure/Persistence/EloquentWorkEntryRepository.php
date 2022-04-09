<?php

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Persistence;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Illuminate\Support\Facades\DB;

final class EloquentWorkEntryRepository implements WorkEntryRepository
{
    private string $table = 'work_entries';

    public function create(WorkEntry $workEntry): void
    {
        $query = sprintf(
            "INSERT INTO %s (id, employeeId, startDate, endDate, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?)",
            $this->table
        );

        DB::insert(
            query: $query,
            bindings: [
                $workEntry->id,
                $workEntry->employeeId,
                (string) $workEntry->startDate(),
                (string) $workEntry->endDate(),
                (string) $workEntry->createdAt,
                (string) $workEntry->updatedAt(),
            ]
        );
    }

    public function findAllByEmployeeId(EmployeeId $employeeId): array
    {
        $query = sprintf(
            "SELECT * FROM %s WHERE employeeId = ? AND deletedAt IS NULL",
            $this->table
        );

        $workEntries = DB::select(
            query: $query,
            bindings: [
                $employeeId,
            ]
        );

        return \array_map(
            fn ($workEntry) => WorkEntry::fromPrimitives(
                id: $workEntry->id,
                employeeId: $workEntry->employeeId,
                startDate: $workEntry->startDate,
                endDate: $workEntry->endDate,
                createdAt: $workEntry->createdAt,
                updatedAt: $workEntry->updatedAt,
            ),
            $workEntries
        );
    }

    public function findById(WorkEntryId $workEntryId): WorkEntry
    {
        $query = sprintf(
            "SELECT * FROM %s WHERE id = ? AND deletedAt IS NULL LIMIT 1",
            $this->table
        );

        $workEntries = DB::select(
            query: $query,
            bindings: [
                $workEntryId,
            ]
        );

        if (\count($workEntries) === 0) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException(
                \sprintf('Work entry with id "%s" does not exist.', $workEntryId)
            );
        }

        return WorkEntry::fromPrimitives(
            id: $workEntries[0]->id,
            employeeId: $workEntries[0]->employeeId,
            startDate: $workEntries[0]->startDate,
            endDate: $workEntries[0]->endDate,
            createdAt: $workEntries[0]->createdAt,
            updatedAt: $workEntries[0]->updatedAt,
        );
    }

    public function update(WorkEntry $workEntry): void
    {
        $query = sprintf(
            "UPDATE %s SET startDate = ?, endDate = ?, updatedAt = ? WHERE id = ? AND deletedAt IS NULL",
            $this->table
        );

        DB::update(
            query: $query,
            bindings: [
                (string) $workEntry->startDate(),
                (string) $workEntry->endDate(),
                (string) $workEntry->updatedAt(),
                $workEntry->id,
            ]
        );
    }

    public function delete(WorkEntry $workEntry): void
    {
        $query = sprintf(
            "UPDATE %s SET deletedAt = ? WHERE id = ? AND deletedAt IS NULL",
            $this->table
        );

        DB::update(
            query: $query,
            bindings: [
                (string) $workEntry->deletedAt(),
                $workEntry->id
            ]
        );
    }
}
