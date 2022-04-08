<?php

use Api\V1\EmployeeContext\Infrastructure\Controllers\GetAllEmployeesController;
use Illuminate\Support\Facades\Route;

Route::get('/employees', GetAllEmployeesController::class);
