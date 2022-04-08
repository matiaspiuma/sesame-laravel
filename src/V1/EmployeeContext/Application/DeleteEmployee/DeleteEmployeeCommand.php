<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\DeleteEmployee;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class DeleteEmployeeCommand implements CommandInterface
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
