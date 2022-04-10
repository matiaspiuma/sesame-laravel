<?php

declare(strict_types=1);

namespace Tests\Feature\EmployeeContext\Employee\Infrastructure\Persistence;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeNotExistsException;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeName;
use Api\V1\EmployeeContext\Employee\Infrastructure\Persistence\DBEmployeeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DBEmployeeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_find_all_employee(): void
    {
        // Given
        $this->makeEmployee(true);

        // When
        $employees = (new DBEmployeeRepository)->findAll();

        // Then
        $this->assertCount(1, $employees);
    }

    /** @test */
    public function it_should_create_an_employee(): void
    {
        // Given
        $employee = $this->makeEmployee(false);

        // When
        (new DBEmployeeRepository)->create($employee);

        // Then
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id()->value(),
            'name' => $employee->name()->value(),
            'email' => $employee->email()->value(),
            'createdAt' => $employee->createdAt()->value(),
            'updatedAt' => $employee->updatedAt()->value(),
        ]);
    }

    /** @test */
    public function it_should_find_an_employee_by_id(): void
    {
        // Given
        $employee = $this->makeEmployee(true);

        // When
        $employeeFound = (new DBEmployeeRepository)->findById($employee->id());

        // Then
        $this->assertEquals($employee->id()->value(), $employeeFound->id()->value());
    }

    /** @test */
    public function it_should_not_find_an_employee_by_id(): void
    {
        // Given
        $employee = $this->makeEmployee();

        // When
        $employeeFound = (new DBEmployeeRepository)->findById($employee->id());

        // Then
        $this->assertNull($employeeFound);
    }

    /** @test */
    public function it_should_not_find_an_employee_by_id_when_deleted(): void
    {
        // Given
        $employee = $this->makeEmployee(true, true);

        // When
        $result = (new DBEmployeeRepository)->findById($employee->id());

        // Then
        $this->assertNull($result);
    }

    /** @test */
    public function it_should_update_an_employee(): void
    {
        // Given
        $employee = $this->makeEmployee(true);

        $employee->update(
            new EmployeeName($this->faker->name),
            new EmployeeEmail($this->faker->email)
        );

        // When
        (new DBEmployeeRepository)->update($employee);

        // Then
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id()->value(),
            'name' => $employee->name()->value(),
            'email' => $employee->email()->value(),
            'createdAt' => $employee->createdAt()->value(),
            'updatedAt' => $employee->updatedAt()->value(),
        ]);
    }

    /** @test */
    public function it_should_delete_an_employee(): void
    {
        // Given
        $employee = $this->makeEmployee(true);
        $employee->delete();

        // When
        (new DBEmployeeRepository)->delete($employee);

        // Then
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id()->value(),
            'name' => $employee->name(),
            'email' => $employee->email(),
            'createdAt' => $employee->createdAt()->value(),
            'updatedAt' => $employee->updatedAt()->value(),
            'deletedAt' => $employee->deletedAt()->value(),
        ]);
    }
}
