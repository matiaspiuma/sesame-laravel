<?php

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers\FindWorkEntryByIdController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetEmployeeWorkEntryController extends Controller
{
    public function __construct(
        private FindWorkEntryByIdController $controller
    )
    {
    }

    public function __invoke(
        Request $request,
        string $employeeId,
        string $workEntryId
    ): JsonResponse
    {
        /** @var WorkEntry $response */
        $response = $this->controller->__invoke($request, $employeeId, $workEntryId);

        return new JsonResponse([
            'data' => $response->toPrimitives()
        ]);
    }
}
