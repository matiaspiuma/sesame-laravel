<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class CreateWorkEntryCommand implements CommandInterface
{
    public function __construct(
        private string $employeeId,
        private string $id,
        private string $startDate,
        private string $endDate,
    ) {
    }

    public function EmployeeId(): string
    {
        return $this->employeeId;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function startDate(): string
    {
        return $this->startDate;
    }

    public function endDate(): string
    {
        return $this->endDate;
    }
}
