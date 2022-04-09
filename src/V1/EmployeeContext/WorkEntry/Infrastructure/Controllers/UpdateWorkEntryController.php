<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry\UpdateWorkEntryCommand;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use App\Http\Requests\Api\V1\EmployeeContext\WorkEntry\Infrastructure\Requests\UpdateWorkEntryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UpdateWorkEntryController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface   $queryBus
    )
    {
    }

    public function __invoke(
        UpdateWorkEntryRequest $request,
        string                 $employeeId,
        string                 $workEntryId
    ): JsonResponse
    {
        /** @var WorkEntry $workEntry */
        $workEntry = $this->commandBus->execute(
            command: new UpdateWorkEntryCommand(
                id: $workEntryId,
                startDate: $request->startDate,
                endDate: $request->endDate
            )
        );

        return new JsonResponse(
            data: [
                'data' => $workEntry->toPrimitives(),
                'meta' => []
            ],
            status: Response::HTTP_OK
        );
    }
}
