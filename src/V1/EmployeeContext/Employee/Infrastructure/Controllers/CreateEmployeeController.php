<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\CreateEmployee\CreateEmployeeCommand;
use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Infrastructure\Responses\EmployeeResponseInterface;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CreateEmployeeController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface   $queryBus
    )
    {
    }

    public function __invoke(
        Request $request
    ): Employee
    {
        $employeeId = EmployeeId::make();

        return $this->commandBus->execute(
            new CreateEmployeeCommand(
                $employeeId->id,
                $request->get('name'),
                $request->get('email'),
            )
        );
    }
}
