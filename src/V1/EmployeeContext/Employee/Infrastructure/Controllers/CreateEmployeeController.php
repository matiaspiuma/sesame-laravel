<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\CreateEmployee\CreateEmployeeCommand;
use Api\V1\EmployeeContext\Employee\Application\FindEmployeeById\FindEmployeeByIdQuery;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use App\Http\Requests\Api\V1\Employees\CreateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

final class CreateEmployeeController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) {
    }
    public function __invoke(
        CreateEmployeeRequest $request
    ): JsonResponse {
        $employeeId = Uuid::v4()->toRfc4122();

        $this->commandBus->execute(
            command: new CreateEmployeeCommand(
                id: $employeeId,
                name: $request->name,
                email: $request->email,
            )
        );

        return new JsonResponse(
            data: new EmployeeResource(
                resource: $this->queryBus->execute(
                    query: new FindEmployeeByIdQuery(
                        id: $employeeId
                    )
                )
            ),
            status: Response::HTTP_CREATED
        );
    }
}
