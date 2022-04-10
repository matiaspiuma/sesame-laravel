<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\DeleteEmployee\DeleteEmployeeCommand;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Request;

final class DeleteEmployeeByIdController
{
    public function __construct(
        private CommandBusInterface $commandBus
    )
    {
    }

    public function __invoke(
        Request $request,
        string  $employeeId
    ): void
    {
        $this->commandBus->execute(
            command: new DeleteEmployeeCommand(
                id: $employeeId
            )
        );
    }
}
