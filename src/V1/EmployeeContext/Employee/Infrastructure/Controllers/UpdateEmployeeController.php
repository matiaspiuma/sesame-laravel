<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\UpdateEmployee\UpdateEmployeeCommand;
use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UpdateEmployeeController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface   $queryBus
    )
    {
    }

    public function __invoke(
        Request $request,
        string  $employeeId
    ): JsonResponse
    {
        /** @var Employee $employee */
        $employee = $this->commandBus->execute(
            command: new UpdateEmployeeCommand(
                id: $employeeId,
                name: $request->name,
                email: $request->email
            )
        );

        return (new EmployeeResponse(
            data: $employee->toPrimitives(),
            status: Response::HTTP_OK
        ))->response();
    }
}
