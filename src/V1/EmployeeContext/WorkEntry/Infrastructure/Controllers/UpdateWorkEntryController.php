<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntry\FindWorkEntryQuery;
use Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry\UpdateWorkEntryCommand;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UpdateWorkEntryController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) {
    }
    public function __invoke(
        Request $request,
        string $employeeId,
        string $workEntryId
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
            $this->commandBus->execute(
                new UpdateWorkEntryCommand(
                    id: $workEntryId,
                    startDate: $validator->validated()['startDate'],
                    endDate: $validator->validated()['endDate']
                )
            );

            /** @var \Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry */
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
