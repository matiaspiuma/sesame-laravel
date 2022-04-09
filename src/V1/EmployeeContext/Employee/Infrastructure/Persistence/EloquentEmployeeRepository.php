<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Persistence;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeCollection;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\SharedContext\Infrastructure\ORM\EloquentRepository;
use App\Exceptions\RecordNotFoundException;
use Illuminate\Support\Facades\DB;
use function array_map;
use function count;

final class EloquentEmployeeRepository extends EloquentRepository implements EmployeeRepository
{
    private string $table = 'employees';

    public function findAll(): EmployeeCollection
    {
        $employees = DB::select(
            query: sprintf("SELECT * FROM %s WHERE deletedAt IS NULL", $this->table)
        );

        return new EmployeeCollection(array_map(
            fn($employee) => Employee::fromPrimitives(
                id: $employee->id,
                name: $employee->name,
                email: $employee->email,
                createdAt: $employee->createdAt,
                updatedAt: $employee->updatedAt
            ),
            $employees
        ));
    }

    public function create(Employee $employee): void
    {
        $query = sprintf(
            "INSERT INTO %s (id, name, email, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?)",
            $this->table
        );

        DB::insert(
            query: $query,
            bindings: [
                $employee->id,
                $employee->name(),
                $employee->email(),
                $employee->createdAt,
                $employee->updatedAt(),
            ]
        );
    }

    public function findById(EmployeeId $employeeId): ?Employee
    {
        $query = sprintf(
            "SELECT * FROM %s WHERE id = ? AND deletedAt IS NULL LIMIT 1",
            $this->table
        );

        $employees = DB::select(
            query: $query,
            bindings: [
                $employeeId,
            ]
        );

        if (count($employees) === 0) {
            throw new RecordNotFoundException('Error finding employee');
        }

        return Employee::fromPrimitives(
            id: $employees[0]->id,
            name: $employees[0]->name,
            email: $employees[0]->email,
            createdAt: $employees[0]->createdAt,
            updatedAt: $employees[0]->updatedAt,
        );
    }

    public function update(Employee $employee): void
    {
        $query = sprintf(
            "UPDATE %s SET name = ?, email = ?, updatedAt = ? WHERE id = ? AND deletedAt IS NULL",
            $this->table
        );


        DB::update(
            query: $query,
            bindings: [
                $employee->name(),
                $employee->email(),
                (string)$employee->updatedAt(),
                $employee->id,
            ]
        );
    }

    public function delete(Employee $employee): void
    {
        $query = sprintf(
            "UPDATE %s SET deletedAt = ? WHERE id = ? AND deletedAt IS NULL",
            $this->table
        );


        DB::update(
            query: $query,
            bindings: [
                (string)$employee->deletedAt(),
                $employee->id,
            ]
        );
    }
}
