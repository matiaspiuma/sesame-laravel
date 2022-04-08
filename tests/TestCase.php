<?php

namespace Tests;

use Api\V1\EmployeeContext\Domain\Employee;
use Api\V1\EmployeeContext\Domain\EmployeeRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Mockery\MockInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;

    private $employeeRepository;

    protected function makeAnEmployee(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
 
    }
    protected function makeAnEmployeeAsObject(?array $employee = null): Employee
    {
        $employee = $employee ?? $this->makeAnEmployee();

        return Employee::fromPrimitives(
            id: $employee['id'],
            name: $employee['name'],
            email: $employee['email'],
            createdAt: now(),
            updatedAt: now(),
        );
    }

    protected function createAnEmployee(): array
    {
        $employee = $this->makeAnEmployee();

        DB::insert('insert into employees (id, name, email, created_at, updated_at) values (?, ?, ?, ?, ?)', [
            $employee['id'],
            $employee['name'],
            $employee['email'],
            now(),
            now(),
        ]);

        return $employee;
    }

    protected function employeeRepository(): EmployeeRepository|MockInterface|null
    {
        if ($this->employeeRepository === null) {
            $this->employeeRepository = $this->mock(EmployeeRepository::class);
        }
        
        return $this->employeeRepository;
    }
}
