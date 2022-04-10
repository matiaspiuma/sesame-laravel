<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Employee\Application\DeleteEmployee;

use Api\V1\EmployeeContext\Employee\Application\DeleteEmployee\DeleteEmployeeCommand;
use Api\V1\EmployeeContext\Employee\Application\DeleteEmployee\DeleteEmployeeCommandHandler;
use Api\V1\EmployeeContext\Employee\Application\DeleteEmployee\EmployeeDeletor;
use Tests\TestCase;

final class DeleteEmployeeCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_delete_an_employee(): void
    {
        // Given
        $employee = $this->makeEmployee();

        $this->employeeRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn($employee);

        $this->employeeRepository()
            ->shouldReceive('delete')
            ->once()
            ->andReturnNull();

        // When
        $command = new DeleteEmployeeCommandHandler(
            new EmployeeDeletor(
                $this->employeeRepository()
            )
        );

        $command(new DeleteEmployeeCommand(
            $employee->id()->value()
        ));
    }
}
