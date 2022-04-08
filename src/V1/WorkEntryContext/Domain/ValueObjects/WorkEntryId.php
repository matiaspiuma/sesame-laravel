<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Domain\ValueObjects;

final class WorkEntryId
{
    public function __construct(
        private string $id
    ) {
        $this->validate($id);
    }

    public function value(): string
    {
        return $this->id;
    }

    private function validate(string $id): void
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('WorkEntryId cannot be empty');
        }
    }
}
