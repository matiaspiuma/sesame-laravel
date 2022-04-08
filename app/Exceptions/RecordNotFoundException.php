<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RecordNotFoundException extends Exception
{
    public function render($request)
    {
        return new JsonResponse(
            data: [
                'error' => 'Record not found',
            ],
            status: Response::HTTP_NOT_FOUND
        );
    }
}
