<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Application\FindEmployee;

use Api\V1\EmployeeContext\Application\FindEmployeeById\EmployeeFinderById;
use Api\V1\EmployeeContext\Application\FindEmployeeById\FindEmployeeByIdQuery;
use Api\V1\EmployeeContext\Application\FindEmployeeById\FindEmployeeByIdQueryHandler;
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
        $query = new FindEmployeeByIdQueryHandler(
            employeeFinder: new EmployeeFinderById(
                $this->employeeRepository()
            )
        );

        $query(new FindEmployeeByIdQuery(
            id: $employee['id']
        ));
    }
}
