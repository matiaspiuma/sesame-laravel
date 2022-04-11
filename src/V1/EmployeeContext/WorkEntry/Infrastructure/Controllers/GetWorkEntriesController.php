<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\WorkEntry\Application\FindAllWorkEntriesByEmployeeId\FindAllWorkEntriesByEmployeeIdQuery;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntries;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetWorkEntriesController
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(
        string  $employeeId,
    ): JsonResponse
    {
        /** @var WorkEntries $response */
        $response = $this->queryBus->execute(
            new FindAllWorkEntriesByEmployeeIdQuery($employeeId)
        );

        return new JsonResponse([
            'data' => $response->toPrimitives()
        ]);
    }
}
