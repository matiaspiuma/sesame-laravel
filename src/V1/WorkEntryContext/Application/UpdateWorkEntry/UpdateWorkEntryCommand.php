<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\UpdateWorkEntry;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class UpdateWorkEntryCommand implements CommandInterface
{
    public function __construct(
        private string $id,
        private string $startDate,
        private string $endDate
    ) {
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
