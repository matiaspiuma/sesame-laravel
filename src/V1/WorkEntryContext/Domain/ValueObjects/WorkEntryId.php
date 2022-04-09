<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Domain\ValueObjects;

final class WorkEntryId implements \Stringable
{
    public function __construct(
        public readonly string $id
    ) {
        $this->validate($id);
    }

    private function validate(string $id): void
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('WorkEntryId cannot be empty');
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
