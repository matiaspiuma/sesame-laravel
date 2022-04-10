<?php

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\FindEmployeeByIdController;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetEmployeeController extends Controller
{
    public function __construct(
        private FindEmployeeByIdController $controller
    )
    {
    }

    public function __invoke(
        Request $request,
        string $employeeId
    ): JsonResponse
    {
        /** @var Employee $response */
        $response = $this->controller->__invoke($request, $employeeId);

        return new JsonResponse([
            'data' => $response->toPrimitives()
        ]);
    }
}
