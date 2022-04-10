<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\DeleteEmployee;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class DeleteEmployeeCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id
    )
    {
    }
}
