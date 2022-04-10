<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Domain;

use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\SharedContext\Domain\Collection;
use Api\V1\SharedContext\Infrastructure\Utils\CollectionInterface;

interface EmployeeRepository
{
    public function findAll(): Collection;

    public function create(Employee $employee): void;

    public function findById(EmployeeId $employeeId): ?Employee;

    public function update(Employee $employee): void;

    public function delete(Employee $employee): void;
}
