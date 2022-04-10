<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\CreateEmployeeController;
use App\Http\Requests\Api\V1\Employees\CreateEmployeeRequest;
use App\Models\Employee;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class PostEmployeeController
{
    public function __construct(
        private CreateEmployeeController $controller
    )
    {
    }

    public function __invoke(
        CreateEmployeeRequest $request
    ): JsonResponse
    {
        /** @var Employee $response */
        $response = $this->controller->__invoke($request);

        return new JsonResponse(
            ['data' => $response->toPrimitives()],
            status: Response::HTTP_CREATED
        );
    }
}
