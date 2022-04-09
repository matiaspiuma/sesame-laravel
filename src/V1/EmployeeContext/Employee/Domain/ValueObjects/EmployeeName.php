<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Domain\ValueObjects;

use Api\V1\SharedContext\Domain\ValueObjects\StringValueObject;

final class EmployeeName extends StringValueObject
{
    public function validate(): void
    {
        if (!strlen($this->value)) {
            throw new \InvalidArgumentException('Invalid value');
        }
    }
}
