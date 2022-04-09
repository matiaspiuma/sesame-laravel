<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Domain\ValueObjects;

use Api\V1\SharedContext\Domain\ValueObjects\StringValueObject;

final class EmployeeEmail extends StringValueObject
{
    public function validate(): void
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email is not valid');
        }
    }
}
