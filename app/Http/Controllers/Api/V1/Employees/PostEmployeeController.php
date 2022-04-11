<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\CreateEmployeeController;
use App\Http\Requests\Api\V1\Employees\CreateEmployeeRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PostEmployeeController
{
    public function __invoke(
        CreateEmployeeRequest $request,
        CreateEmployeeController $controller
    ): JsonResponse
    {
        return $controller($request);
    }
}
