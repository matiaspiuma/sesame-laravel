<?php

namespace Tests;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Mockery\MockInterface;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;

    private $employeeRepository;

    private $workEntryRepository;

    protected function makeEmployee($persist = false, $deleted = false): Employee
    {
        $employee = Employee::fromPrimitives(
            $this->faker->uuid(),
            $this->faker->name(),
            $this->faker->unique()->safeEmail(),
            now()->format('Y-m-d H:i:s'),
            now()->format('Y-m-d H:i:s'),
        );

        if ($persist) {
            $this->persistEmployee($employee, $deleted);
        }

        return $employee;
    }

    protected function persistEmployee(Employee $employee, bool $deleted = false): void
    {
        DB::insert('INSERT INTO employees (id, name, email, createdAt, updatedAt, deletedAt) VALUES (?, ?, ?, ?, ?, ?)', [
            $employee->id()->value(),
            $employee->name()->value(),
            $employee->email()->value(),
            now(),
            now(),
            $deleted ? now() : null,
        ]);
    }

    protected function makeWorkEntry($persist = false, $deleted = false): WorkEntry
    {
        $employee = $this->makeEmployee();

        if ($persist) {
            $this->persistEmployee($employee);
        }

        $entry = $this->faker->dateTimeBetween('-1 years', 'now');

        $workEntry = WorkEntry::fromPrimitives(
            $this->faker->uuid(),
            $employee->id()->value(),
            $entry->format('Y-m-d H:i:s'),
            now()->format('Y-m-d H:i:s'),
            now()->format('Y-m-d H:i:s'),
            $entry->add(
                \DateInterval::createFromDateString(
                    $this->faker->numberBetween(60, 600) . ' minutes'
                )
            )->format('Y-m-d H:i:s'),
        );

        if ($persist) {
            DB::insert('INSERT INTO work_entries (id, employeeId, startDate, endDate, createdAt, updatedAt, deletedAt)
            VALUES (?, ?, ?, ?, ?, ?, ?)', [
                $workEntry->id()->value(),
                $workEntry->employeeId()->value(),
                $workEntry->startDate()->value(),
                $workEntry->endDate()->value(),
                $workEntry->createdAt()->value(),
                $workEntry->updatedAt()->value(),
                $deleted ? now() : null,
            ]);
        }

        return $workEntry;
    }

    protected function employeeRepository(): EmployeeRepository|MockInterface|null
    {
        if ($this->employeeRepository === null) {
            $this->employeeRepository = $this->mock(EmployeeRepository::class);
        }

        return $this->employeeRepository;
    }

    protected function workEntryRepository(): WorkEntryRepository|MockInterface|null
    {
        if ($this->workEntryRepository === null) {
            $this->workEntryRepository = $this->mock(WorkEntryRepository::class);
        }

        return $this->workEntryRepository;
    }
}
