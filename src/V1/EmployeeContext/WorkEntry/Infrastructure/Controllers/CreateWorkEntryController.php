<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\FindEmployeeById\FindEmployeeByIdQuery;
use Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry\CreateWorkEntryCommand;
use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntry\FindWorkEntryQuery;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use App\Http\Requests\Api\V1\EmployeeContext\WorkEntry\Infrastructure\Requests\CreateWorkEntryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CreateWorkEntryController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus
    ) {
    }
    public function __invoke(
        CreateWorkEntryRequest $request,
        string $employeeId
    ): JsonResponse {
        /** @var \Api\V1\EmployeeContext\Employee\Domain\Employee */
        $employee = $this->queryBus->execute(
            query: new FindEmployeeByIdQuery(
                id: $employeeId
            )
        );

        $workEntryId = WorkEntryId::make();

        $this->commandBus->execute(
            new CreateWorkEntryCommand(
                id: $workEntryId->id,
                startDate: $request->startDate,
                endDate: $request->endDate,
                employeeId: $employee->id
            )
        );

        $workEntry = $this->queryBus->execute(
            new FindWorkEntryQuery(
                id: $workEntryId->id
            )
        );

        return new JsonResponse(
            data: [
                'data' => new WorkEntryResource(
                    resource: $workEntry
                )
            ],
            status: Response::HTTP_CREATED
        );
    }
}
