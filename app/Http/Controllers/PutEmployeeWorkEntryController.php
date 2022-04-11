<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers\UpdateWorkEntryController;
use App\Http\Requests\Api\V1\WorkEntries\UpdateWorkEntryRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class PutEmployeeWorkEntryController
{
    public function __construct(
        private UpdateWorkEntryController $controller
    )
    {
    }

    public function __invoke(
        UpdateWorkEntryRequest $request,
        string $employeeId,
        string $workEntryId
    ): JsonResponse
    {
        /** @var WorkEntry $response */
        $response = $this->controller->__invoke($request, $employeeId, $workEntryId);

        return new JsonResponse(
            ['data' => $response->toPrimitives()],
            status: Response::HTTP_OK
        );
    }
}
