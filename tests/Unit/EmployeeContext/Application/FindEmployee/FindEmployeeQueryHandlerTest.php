<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Application\DeleteEmployee;

use Api\V1\EmployeeContext\Application\FindEmployee\EmployeeFinder;
use Api\V1\EmployeeContext\Application\FindEmployee\FindEmployeeQuery;
use Api\V1\EmployeeContext\Application\FindEmployee\FindEmployeeQueryHandler;
use Tests\TestCase;

final class FindEmployeeQueryHandlerTest extends TestCase
{
    /** @test */
    public function it_should_find_an_employee(): void
    {
        // Given
        $employee = $this->makeAnEmployee();

        $this->employeeRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn(
                $this->makeAnEmployeeAsObject($employee)
            );

        // When
        $query = new FindEmployeeQueryHandler(
            employeeFinder: new EmployeeFinder(
                $this->employeeRepository()
            )
        );

        $query(new FindEmployeeQuery(
            id: $employee['id']
        ));
    }
}
