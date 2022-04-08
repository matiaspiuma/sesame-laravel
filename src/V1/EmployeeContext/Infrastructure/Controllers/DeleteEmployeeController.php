<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Application\DeleteEmployee\DeleteEmployeeCommand;
use Api\V1\EmployeeContext\Application\FindEmployee\FindEmployeeQuery;
use Api\V1\EmployeeContext\Application\UpdateEmployee\UpdateEmployeeCommand;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DeleteEmployeeController
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }
    public function __invoke(
        string $employeeId
    ): JsonResponse {
        try {
            $this->commandBus->execute(
                new DeleteEmployeeCommand(
                    id: $employeeId
                )
            );

            return new JsonResponse(
                data: null,
                status: Response::HTTP_NO_CONTENT
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
