<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Application\DeleteEmployee;

use Api\V1\EmployeeContext\Application\DeleteEmployee\DeleteEmployeeCommand;
use Api\V1\EmployeeContext\Application\DeleteEmployee\DeleteEmployeeCommandHandler;
use Api\V1\EmployeeContext\Application\DeleteEmployee\EmployeeDeletor;
use Tests\TestCase;

final class DeleteEmployeeCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_delete_an_employee(): void
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
            ->shouldReceive('delete')
            ->once()
            ->andReturnNull();

        // When
        $commad = new DeleteEmployeeCommandHandler(
            delector: new EmployeeDeletor(
                $this->employeeRepository()
            )
        );

        $commad(new DeleteEmployeeCommand(
            $employee['id']
        ));
    }
}
