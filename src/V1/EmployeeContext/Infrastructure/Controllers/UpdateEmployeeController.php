<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Application\FindEmployee\FindEmployeeQuery;
use Api\V1\EmployeeContext\Application\UpdateEmployee\UpdateEmployeeCommand;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UpdateEmployeeController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) {
    }
    public function __invoke(
        Request $request,
        string $employeeId
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
            $this->commandBus->execute(
                new UpdateEmployeeCommand(
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
                status: Response::HTTP_OK
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
