<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\DeleteWorkEntry;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class DeleteWorkEntryCommand implements CommandInterface
{
    public function __construct(
        private string $id
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
}
