<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Infrastructure\Controllers;

use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Api\V1\WorkEntryContext\Application\CreateWorkEntry\CreateWorkEntryCommand;
use Api\V1\WorkEntryContext\Application\FindWorkEntry\FindWorkEntryQuery;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;

final class CreateWorkEntryController
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
                'startDate' => $request->get('startDate'),
                'endDate' => $request->get('endDate'),
            ],
            [
                'startDate' => 'required|date|before:now',
                'endDate' => 'required|date|after:startDate',
            ]
        );

        if ($validator->fails()) {
            return new JsonResponse(
                data: $validator->errors(),
                status: Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $workEntryId = Uuid::v4()->toRfc4122();

            $this->commandBus->execute(
                new CreateWorkEntryCommand(
                    id: $workEntryId,
                    employeeId: $employeeId,
                    startDate: $validator->validated()['startDate'],
                    endDate: $validator->validated()['endDate']
                )
            );

            $workEntry = $this->queryBus->execute(
                new FindWorkEntryQuery(
                    id: $workEntryId
                )
            );

            return new JsonResponse(
                data: [
                    'data' => $workEntry->toPrimitives(),
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
