<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Domain\ValueObjects;

abstract class NullableDateTimeImmutableValueObject implements \Stringable
{
    public function __construct(
        protected ?\DateTimeImmutable $value = null
    ) {
    }

    public function value(): ?\DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return !is_null($this->value)
            ? $this->value->format('Y-m-d H:i:s')
            : '';
    }
}
