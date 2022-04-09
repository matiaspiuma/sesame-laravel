<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Application\SearchEmployees\SearchEmployeesQuery;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use App\Http\Resources\EmployeeResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetAllEmployeesController
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $employees = $this->queryBus->execute(
            query: new SearchEmployeesQuery()
        );

        return new JsonResponse(
            data: [
                'data' => EmployeeResource::collection(
                    resource: $employees
                ),
                'meta' => []
            ],
            status: Response::HTTP_OK
        );
    }
}
