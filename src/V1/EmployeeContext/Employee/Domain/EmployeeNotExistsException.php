<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Domain;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class EmployeeNotExistsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The employee not exist', Response::HTTP_NOT_FOUND);
    }

    public function render($request)
    {
        return new JsonResponse($this->getMessage(), $this->getCode());
    }
}
