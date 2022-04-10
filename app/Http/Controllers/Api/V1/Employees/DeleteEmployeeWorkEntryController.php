<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Employees;

use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers\DeleteWorkEntryController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DeleteEmployeeWorkEntryController
{
    public function __construct(
        private DeleteWorkEntryController $controller
    )
    {
    }

    public function __invoke(
        Request $request,
        string $employeeId,
        string $workEntryId,
    ): JsonResponse
    {
        $this->controller->__invoke($request, $employeeId, $workEntryId);

        return new JsonResponse(
            null,
            status: Response::HTTP_NO_CONTENT
        );
    }
}
