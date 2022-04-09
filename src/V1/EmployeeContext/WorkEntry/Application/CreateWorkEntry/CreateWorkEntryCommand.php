<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class CreateWorkEntryCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $startDate,
        public readonly string $endDate,
        public readonly string $employeeId,
    ) {
    }
}
