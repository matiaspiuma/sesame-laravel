<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Application\CreateEmployee\CreateEmployeeCommand;
use Api\V1\EmployeeContext\Application\FindEmployee\FindEmployeeQuery;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        Request $request
    ): JsonResponse {
        $validator = Validator::make(
            [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
            ],
            [
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100',
            ]
        );

        if ($validator->fails()) {
            return new JsonResponse(
                data: $validator->errors(),
                status: Response::HTTP_BAD_REQUEST
            );
        }

        try {

            $employeeId = Uuid::v4()->toRfc4122();

            $this->commandBus->execute(
                new CreateEmployeeCommand(
                    id: $employeeId,
                    name: $validator->validated()['name'],
                    email: $validator->validated()['email']
                )
            );

            $employee = $this->queryBus->execute(
                new FindEmployeeQuery(
                    id: $employeeId
                )
            );

            return new JsonResponse(
                data: [
                    'data' => $employee->toPrimitives(),
                    'meta' => []
                ],
                status: Response::HTTP_CREATED
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                data: [
                    'message' => $exception->getMessage()
                ],
                status: Response::HTTP_BAD_REQUEST
            );
        }
    }
}
