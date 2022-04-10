<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Employee\Application\SearchEmployees;

use Api\V1\EmployeeContext\Employee\Application\FindAllEmployees\EmployeesFinder;
use Api\V1\EmployeeContext\Employee\Application\FindAllEmployees\FindAllEmployeesQuery;
use Api\V1\EmployeeContext\Employee\Application\FindAllEmployees\FindAllEmployeesQueryHandler;
use Api\V1\EmployeeContext\Employee\Domain\Employees;
use Tests\TestCase;

final class SearchEmployeesQueryHandlerTest extends TestCase
{
    /** @test */
    public function it_should_find_all_employee(): void
    {
        // Given
        $this->makeEmployee();

        $this->employeeRepository()
            ->shouldReceive('findAll')
            ->once()
            ->andReturn($this->mock(Employees::class));

        // When
        $query = new FindAllEmployeesQueryHandler(
            new EmployeesFinder(
                $this->employeeRepository()
            )
        );

        $query(new FindAllEmployeesQuery());
    }
}
