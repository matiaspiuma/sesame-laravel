<?php

declare(strict_types=1);

namespace Tests\Feature\WorkEntryContext\Infrastructure\Persistence;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\WorkEntryContext\Infrastructure\Persistence\EloquentWorkEntryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EloquentWorkEntryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_find_all_work_entries_by_employee_id(): void
    {
        // Given
        $workEntry = $this->createAnWorkEntry();

        // When
        $workEntries = (new EloquentWorkEntryRepository)->findAllByEmployeeId(
            employeeId: new EmployeeId($workEntry['employee_id'])
        );

        // Then
        $this->assertCount(1, $workEntries);
    }

    /** @test */
    public function it_should_create_an_employee(): void
    {
        // Given
        $workEntry = $this->makeAnWorkEntry(asObject: true);

        // When
        (new EloquentWorkEntryRepository)->create(workEntry: $workEntry);

        // Then
        $this->assertDatabaseHas('work_entries', [
            'id' => $workEntry->id()->value(),
            'start_date' => (string) $workEntry->startDate(),
            'end_date' => (string) $workEntry->endDate(),
            'created_at' => (string) $workEntry->createdAt(),
            'updated_at' => (string) $workEntry->updatedAt(),
        ]);
    }

    /** @test */
    public function it_should_find_an_work_entry_by_id(): void
    {
        // Given
        $workEntry = $this->createAnWorkEntry(asObject: true);

        // When
        $workEntryFound = (new EloquentWorkEntryRepository)
            ->findById(workEntryId: $workEntry->id());

        // Then
        $this->assertEquals(
            expected: $workEntry->id(),
            actual: $workEntryFound->id()
        );
    }

    /** @test */
    public function it_should_not_find_an_work_entry_by_id(): void
    {
        // Given
        $workEntry = $this->makeAnWorkEntry(asObject: true);

        $this->expectException('\Symfony\Component\HttpKernel\Exception\NotFoundHttpException');

        // When
        $workEntryFound = (new EloquentWorkEntryRepository)
            ->findById(workEntryId: $workEntry->id());

        // Then
        $this->assertNull($workEntryFound);
    }

    /** @test */
    public function it_should_not_find_an_workEntry_by_id_when_deleted(): void
    {
        // Given
        $workEntry = $this->createAnWorkEntry(
            deleted: true,
            asObject: true
        );
        $this->expectException('\Symfony\Component\HttpKernel\Exception\NotFoundHttpException');

        // When

        $result = (new EloquentWorkEntryRepository)
            ->findById(workEntryId: $workEntry->id());

        // Then
    }

    /** @test */
    public function it_should_update_an_work_entry(): void
    {
        // Given
        $workEntry = $this->createAnWorkEntry(
            asObject: true
        );
        $workEntry->update(
            startDate: new WorkEntryStartDate(value: new \DateTimeImmutable()),
            endDate: new WorkEntryEndDate(value: new \DateTimeImmutable())
        );

        // When
        (new EloquentWorkEntryRepository)->update(
            workEntry: $workEntry
        );

        // Then
        $this->assertDatabaseHas('work_entries', [
            'id' => $workEntry->id()->value(),
            'employee_id' => $workEntry->employeeId()->value(),
            'start_date' => (string) $workEntry->startDate(),
            'end_date' => (string) $workEntry->endDate(),
            'created_at' => (string) $workEntry->createdAt(),
            'updated_at' => (string) $workEntry->updatedAt(),
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function it_should_delete_an_work_entry(): void
    {
        // Given
        $workEntry = $this->createAnWorkEntry(
            deleted: true,
            asObject: true
        );
        $workEntry->delete();

        // When
        (new EloquentWorkEntryRepository)->delete(
            workEntry: $workEntry
        );

        // Then
        $this->assertDatabaseHas('work_entries', [
            'id' => $workEntry->id()->value(),
            'employee_id' => $workEntry->employeeId()->value(),
            'start_date' => (string) $workEntry->startDate(),
            'end_date' => (string) $workEntry->endDate(),
            'created_at' => (string) $workEntry->createdAt(),
            'updated_at' => (string) $workEntry->updatedAt(),
            'deleted_at' => (string) $workEntry->deletedAt(),
        ]);
    }
}
