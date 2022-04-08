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
                createdAt: $employee->created_at,
                updatedAt: $employee->updated_at
            ),
        )->toArray();
    }

    public function create(Employee $employee): void
    {
        $query = 'INSERT INTO employees (id, name, email, created_at, updated_at) VALUES (?, ?, ?, ?, ?)';

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
        $query = 'SELECT * FROM employees WHERE id = ? AND deleted_at IS NULL LIMIT 1';

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
            createdAt: $employees[0]->created_at,
            updatedAt: $employees[0]->updated_at,
        );
    }

    public function update(Employee $employee): void
    {
        // if not exists then throw exception
        $this->connection->prepare(
            sql: 'UPDATE employees SET 
                name = :name, 
                email = :email, 
                updated_at = :updated_at 
            WHERE id = :id'
        )->executeQuery(
            params: [
                'name' => $employee->name()->value(),
                'email' => $employee->email()->value(),
                'updated_at' => $employee->updatedAt()->__toString(),
                'id' => $employee->id()->value()
            ]
        );
    }

    public function delete(Employee $employee): void
    {
        // if not exists then throw exception
        $this->connection->prepare(
            sql: 'UPDATE employees SET 
                deleted_at = :deleted_at 
            WHERE id = :id'
        )->executeQuery(
            params: [
                'deleted_at' => $employee->deletedAt()->__toString(),
                'id' => $employee->id()->value()
            ]
        );
    }
}