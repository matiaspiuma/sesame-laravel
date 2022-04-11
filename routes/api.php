<?php

use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\SearchEmployeesController;
use Illuminate\Support\Facades\Route;

/**
 * Employee API
 */
Route::get('/employees', SearchEmployeesController::class);

Route::get('/employees/{employeeId}', \App\Http\Controllers\Api\V1\Employees\GetEmployeeController::class);

Route::post('/employees', \App\Http\Controllers\Api\V1\Employees\PostEmployeeController::class);

Route::put('/employees/{employeeId}', \App\Http\Controllers\Api\V1\Employees\PutEmployeeController::class);

Route::delete('/employees/{employeeId}', \App\Http\Controllers\Api\V1\Employees\DeleteEmployeeController::class);

/**
 * Work Entries API
 */
Route::get('/employees/{employeeId}/workentries', \App\Http\Controllers\Api\V1\Employees\GetEmployeeWorkEntriesController::class);

Route::get('/employees/{employeeId}/workentries/{workEntryId}', \App\Http\Controllers\Api\V1\Employees\GetEmployeeWorkEntryController::class);

Route::post('/employees/{employeeId}/workentries', \App\Http\Controllers\Api\V1\Employees\PostEmployeeWorkEntryController::class);

Route::put('/employees/{employeeId}/workentries/{workEntryId}', \App\Http\Controllers\Api\V1\Employees\PutEmployeeWorkEntryController::class);

Route::delete('/employees/{employeeId}/workentries/{workEntryId}', \App\Http\Controllers\Api\V1\Employees\DeleteEmployeeWorkEntryController::class);
