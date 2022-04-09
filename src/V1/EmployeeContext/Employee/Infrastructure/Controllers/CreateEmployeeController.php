<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\CreateEmployee\CreateEmployeeCommand;
use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Infrastructure\Responses\EmployeeResponse;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use App\Http\Requests\Api\V1\EmployeeContext\Employee\Infrastructure\Requests\CreateEmployeeRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CreateEmployeeController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface   $queryBus
    )
    {
    }

    public function __invoke(
        CreateEmployeeRequest $request
    ): JsonResponse
    {
        $employeeId = EmployeeId::make();

        /** @var Employee $employee */
        $employee = $this->commandBus->execute(
            command: new CreateEmployeeCommand(
                id: $employeeId->id,
                name: $request->name,
                email: $request->email,
            )
        );

        return (new EmployeeResponse(
            employee: $employee,
            status: Response::HTTP_CREATED
        ))->response();
    }
}
