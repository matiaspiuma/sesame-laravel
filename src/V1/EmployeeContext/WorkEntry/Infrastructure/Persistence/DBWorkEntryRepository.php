<?php

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Persistence;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntries;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Illuminate\Support\Facades\DB;

final class DBWorkEntryRepository implements WorkEntryRepository
{
    private string $table = 'work_entries';

    public function findAllByEmployeeId(EmployeeId $employeeId): WorkEntries
    {
        $query = sprintf(
            "SELECT * FROM %s WHERE employeeId = ? AND deletedAt IS NULL",
            $this->table
        );

        $workEntries = DB::select($query, [$employeeId]);

        return new WorkEntries(\array_map(
            fn($workEntry) => WorkEntry::fromPrimitives(
                $workEntry->id,
                $workEntry->employeeId,
                $workEntry->startDate,
                $workEntry->createdAt,
                $workEntry->updatedAt,
                $workEntry->endDate,
            ),
            $workEntries
        ));
    }

    public function findByIdAndEmployeeId(WorkEntryId $workEntryId, EmployeeId $employeeId): ?WorkEntry
    {
        $query = sprintf(
            "SELECT * FROM %s WHERE id = ? AND employeeId = ? AND deletedAt IS NULL LIMIT 1",
            $this->table
        );

        $workEntries = DB::select($query, [$workEntryId->value(), $employeeId->value()]);

        if (\count($workEntries) === 0) {
            return null;
        }

        return WorkEntry::fromPrimitives(
            $workEntries[0]->id,
            $workEntries[0]->employeeId,
            $workEntries[0]->startDate,
            $workEntries[0]->createdAt,
            $workEntries[0]->updatedAt,
            $workEntries[0]->endDate,
        );
    }

    public function create(WorkEntry $workEntry): void
    {
        $query = sprintf(
            "INSERT INTO %s (id, employeeId, startDate, endDate, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?)",
            $this->table
        );

        DB::insert($query, [
            $workEntry->id()->value(),
            $workEntry->employeeId()->value(),
            (string)$workEntry->startDate(),
            (string)$workEntry->endDate(),
            (string)$workEntry->createdAt(),
            (string)$workEntry->updatedAt(),
        ]);
    }

    public function update(WorkEntry $workEntry): void
    {
        $query = sprintf(
            "UPDATE %s SET startDate = ?, endDate = ?, updatedAt = ? WHERE id = ? AND deletedAt IS NULL",
            $this->table
        );

        DB::update($query, [
            (string)$workEntry->startDate(),
            (string)$workEntry->endDate(),
            (string)$workEntry->updatedAt(),
            $workEntry->id()->value(),
        ]);
    }

    public function delete(WorkEntry $workEntry): void
    {
        $query = sprintf(
            "UPDATE %s SET deletedAt = ? WHERE id = ? AND deletedAt IS NULL",
            $this->table
        );

        DB::update($query, [(string)$workEntry->deletedAt(), $workEntry->id()->value()]);
    }
}
