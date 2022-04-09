<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Domain\ValueObjects;

abstract class StringValueObject implements \Stringable
{
    public function __construct(
        public readonly string $value
    )
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
