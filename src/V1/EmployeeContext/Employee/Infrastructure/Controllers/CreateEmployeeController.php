<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\CreateEmployee\CreateEmployeeCommand;
use Api\V1\EmployeeContext\Employee\Application\FindEmployeeById\FindEmployeeByIdQuery;
use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Infrastructure\Responses\EmployeeResponseInterface;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        Request $request
    ): JsonResponse
    {
        $employeeId = EmployeeId::make();

        $this->commandBus->execute(
            new CreateEmployeeCommand(
                $employeeId->id,
                $request->get('name'),
                $request->get('email'),
            )
        );

        /** @var Employee $response */
        $response = $this->queryBus->execute(
            new FindEmployeeByIdQuery($employeeId->value())
        );

        return new JsonResponse(
            ['data' => $response->toPrimitives()],
            status: Response::HTTP_CREATED
        );
    }
}
