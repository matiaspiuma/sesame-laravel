<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Domain;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryCreatedAt;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryDeletedAt;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryEndDate;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryStartDate;
use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryUpdatedAt;

final class WorkEntry
{
    public function __construct(
        public readonly EmployeeId $employeeId,
        private WorkEntryId  $id,
        private WorkEntryStartDate $startDate,
        private WorkEntryEndDate $endDate,
        private WorkEntryCreatedAt $createdAt,
        private WorkEntryUpdatedAt $updatedAt,
        private ?WorkEntryDeletedAt $deletedAt = null
    ) {
    }

    public static function create(
        EmployeeId $employeeId,
        WorkEntryId $id,
        WorkEntryStartDate $startDate,
        WorkEntryEndDate $endDate,
    ): WorkEntry {
        $now = new \DateTimeImmutable();

        return new WorkEntry(
            $employeeId,
            $id,
            $startDate,
            $endDate,
            new WorkEntryCreatedAt($now),
            new WorkEntryUpdatedAt($now)
        );
    }

    public function update(
        WorkEntryStartDate $startDate,
        WorkEntryEndDate $endDate,
    ): void {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->updatedAt = new WorkEntryUpdatedAt(new \DateTimeImmutable());
    }

    public static function fromPrimitives(
        string $id,
        string $employeeId,
        string $startDate,
        string $endDate,
        string $createdAt,
        string $updatedAt
    ): WorkEntry {
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
            'id' => $this->id->value(),
            'employeeId' => $this->employeeId()->value(),
            'startDate' => (string) $this->startDate,
            'endDate' => (string) $this->endDate,
            'createdAt' => (string) $this->createdAt,
            'updatedAt' => (string) $this->updatedAt,
        ];
    }

    public function employeeId(): EmployeeId
    {
        return $this->employeeId;
    }

    public function id(): WorkEntryId
    {
        return $this->id;
    }

    public function startDate(): WorkEntryStartDate
    {
        return $this->startDate;
    }

    public function endDate(): WorkEntryEndDate
    {
        return $this->endDate;
    }

    public function createdAt(): WorkEntryCreatedAt
    {
        return $this->createdAt;
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
