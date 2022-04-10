<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Employee\Application\FindEmployee;

use Api\V1\EmployeeContext\Employee\Application\FindEmployeeById\EmployeeFinderById;
use Api\V1\EmployeeContext\Employee\Application\FindEmployeeById\FindEmployeeByIdQuery;
use Api\V1\EmployeeContext\Employee\Application\FindEmployeeById\FindEmployeeByIdQueryHandler;
use Tests\TestCase;

final class FindEmployeeQueryHandlerTest extends TestCase
{
    /** @test */
    public function it_should_find_an_employee(): void
    {
        // Given
        $employee = $this->makeEmployee();

        $this->employeeRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn($employee);

        // When
        $query = new FindEmployeeByIdQueryHandler(
            new EmployeeFinderById(
                $this->employeeRepository()
            )
        );

        $query(new FindEmployeeByIdQuery(
            $employee->id()->value()
        ));
    }
}
