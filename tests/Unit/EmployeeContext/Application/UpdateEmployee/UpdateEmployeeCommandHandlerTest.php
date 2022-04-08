<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Application\UpdateEmployee;

use Api\V1\EmployeeContext\Application\UpdateEmployee\EmployeeUpdator;
use Api\V1\EmployeeContext\Application\UpdateEmployee\UpdateEmployeeCommand;
use Api\V1\EmployeeContext\Application\UpdateEmployee\UpdateEmployeeCommandHandler;
use Tests\TestCase;

final class UpdateEmployeeCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_update_an_employee(): void
    {
        // Given
        $employee = $this->makeAnEmployee();

        $this->employeeRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn(
                $this->makeAnEmployeeAsObject($employee)
            );

        $this->employeeRepository()
            ->shouldReceive('update')
            ->once()
            ->andReturnNull();

        // When
        $commad = new UpdateEmployeeCommandHandler(
            employeeUpdator: new EmployeeUpdator(
                $this->employeeRepository()
            )
        );

        $commad(new UpdateEmployeeCommand(
            $employee['id'],
            $employee['name'],
            $employee['email'],
        ));
    }
}
