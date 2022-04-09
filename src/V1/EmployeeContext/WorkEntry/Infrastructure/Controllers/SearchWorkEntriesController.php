<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\WorkEntry\Application\FindAllWorkEntriesByEmployeeId\FindAllWorkEntriesByEmployeeIdQuery;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SearchWorkEntriesController
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(
        string $employeeId,
    ): JsonResponse {
        $workEntries = $this->queryBus->execute(
            query: new FindAllWorkEntriesByEmployeeIdQuery(
                employeeId: $employeeId,
            )
        );

        return new JsonResponse(
            data: [
                'data' => \array_map(
                    fn (WorkEntry $workEntry): array => $workEntry->toPrimitives(),
                    $workEntries
                ),
                'meta' => []
            ],
            status: Response::HTTP_OK
        );
    }
}
