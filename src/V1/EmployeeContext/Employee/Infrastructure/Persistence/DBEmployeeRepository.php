<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Persistence;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Employee\Domain\Employees;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\SharedContext\Infrastructure\ORM\EloquentRepository;
use Api\V1\SharedContext\Infrastructure\Utils\EloquentCollection;
use Illuminate\Support\Facades\DB;

final class DBEmployeeRepository extends EloquentRepository implements EmployeeRepository
{
    private string $table = 'employees';

    public function findAll(): Employees
    {
        $employees = DB::select(
            \sprintf("SELECT * FROM %s WHERE deletedAt IS NULL", $this->table)
        );

        return new Employees(\array_map(
            fn($employee) => Employee::fromPrimitives(
                $employee->id,
                $employee->name,
                $employee->email,
                $employee->createdAt,
                $employee->updatedAt
            ),
            $employees
        ));
    }

    public function create(Employee $employee): void
    {
        DB::insert(
            \sprintf(
                "INSERT INTO %s (id, name, email, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?)",
                $this->table
            ),
            [
                $employee->id(),
                $employee->name(),
                $employee->email(),
                $employee->createdAt(),
                $employee->updatedAt(),
            ]
        );
    }

    public function findById(EmployeeId $employeeId): ?Employee
    {
        $employees = DB::select(
            \sprintf(
                "SELECT * FROM %s WHERE id = ? AND deletedAt IS NULL LIMIT 1",
                $this->table
            ),
            [$employeeId]
        );

        if (\count($employees) === 0) {
            return null;
        }

        return Employee::fromPrimitives(
            $employees[0]->id,
            $employees[0]->name,
            $employees[0]->email,
            $employees[0]->createdAt,
            $employees[0]->updatedAt,
        );
    }

    public function update(Employee $employee): void
    {
        DB::update(
            \sprintf(
                "UPDATE %s SET name = ?, email = ?, updatedAt = ? WHERE id = ? AND deletedAt IS NULL",
                $this->table
            ),
            [
                $employee->name(),
                $employee->email(),
                (string)$employee->updatedAt(),
                $employee->id(),
            ]
        );
    }

    public function delete(Employee $employee): void
    {
        DB::update(
            \sprintf(
                "UPDATE %s SET deletedAt = ? WHERE id = ? AND deletedAt IS NULL",
                $this->table
            ),
            [
                (string)$employee->deletedAt(), $employee->id(),
            ]
        );
    }
}
