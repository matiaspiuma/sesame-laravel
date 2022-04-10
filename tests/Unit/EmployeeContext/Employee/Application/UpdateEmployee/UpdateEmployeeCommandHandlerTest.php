<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Employee\Application\UpdateEmployee;

use Api\V1\EmployeeContext\Employee\Application\UpdateEmployee\EmployeeUpdator;
use Api\V1\EmployeeContext\Employee\Application\UpdateEmployee\UpdateEmployeeCommand;
use Api\V1\EmployeeContext\Employee\Application\UpdateEmployee\UpdateEmployeeCommandHandler;
use Tests\TestCase;

final class UpdateEmployeeCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_update_an_employee(): void
    {
        // Given
        $employee = $this->makeEmployee();

        $this->employeeRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn($employee);

        $this->employeeRepository()
            ->shouldReceive('update')
            ->once()
            ->andReturnNull();

        // When
        $command = new UpdateEmployeeCommandHandler(
            new EmployeeUpdator(
                $this->employeeRepository()
            )
        );

        $command(new UpdateEmployeeCommand(
            $employee->id()->value(),
            $employee->name()->value(),
            $employee->email()->value(),
        ));
    }
}
