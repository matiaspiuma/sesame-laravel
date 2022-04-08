<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Domain\ValueObjects;

final class EmployeeEmail implements \Stringable
{
    public function __construct(
        private string $email
    ) {
        $this->validate($email);
    }

    public function value(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    private function validate(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Employee email is not valid');
        }
    }
}
