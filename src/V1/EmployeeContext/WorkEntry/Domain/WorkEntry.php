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
use DateTimeImmutable;

final class WorkEntry
{
    public function __construct(
        private WorkEntryId         $id,
        private EmployeeId          $employeeId,
        private WorkEntryStartDate  $startDate,
        private WorkEntryCreatedAt  $createdAt,
        private WorkEntryUpdatedAt  $updatedAt,
        private ?WorkEntryEndDate   $endDate = null,
        private ?WorkEntryDeletedAt $deletedAt = null,
    )
    {
    }

    public function id(): WorkEntryId
    {
        return $this->id;
    }

    public function employeeId(): EmployeeId
    {
        return $this->employeeId;
    }

    public function startDate(): WorkEntryStartDate
    {
        return $this->startDate;
    }

    public function endDate(): ?WorkEntryEndDate
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

    public static function create(
        WorkEntryId        $id,
        WorkEntryStartDate $startDate,
        EmployeeId         $employeeId,
        ?WorkEntryEndDate  $endDate = null,
    ): WorkEntry
    {
        $now = new DateTimeImmutable();

        return new WorkEntry(
            $id,
            $employeeId,
            $startDate,
            new WorkEntryCreatedAt($now),
            new WorkEntryUpdatedAt($now),
            $endDate,
        );
    }

    public function update(
        WorkEntryStartDate $startDate,
        ?WorkEntryEndDate  $endDate = null,
    ): void
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->updatedAt = new WorkEntryUpdatedAt(
            new DateTimeImmutable()
        );
    }

    public function delete(): void
    {
        $this->deletedAt = new WorkEntryDeletedAt(
            new DateTimeImmutable()
        );
    }

    public static function fromPrimitives(
        string  $id,
        string  $employeeId,
        string  $startDate,
        string  $createdAt,
        string  $updatedAt,
        ?string $endDate = null,
        ?string $deletedAt = null,
    ): WorkEntry
    {
        return new self(
            new WorkEntryId($id),
            new EmployeeId($employeeId),
            new WorkEntryStartDate(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $startDate)
            ),
            new WorkEntryCreatedAt(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $createdAt)
            ),
            new WorkEntryUpdatedAt(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $updatedAt)
            ),
            $endDate ? new WorkEntryEndDate(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $endDate)
            ) : null,
            $deletedAt ? new WorkEntryDeletedAt(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $deletedAt)
            ) : null
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id()->value(),
            'employeeId' => $this->employeeId()->value(),
            'startDate' => (string)$this->startDate(),
            'createdAt' => (string)$this->createdAt(),
            'updatedAt' => (string)$this->updatedAt(),
            'endDate' => (string)$this->endDate(),
            'deletedAt' => (string)$this->deletedAt(),
        ];
    }
}
