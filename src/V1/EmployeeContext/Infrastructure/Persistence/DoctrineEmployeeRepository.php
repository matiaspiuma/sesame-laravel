<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Infrastructure\Persistence;

use Api\V1\EmployeeContext\Domain\Employee;
use Api\V1\EmployeeContext\Domain\EmployeeRepository;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\SharedContext\Infrastructure\ORM\DoctrineRepository;

final class DoctrineEmployeeRepository extends DoctrineRepository implements EmployeeRepository
{
    protected static function entityClass(): string
    {
        return Employee::class;
    }

    public function findAll(): array
    {
        $employees = $this->connection->executeQuery(
            'SELECT * FROM Employees'
        )->fetchAllAssociative();

        return \array_map(
            fn ($employee) => Employee::fromPrimitives(
                id: $employee['id'],
                name: $employee['name'],
                email: $employee['email'],
                createdAt: $employee['createdAt'],
                updatedAt: $employee['updatedAt'],
                deletedAt: $employee['deletedAt']
            ),
            $employees
        );
    }

    public function create(Employee $employee): void
    {
        $this->connection->prepare(
            sql: 'INSERT INTO 
                employees 
                (id, name, email, createdAt, updatedAt, deletedAt) 
            VALUES 
                (:id, :name, :email, :createdAt, :updatedAt, :deletedAt)'
        )->executeQuery(
            params: $employee->toPrimitives()
        );
    }

    public function findById(EmployeeId $employeeId): ?Employee
    {
        $employee = $this->connection->prepare(
            sql: 'SELECT * FROM employees WHERE id = :id AND deletedAt IS NULL LIMIT 1',
        )->executeQuery(
            params: ['id' => $employeeId->value()]
        )->fetchAllAssociative();

        if (\count($employee) === 0) {
            return null;
        }

        return Employee::fromPrimitives(
            id: $employee[0]['id'],
            name: $employee[0]['name'],
            email: $employee[0]['email'],
            createdAt: $employee[0]['createdAt'],
            updatedAt: $employee[0]['updatedAt'],
            deletedAt: $employee[0]['deletedAt']
        );
    }

    public function update(Employee $employee): void
    {
        // if not exists then throw exception
        $this->connection->prepare(
            sql: 'UPDATE employees SET 
                name = :name, 
                email = :email, 
                updatedAt = :updatedAt 
            WHERE id = :id'
        )->executeQuery(
            params: [
                'name' => $employee->name(),
                'email' => $employee->email(),
                'updatedAt' => (string) $employee->updatedAt(),
                'id' => $employee->id,
            ]
        );
    }

    public function delete(Employee $employee): void
    {
        // if not exists then throw exception
        $this->connection->prepare(
            sql: 'UPDATE employees SET 
                deletedAt = :deletedAt 
            WHERE id = :id'
        )->executeQuery(
            params: [
                'deletedAt' => (string) $employee->deletedAt(),
                'id' => $employee->id
            ]
        );
    }
}
