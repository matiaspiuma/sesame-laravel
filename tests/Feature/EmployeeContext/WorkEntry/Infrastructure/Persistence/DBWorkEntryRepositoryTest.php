<?php

declare(strict_types=1);

namespace Tests\Feature\EmployeeContext\WorkEntry\Infrastructure\Persistence;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Persistence\DBWorkEntryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DBWorkEntryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_find_all_work_entries_by_employeeId(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry(true);

        // When
        $workEntries = (new DBWorkEntryRepository)->findAllByEmployeeId(
            $workEntry->employeeId(),
        );

        // Then
        $this->assertCount(1, $workEntries);
    }

    /** @test */
    public function it_should_create_an_work_entry(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry();

        // When
        (new DBWorkEntryRepository)->create($workEntry);

        // Then
        $this->assertDatabaseHas('work_entries', [
            'id' => $workEntry->id()->value(),
        ]);
    }

    /** @test */
    public function it_should_find_an_work_entry_by_id(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry(true);

        // When
        $workEntryFound = (new DBWorkEntryRepository)
            ->findByIdAndEmployeeId($workEntry->id(), $workEntry->employeeId());

        // Then
        $this->assertEquals($workEntry->id()->value(), $workEntryFound->id()->value());
    }

    /** @test */
    public function it_should_not_find_an_work_entry_by_id(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry();

        // When
        $workEntryFound = (new DBWorkEntryRepository)
            ->findByIdAndEmployeeId($workEntry->id(), $workEntry->employeeId());

        // Then
        $this->assertNull($workEntryFound);
    }

    /** @test */
    public function it_should_not_find_an_work_entry_by_id_when_deleted(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry(true, true);

        // When
        $workEntryFound = (new DBWorkEntryRepository)
            ->findByIdAndEmployeeId($workEntry->id(), $workEntry->employeeId());

        // Then
        $this->assertNull($workEntryFound);
    }

    /** @test */
    public function it_should_update_an_work_entry(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry(true);

        $workEntry->update(
            new WorkEntryStartDate(new \DateTimeImmutable()),
            new WorkEntryEndDate(new \DateTimeImmutable())
        );

        // When
        (new DBWorkEntryRepository)->update($workEntry);

        // Then
        $this->assertDatabaseHas('work_entries', [
            'id' => $workEntry->id(),
            'employeeId' => $workEntry->employeeId(),
            'startDate' => (string)$workEntry->startDate(),
            'endDate' => (string)$workEntry->endDate(),
            'createdAt' => (string)$workEntry->createdAt(),
            'updatedAt' => (string)$workEntry->updatedAt(),
            'deletedAt' => null,
        ]);
    }

    /** @test */
    public function it_should_delete_an_work_entry(): void
    {
        // Given
        $workEntry = $this->makeWorkEntry(true);
        $workEntry->delete();

        // When
        (new DBWorkEntryRepository)->delete($workEntry);

        // Then
        $this->assertDatabaseHas('work_entries', [
            'id' => $workEntry->id(),
            'employeeId' => $workEntry->employeeId(),
            'startDate' => (string)$workEntry->startDate(),
            'endDate' => (string)$workEntry->endDate(),
            'createdAt' => (string)$workEntry->createdAt(),
            'updatedAt' => (string)$workEntry->updatedAt(),
            'deletedAt' => (string)$workEntry->deletedAt(),
        ]);
    }
}
