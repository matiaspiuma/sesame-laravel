<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class UpdateWorkEntryCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $startDate,
        public readonly string $endDate
    ) {
    }
}
