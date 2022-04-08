<?php

use Api\V1\EmployeeContext\Infrastructure\Controllers\CreateEmployeeController;
use Api\V1\EmployeeContext\Infrastructure\Controllers\DeleteEmployeeController;
use Api\V1\EmployeeContext\Infrastructure\Controllers\FindEmployeeController;
use Api\V1\EmployeeContext\Infrastructure\Controllers\GetAllEmployeesController;
use Api\V1\EmployeeContext\Infrastructure\Controllers\UpdateEmployeeController;
use Api\V1\WorkEntryContext\Infrastructure\Controllers\CreateWorkEntryController;
use Api\V1\WorkEntryContext\Infrastructure\Controllers\SearchWorkEntriesController;
use Illuminate\Support\Facades\Route;

/**
 * Employee API
 */
Route::get(uri: '/employees', action: GetAllEmployeesController::class);

Route::post(uri: '/employees', action: CreateEmployeeController::class);

Route::get(uri: '/employees/{employeeId}', action: FindEmployeeController::class);

Route::put(uri: '/employees/{employeeId}', action: UpdateEmployeeController::class);

Route::delete(uri: '/employees/{employeeId}', action: DeleteEmployeeController::class);

/**
 * Work Entries API
 */
Route::get(uri: '/employees/{employeeId}/workentries', action: SearchWorkEntriesController::class);

Route::post(uri: '/employees/{employeeId}/workentries', action: CreateWorkEntryController::class);