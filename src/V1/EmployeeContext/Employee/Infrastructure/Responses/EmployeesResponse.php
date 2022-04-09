<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Responses;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

final class EmployeesResponse
{
    public function __construct(
        private EmployeeCollection $employees,
        private int                $status = 200
    )
    {
    }

    public function response(): JsonResponse
    {
        return new JsonResponse(
            data: [
                'data' => $this->employees->toArray(),
            ],
            status: $this->status
        );
    }
}
