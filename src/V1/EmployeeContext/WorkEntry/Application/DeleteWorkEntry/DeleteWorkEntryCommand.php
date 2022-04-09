<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\DeleteWorkEntry;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class DeleteWorkEntryCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id
    )
    {
    }
}
