<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Infrastructure\Controllers;

use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Api\V1\WorkEntryContext\Application\FindAllWorkEntriesByEmployeeId\FindAllWorkEntriesByEmployeeIdQuery;
use Api\V1\WorkEntryContext\Domain\WorkEntry;
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
