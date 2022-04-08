<?php

declare(strict_types=1);

namespace Tests\Feature\EmployeeContext\Infrastructure\Persistence;

use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeName;
use Api\V1\EmployeeContext\Infrastructure\Persistence\EloquentEmployeeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentEmployeeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_find_all_employee(): void
    {
        // Given
        $this->createAnEmployee();

        // When
        $employees = (new EloquentEmployeeRepository)->findAll();

        // Then
        $this->assertCount(1, $employees);
    }

    /** @test */
    public function it_should_create_an_employee(): void
    {
        // Given
        $employee = $this->makeAnEmployeeAsObject();

        // When
        (new EloquentEmployeeRepository)->create(employee: $employee);

        // Then
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id(),
            'name' => $employee->name(),
            'email' => $employee->email(),
            'createdAt' => $employee->createdAt(),
            'updatedAt' => $employee->updatedAt(),
        ]);
    }

    /** @test */
    public function it_should_find_an_employee_by_id(): void
    {
        // Given
        $employee = $this->makeAnEmployeeAsObject(
            employee: $this->createAnEmployee()
        );

        // When
        $employeeFound = (new EloquentEmployeeRepository)
            ->findById(employeeId: $employee->id());

        // Then
        $this->assertEquals(
            expected: $employee->id(),
            actual: $employeeFound->id()
        );
    }

    /** @test */
    public function it_should_not_find_an_employee_by_id(): void
    {
        // Given
        $employeeId = $this->makeAnEmployeeAsObject();

        // When
        $employeeFound = (new EloquentEmployeeRepository)
            ->findById(employeeId: $employeeId->id());

        // Then
        $this->assertNull($employeeFound);
    }

    /** @test */
    public function it_should_not_find_an_employee_by_id_when_deleted(): void
    {
        // Given
        $employee = $this->makeAnEmployeeAsObject(
            $this->createAnEmployee(deleted: true)
        );

        // When
        $result = (new EloquentEmployeeRepository)
            ->findById(
                employeeId: $employee->id()
            );

        // Then
        $this->assertNull($result);
    }

    /** @test */
    public function it_should_update_an_employee(): void
    {
        // Given
        $employee = $this->makeAnEmployeeAsObject(
            $this->createAnEmployee()
        );
        $employee->update(
            name: new EmployeeName(value: $this->faker->name),
            email: new EmployeeEmail(email: $this->faker->email)
        );

        // When
        (new EloquentEmployeeRepository)->update(
            employee: $employee
        );

        // Then
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id(),
            'name' => $employee->name(),
            'email' => $employee->email(),
            'createdAt' => $employee->createdAt(),
            'updatedAt' => $employee->updatedAt(),
        ]);
    }

    /** @test */
    public function it_should_delete_an_employee(): void
    {
        // Given
        $employee = $this->makeAnEmployeeAsObject(
            $this->createAnEmployee()
        );
        $employee->delete();

        // When
        (new EloquentEmployeeRepository)->delete(
            employee: $employee
        );

        // Then
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id(),
            'name' => $employee->name(),
            'email' => $employee->email(),
            'createdAt' => $employee->createdAt(),
            'updatedAt' => $employee->updatedAt(),
            'deletedAt' => $employee->deletedAt(),
        ]);
    }
}
