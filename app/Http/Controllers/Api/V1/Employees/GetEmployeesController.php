<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\Employee\Domain\Employees;
use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\SearchEmployeesController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class GetEmployeesController
{
    public function __construct(
        private SearchEmployeesController $controller
    )
    {
    }

    public function __invoke(
        Request $request
    ): JsonResponse
    {
        /** @var Employees $response */
        $response = $this->controller->__invoke($request);

        return new JsonResponse([
            'data' => $response->toPrimitives()
        ]);
    }
}
