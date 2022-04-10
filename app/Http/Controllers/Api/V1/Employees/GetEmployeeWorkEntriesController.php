<?php

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntries;
use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers\FindWorkEntriesByEmployeeIdController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetEmployeeWorkEntriesController extends Controller
{
    public function __construct(
        private FindWorkEntriesByEmployeeIdController $controller
    )
    {
    }

    public function __invoke(
        Request $request,
        string $employeeId
    ): JsonResponse
    {
        /** @var WorkEntries $response */
        $response = $this->controller->__invoke($request, $employeeId);

        return new JsonResponse([
            'data' => $response->toPrimitives()
        ]);
    }
}
