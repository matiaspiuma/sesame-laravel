<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\PostEmployeeController as AppPostEmployeeController;
use App\Http\Requests\Api\V1\Employees\CreateEmployeeRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PostEmployeeController
{
    public function __invoke(
        CreateEmployeeRequest $request,
        AppPostEmployeeController $controller
    ): JsonResponse
    {
        return $controller($request);
    }
}
