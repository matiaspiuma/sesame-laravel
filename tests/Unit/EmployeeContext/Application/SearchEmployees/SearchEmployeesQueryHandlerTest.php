<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Application\DeleteEmployee;

use Api\V1\EmployeeContext\Application\SearchEmployees\EmployeesFinder;
use Api\V1\EmployeeContext\Application\SearchEmployees\SearchEmployeesQuery;
use Api\V1\EmployeeContext\Application\SearchEmployees\SearchEmployeesQueryHandler;
use Tests\TestCase;

final class SearchEmployeesQueryHandlerTest extends TestCase
{
    /** @test */
    public function it_should_find_all_employee(): void
    {
        // Given
        $employee = $this->makeAnEmployee();

        $this->employeeRepository()
            ->shouldReceive('findAll')
            ->once();

        // When
        $query = new SearchEmployeesQueryHandler(
            employeesFinder: new EmployeesFinder(
                $this->employeeRepository()
            )
        );

        $query(new SearchEmployeesQuery());
    }
}
