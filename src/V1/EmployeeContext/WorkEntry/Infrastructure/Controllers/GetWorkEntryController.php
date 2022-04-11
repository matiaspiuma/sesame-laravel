<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntryById\FindWorkEntryByIdAndEmployeeIdQuery;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetWorkEntryController
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(
        string  $employeeId,
        string  $workEntryId
    ): JsonResponse
    {
        /** @var WorkEntry $response */
        $response = $this->queryBus->execute(
            new FindWorkEntryByIdAndEmployeeIdQuery($workEntryId, $employeeId)
        );

        return new JsonResponse([
            'data' => $response->toPrimitives()
        ]);
    }
}
