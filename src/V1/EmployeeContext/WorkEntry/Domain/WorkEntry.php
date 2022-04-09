<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Domain;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryCreatedAt;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryDeletedAt;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryUpdatedAt;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class WorkEntry
{
    public function __construct(
        public                      readonly WorkEntryId $id,
        public                      readonly EmployeeId $employeeId,
        private WorkEntryStartDate  $startDate,
        private WorkEntryEndDate    $endDate,
        public                      readonly WorkEntryCreatedAt $createdAt,
        private WorkEntryUpdatedAt  $updatedAt,
        private ?WorkEntryDeletedAt $deletedAt = null
    )
    {
    }

    public static function create(
        WorkEntryId        $id,
        WorkEntryStartDate $startDate,
        WorkEntryEndDate   $endDate,
        EmployeeId         $employeeId,
    ): WorkEntry
    {
        $now = new \DateTimeImmutable();

        return new WorkEntry(
            id: $id,
            employeeId: $employeeId,
            startDate: $startDate,
            endDate: $endDate,
            createdAt: new WorkEntryCreatedAt(value: $now),
            updatedAt: new WorkEntryUpdatedAt(value: $now)
        );
    }

    public function update(
        WorkEntryStartDate $startDate,
        WorkEntryEndDate   $endDate,
    ): void
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->updatedAt = new WorkEntryUpdatedAt(
            value: new \DateTimeImmutable()
        );
    }

    public static function fromPrimitives(
        string $id,
        string $employeeId,
        string $startDate,
        string $endDate,
        string $createdAt,
        string $updatedAt
    ): WorkEntry
    {
        return new self(
            id: new WorkEntryId($id),
            employeeId: new EmployeeId(
                id: $employeeId
            ),
            startDate: new WorkEntryStartDate(
                value: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $startDate)
            ),
            endDate: new WorkEntryEndDate(
                value: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $endDate)
            ),
            createdAt: new WorkEntryCreatedAt(
                value: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $createdAt)
            ),
            updatedAt: new WorkEntryUpdatedAt(
                value: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $updatedAt)
            )
        );
    }

    public function delete(): void
    {
        $this->deletedAt = new WorkEntryDeletedAt(
            value: new \DateTimeImmutable()
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => (string)$this->id,
            'employeeId' => (string)$this->employeeId,
            'startDate' => (string)$this->startDate,
            'endDate' => (string)$this->endDate,
            'createdAt' => (string)$this->createdAt,
            'updatedAt' => (string)$this->updatedAt,
        ];
    }

    public function startDate(): WorkEntryStartDate
    {
        return $this->startDate;
    }

    public function endDate(): WorkEntryEndDate
    {
        return $this->endDate;
    }

    public function updatedAt(): WorkEntryUpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?WorkEntryDeletedAt
    {
        return $this->deletedAt;
    }
}
