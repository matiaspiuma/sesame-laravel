<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Application\FindEmployeeById\FindEmployeeByIdQuery;
use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetEmployeeController
{
    public function __construct(
        private QueryBusInterface $queryBus
    )
    {
    }

    public function __invoke(
        string  $employeeId
    ): JsonResponse
    {
        /** @var Employee $reponse */
        $response = $this->queryBus->execute(
            new FindEmployeeByIdQuery($employeeId)
        );

        return new JsonResponse([
            'data' => $response->toPrimitives(),
            Response::HTTP_OK
        ]);
    }
}
