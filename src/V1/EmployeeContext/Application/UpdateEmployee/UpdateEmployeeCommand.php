<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\UpdateEmployee;

use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;

final class UpdateEmployeeCommand implements CommandInterface
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}
