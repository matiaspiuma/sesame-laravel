<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\DeleteEmployeeByIdController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DeleteEmployeeController
{
    public function __construct(
        private DeleteEmployeeByIdController $controller
    )
    {
    }

    public function __invoke(
        Request $request,
        string $employeeId,
    ): JsonResponse
    {
        $this->controller->__invoke($request, $employeeId);

        return new JsonResponse(
            null,
            status: Response::HTTP_NO_CONTENT
        );
    }
}
