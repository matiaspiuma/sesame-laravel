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
                createdAt: $employee['created_at'],
                updatedAt: $employee['updated_at'],
                deletedAt: $employee['deleted_at']
            ),
            $employees
        );
    }

    public function create(Employee $employee): void
    {
        $this->connection->prepare(
            sql: 'INSERT INTO 
                employees 
                (id, name, email, created_at, updated_at, deleted_at) 
            VALUES 
                (:id, :name, :email, :created_at, :updated_at, :deleted_at)'
        )->executeQuery(
            params: $employee->toPrimitives()
        );
    }

    public function findById(EmployeeId $employeeId): ?Employee
    {
        $employee = $this->connection->prepare(
            sql: 'SELECT * FROM employees WHERE id = :id AND deleted_at IS NULL LIMIT 1',
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
            createdAt: $employee[0]['created_at'],
            updatedAt: $employee[0]['updated_at'],
            deletedAt: $employee[0]['deleted_at']
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
                'name' => $employee->name(),
                'email' => $employee->email(),
                'updated_at' => (string) $employee->updatedAt(),
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
                'deleted_at' => (string) $employee->deletedAt(),
                'id' => $employee->id()->value()
            ]
        );
    }
}
