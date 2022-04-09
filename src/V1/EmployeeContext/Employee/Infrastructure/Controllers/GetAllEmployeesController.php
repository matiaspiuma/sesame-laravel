<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\SearchEmployees\SearchEmployeesQuery;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeCollection;
use Api\V1\EmployeeContext\Employee\Infrastructure\Responses\EmployeesResponse;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use App\Http\Resources\EmployeeResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetAllEmployeesController
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        /** @var EmployeeCollection $employees */
        $employees = $this->queryBus->execute(
            query: new SearchEmployeesQuery()
        );

        return (new EmployeesResponse(
            employees: $employees,
            status: Response::HTTP_OK
        ))->response();
    }
}
