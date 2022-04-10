<?php

declare(strict_types=1);

namespace Tests\Unit\EmployeeContext\WorkEntry\Application\CreateWorkEntry;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry\CreateWorkEntryCommand;
use Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry\CreateWorkEntryCommandHandler;
use Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry\WorkEntryCreator;
use Tests\TestCase;

final class CreateWorkEntryCommandHandlerTest extends TestCase
{
    /** @test */
    public function it_should_create_a_work_entry(): void
    {
        // Given
        $employee = $this->makeEmployee(false);
        $workEntry = $this->makeWorkEntry(false);

        $this->workEntryRepository()
            ->shouldReceive('create')
            ->once();

        $this->employeeRepository()
            ->shouldReceive('findById')
            ->once()
            ->andReturn($employee);

        // When
        $command = new CreateWorkEntryCommandHandler(
            new WorkEntryCreator(
                $this->workEntryRepository(),
                $this->employeeRepository()
            )
        );

        $command(new CreateWorkEntryCommand(
            $workEntry->id()->value(),
            $employee->id()->value(),
            (string)$workEntry->startDate(),
            (string)$workEntry->endDate()
        ));
    }
}
