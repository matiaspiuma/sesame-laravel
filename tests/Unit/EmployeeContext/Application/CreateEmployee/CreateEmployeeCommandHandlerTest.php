<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\Application\CreateEmployee;

use Api\V1\EmployeeContext\Application\CreateEmployee\CreateEmployeeCommand;
use Api\V1\EmployeeContext\Application\CreateEmployee\CreateEmployeeCommandHandler;
use Api\V1\EmployeeContext\Application\CreateEmployee\EmployeeCreator;
use Tests\TestCase;

final class CreateEmployeeCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_create_an_employee(): void
    {
        // Given
        $employee = $this->makeAnEmployee();

        $this->employeeRepository()
            ->shouldReceive('create')
            ->once()
            ->andReturnNull();

        // When
        $commad = new CreateEmployeeCommandHandler(
            employeeCreator: new EmployeeCreator(
                $this->employeeRepository()
            )
        );

        $commad(new CreateEmployeeCommand(
            $employee['id'],
            $employee['name'],
            $employee['email'],
        ));
    }
}
