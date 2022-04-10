<?php

namespace App\Exceptions;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeNotExistsException;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryNotExistsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /** @var array<int, class-string<Throwable>> */
    protected $dontReport = [
        //
    ];

    /** @var array<int, string> */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($e instanceof EmployeeNotExistsException) {
                return true;
            }
            if ($e instanceof WorkEntryNotExistsException) {
                return true;
            }
        });
    }
}
