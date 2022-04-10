<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers\CreateWorkEntryController;
use App\Http\Requests\Api\V1\WorkEntries\CreateWorkEntryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class PostEmployeeWorkEntryController
{
    public function __construct(
        private CreateWorkEntryController $controller
    )
    {
    }

    public function __invoke(
        CreateWorkEntryRequest $request,
        string $employeeId,
    ): JsonResponse
    {
        /** @var WorkEntry $response */
        $response = $this->controller->__invoke($request, $employeeId);

        return new JsonResponse(
            ['data' => $response->toPrimitives()],
            status: Response::HTTP_CREATED
        );
    }
}
