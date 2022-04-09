<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Domain\ValueObjects;

use Api\V1\SharedContext\Domain\ValueObjects\StringValueObject;

final class EmployeeEmail extends StringValueObject
{
    public function __construct(
        private string $email
    ) {
        $this->validate(value: $email);

        parent::__construct($email);
    }

    private function validate(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email is not valid');
        }
    }
}
