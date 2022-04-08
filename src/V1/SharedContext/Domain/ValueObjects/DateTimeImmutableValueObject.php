<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Domain\ValueObjects;

abstract class DateTimeImmutableValueObject implements \Stringable
{
    public function __construct(
        protected \DateTimeImmutable $value
    ) {
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format('Y-m-d H:i:s');
    }
}
