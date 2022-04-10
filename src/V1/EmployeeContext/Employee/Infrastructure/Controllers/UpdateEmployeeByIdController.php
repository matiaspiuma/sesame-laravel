<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\UpdateEmployee\UpdateEmployeeCommand;
use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Request;

final class UpdateEmployeeByIdController
{
    public function __construct(
        private CommandBusInterface $commandBus,
    )
    {
    }

    public function __invoke(
        Request $request,
        string  $employeeId
    ): Employee
    {
        return $this->commandBus->execute(
            new UpdateEmployeeCommand(
                $employeeId,
                $request->get('name'),
                $request->get('email')
            )
        );
    }
}
