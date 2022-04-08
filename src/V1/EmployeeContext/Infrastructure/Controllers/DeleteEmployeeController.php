<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Application\DeleteEmployee\DeleteEmployeeCommand;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
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
        $this->commandBus->execute(
            command: new DeleteEmployeeCommand(
                id: $employeeId
            )
        );

        return new JsonResponse(
            data: null,
            status: Response::HTTP_NO_CONTENT
        );
    }
}
