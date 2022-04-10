<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\CreateEmployee;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class CreateEmployeeCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email
    )
    {
    }
}
