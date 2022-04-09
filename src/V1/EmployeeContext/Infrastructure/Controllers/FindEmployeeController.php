<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Application\FindEmployee\FindEmployeeQuery;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use App\Http\Resources\EmployeeResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class FindEmployeeController
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }
    public function __invoke(
        string $employeeId
    ): JsonResponse {
        $employee = $this->queryBus->execute(
            new FindEmployeeQuery(
                id: $employeeId
            )
        );

        return new JsonResponse(
            data: [
                'data' => new EmployeeResource($employee),
            ],
            status: Response::HTTP_OK
        );
    }
}
