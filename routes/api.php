<?php

use Api\V1\EmployeeContext\Infrastructure\Controllers\CreateEmployeeController;
use Api\V1\EmployeeContext\Infrastructure\Controllers\GetAllEmployeesController;
use Illuminate\Support\Facades\Route;

Route::get(uri: '/employees', action: GetAllEmployeesController::class);

Route::post(uri: '/employees', action: CreateEmployeeController::class);
