<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\WorkEntry\Application\DeleteWorkEntry\DeleteWorkEntryCommand;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DeleteWorkEntryController
{
    public function __construct(
        private CommandBusInterface $commandBus
    )
    {
    }

    public function __invoke(
        string  $employeeId,
        string  $workEntryId
    ): JsonResponse
    {
        $this->commandBus->execute(
            new DeleteWorkEntryCommand($workEntryId, $employeeId)
        );

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
