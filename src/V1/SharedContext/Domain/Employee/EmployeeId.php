<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Domain\Employee;

use Symfony\Component\Uid\Uuid;
use function PHPUnit\Framework\throwException;

final class EmployeeId implements \Stringable
{
    public function __construct(
        public readonly string $id
    ) {
        $this->validate($id);
    }

    private function validate(string $id): void
    {
        if (!Uuid::isValid($id)) {
            throwException(new \InvalidArgumentException('Employee id is not valid'));
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
