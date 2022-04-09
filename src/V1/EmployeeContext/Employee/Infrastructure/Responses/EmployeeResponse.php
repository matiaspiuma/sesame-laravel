<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Infrastructure\Responses;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Symfony\Component\HttpFoundation\JsonResponse;

final class EmployeeResponse
{
    public function __construct(
        private Employee $employee,
        private int      $status = 200
    )
    {
    }

    public function response()
    {
        return new JsonResponse(
            data: [
                'data' => $this->employee->toPrimitives(),
            ],
            status: $this->status
        );
    }
}
