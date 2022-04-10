<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\UpdateEmployeeByIdController;
use App\Http\Requests\Api\V1\Employees\UpdateEmployeeRequest;
use App\Models\Employee;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class PutEmployeeController
{
    public function __construct(
        private UpdateEmployeeByIdController $controller
    )
    {
    }

    public function __invoke(
        UpdateEmployeeRequest $request,
        string $employeeId
    ): JsonResponse
    {
        /** @var Employee $employee */
        $response = $this->controller->__invoke($request, $employeeId);

        return new JsonResponse(
            ['data' => $response->toPrimitives()],
            status: Response::HTTP_OK
        );
    }
}
