<?php

use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\DeleteEmployeeController;
use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\GetEmployeeController;
use Api\V1\EmployeeContext\Employee\Infrastructure\Controllers\GetEmployeesController;
use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers\DeleteWorkEntryController;
use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers\GetWorkEntriesController;
use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers\GetWorkEntryController;
use Illuminate\Support\Facades\Route;

/**
 * Employee API
 */
Route::get('/employees', GetEmployeesController::class);

Route::get('/employees/{employeeId}', GetEmployeeController::class);

Route::post('/employees', \App\Http\Controllers\PostEmployeeController::class);

Route::put('/employees/{employeeId}', \App\Http\Controllers\PutEmployeeController::class);

Route::delete('/employees/{employeeId}', DeleteEmployeeController::class);

/**
 * Work Entries API
 */
Route::get('/employees/{employeeId}/workentries', GetWorkEntriesController::class);

Route::get('/employees/{employeeId}/workentries/{workEntryId}', GetWorkEntryController::class);

Route::post('/employees/{employeeId}/workentries', \App\Http\Controllers\PostEmployeeWorkEntryController::class);

Route::put('/employees/{employeeId}/workentries/{workEntryId}', \App\Http\Controllers\PutEmployeeWorkEntryController::class);

Route::delete('/employees/{employeeId}/workentries/{workEntryId}', DeleteWorkEntryController::class);
