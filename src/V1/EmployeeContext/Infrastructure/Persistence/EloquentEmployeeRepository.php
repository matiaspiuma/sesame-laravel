<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Infrastructure\Persistence;

use Api\V1\EmployeeContext\Domain\Employee;
use Api\V1\EmployeeContext\Domain\EmployeeRepository;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\SharedContext\Infrastructure\ORM\EloquentRepository;
use Illuminate\Support\Facades\DB;

final class EloquentEmployeeRepository extends EloquentRepository implements EmployeeRepository
{
    public function findAll(): array
    {
        $employees = DB::table('employees')->get();

        return $employees->map(
            fn ($employee) => Employee::fromPrimitives(
                id: $employee->id,
                name: $employee->name,
                email: $employee->email,
                createdAt: $employee->createdAt,
                updatedAt: $employee->updatedAt
            ),
        )->toArray();
    }

    public function create(Employee $employee): void
    {
        $query = 'INSERT INTO 
            employees (id, name, email, createdAt, updatedAt) 
            VALUES (?, ?, ?, ?, ?)';

        try {
            DB::insert(
                query: $query,
                bindings: [
                    $employee->id(),
                    $employee->name(),
                    $employee->email(),
                    $employee->createdAt(),
                    $employee->updatedAt(),
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception('Error creating employee');
        }
    }

    public function findById(EmployeeId $employeeId): ?Employee
    {
        $query = 'SELECT * FROM employees WHERE id = ? AND deletedAt IS NULL LIMIT 1';

        $employees = DB::select(
            query: $query,
            bindings: [
                $employeeId->value(),
            ]
        );

        if (\count($employees) === 0) {
            return null;
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
        $query = 'UPDATE employees SET name = ?, email = ?, updatedAt = ? WHERE id = ? AND deletedAt IS NULL';

        try {
            DB::update(
                query: $query,
                bindings: [
                    $employee->name(),
                    $employee->email(),
                    (string) $employee->updatedAt(),
                    $employee->id()->value()
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception('Error updating employee');
        }
    }

    public function delete(Employee $employee): void
    {
        $query = 'UPDATE employees SET deletedAt = ? WHERE id = ? AND deletedAt IS NULL';

        try {
            DB::update(
                query: $query,
                bindings: [
                    (string) $employee->deletedAt(),
                    $employee->id()->value()
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception('Error deleting employee');
        }
    }
}
