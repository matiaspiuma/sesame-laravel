<?php

namespace Tests;

use Api\V1\EmployeeContext\Domain\Employee;
use Api\V1\EmployeeContext\Domain\EmployeeRepository;
use Api\V1\WorkEntryContext\Domain\WorkEntry;
use Api\V1\WorkEntryContext\Domain\WorkEntryRepository;
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

    protected function makeAnEmployee(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }

    protected function makeAnEmployeeAsObject(?array $employee = null): Employee
    {
        $employee = $employee ?? $this->makeAnEmployee();

        return Employee::fromPrimitives(
            id: $employee['id'],
            name: $employee['name'],
            email: $employee['email'],
            createdAt: now(),
            updatedAt: now(),
        );
    }

    protected function createAnEmployee(bool $deleted = false): array
    {
        $employee = $this->makeAnEmployee();

        DB::insert('INSERT INTO employees (id, name, email, created_at, updated_at, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?)', [
            $employee['id'],
            $employee['name'],
            $employee['email'],
            now(),
            now(),
            $deleted ? now() : null,
        ]);

        return $employee;
    }

    protected function makeAnWorkEntry(
        ?array $employee = null,
        bool $asObject = false,
    ): array|WorkEntry {
        $employee = $employee ?? $this->makeAnEmployee();

        $entry = $this->faker->dateTimeBetween('-1 years', 'now');

        $workEntry = [
            'id' => $this->faker->uuid(),
            'employee_id' => $employee['id'],
            'startDate' => $entry->format('Y-m-d H:i:s'),
            'endDate' => $entry->add(
                \DateInterval::createFromDateString(
                    $this->faker->numberBetween(60, 600) . ' minutes'
                )
            )->format('Y-m-d H:i:s'),
        ];

        return $asObject
            ? $this->convertWorkEntryToObject($workEntry)
            : $workEntry;
    }

    protected function convertWorkEntryToObject(array $workEntry): WorkEntry
    {
        return WorkEntry::fromPrimitives(
            id: $workEntry['id'],
            employeeId: $workEntry['employee_id'],
            startDate: $workEntry['startDate'],
            endDate: $workEntry['endDate'],
            createdAt: now(),
            updatedAt: now(),
        );
    }

    protected function createAnWorkEntry(bool $deleted = false, bool $asObject = false): array|WorkEntry
    {
        $workEntry = $this->makeAnWorkEntry();

        DB::insert('INSERT INTO work_entries (id, employee_id, startDate, endDate, created_at, updated_at, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?)', [
            $workEntry['id'],
            $workEntry['employee_id'],
            $workEntry['startDate'],
            $workEntry['endDate'],
            now(),
            now(),
            $deleted ? now() : null,
        ]);

        return $asObject
            ? $this->convertWorkEntryToObject($workEntry)
            : $workEntry;
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
