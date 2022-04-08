<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Infrastructure\Controllers;

use Api\V1\WorkEntryContext\Application\DeleteWorkEntry\DeleteWorkEntryCommand;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DeleteWorkEntryController
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }
    public function __invoke(
        string $employeeId,
        string $workEntryId
    ): JsonResponse {
        try {
            $this->commandBus->execute(
                new DeleteWorkEntryCommand(
                    id: $workEntryId
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
