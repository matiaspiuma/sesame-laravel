<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects;

use Symfony\Component\Uid\Uuid;

final class WorkEntryId implements \Stringable
{
    public function __construct(
        public readonly string $id
    ) {
        $this->validate($id);
    }

    public static function make(): self
    {
        return new self(
            Uuid::v4()->toRfc4122()
        );
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
