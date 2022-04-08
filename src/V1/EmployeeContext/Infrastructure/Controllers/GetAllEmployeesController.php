<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Application\SearchEmployees\SearchEmployeesQuery;
use Api\V1\EmployeeContext\Domain\Employee;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetAllEmployeesController
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(
        Request $request
    ): JsonResponse {
        $employees = $this->queryBus->execute(
            query: new SearchEmployeesQuery()
        );

        return new JsonResponse(
            data: [
                'data' => \array_map(
                    fn (Employee $employee): array => $employee->toPrimitives(),
                    $employees
                ),
                'meta' => []
            ],
            status: Response::HTTP_OK
        );
    }
}
