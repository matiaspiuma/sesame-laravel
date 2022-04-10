<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Employee\Application\CreateEmployee;

use Api\V1\EmployeeContext\Employee\Application\CreateEmployee\CreateEmployeeCommand;
use Api\V1\EmployeeContext\Employee\Application\CreateEmployee\CreateEmployeeCommandHandler;
use Api\V1\EmployeeContext\Employee\Application\CreateEmployee\EmployeeCreator;
use Tests\TestCase;

final class CreateEmployeeCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_create_an_employee(): void
    {
        // Given
        $employee = $this->makeEmployee();

        $this->employeeRepository()
            ->shouldReceive('create')
            ->once()
            ->andReturnNull();

        // When
        $command = new CreateEmployeeCommandHandler(
            new EmployeeCreator(
                $this->employeeRepository()
            )
        );

        $command(new CreateEmployeeCommand(
            $employee->id()->value(),
            $employee->name()->value(),
            $employee->email()->value(),
        ));
    }
}
