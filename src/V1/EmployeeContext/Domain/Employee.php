<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Domain;

use Api\V1\SharedContext\Domain\Employee\EmployeeId;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeCreatedAt;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeDeletedAt;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeName;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeUpdatedAt;
use Api\V1\SharedContext\Infrastructure\Utils\Arrayable;
use DateTimeImmutable;

final class Employee implements Arrayable
{
    public function __construct(
        public readonly EmployeeId $id,
        private EmployeeName $name,
        private EmployeeEmail $email,
        public readonly EmployeeCreatedAt $createdAt,
        private EmployeeUpdatedAt $updatedAt,
        private ?EmployeeDeletedAt $deletedAt = null
    ) {
    }

    public static function create(
        EmployeeId $id,
        EmployeeName $name,
        EmployeeEmail $email
    ): Employee {

        $now = new DateTimeImmutable();

        return new self(
            $id,
            $name,
            $email,
            new EmployeeCreatedAt($now),
            new EmployeeUpdatedAt($now),
        );
    }

    public function update(
        EmployeeName $name,
        EmployeeEmail $email,
    ): void {
        $this->name = $name;
        $this->email = $email;
        $this->updatedAt = new EmployeeUpdatedAt(new DateTimeImmutable());
    }

    public function delete(): void
    {
        $this->deletedAt = new EmployeeDeletedAt(new DateTimeImmutable());
    }

    public static function fromPrimitives(
        string $id,
        string $name,
        string $email,
        string $createdAt,
        string $updatedAt
    ): Employee {
        return new self(
            id: new EmployeeId($id),
            name: new EmployeeName($name),
            email: new EmployeeEmail($email),
            createdAt: new EmployeeCreatedAt(new DateTimeImmutable($createdAt)),
            updatedAt: new EmployeeUpdatedAt(new DateTimeImmutable($updatedAt))
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => (string) $this->createdAt,
            'updatedAt' => (string) $this->updatedAt,
        ];
    }

    public function name(): EmployeeName
    {
        return $this->name;
    }

    public function email(): EmployeeEmail
    {
        return $this->email;
    }

    public function updatedAt(): EmployeeUpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?EmployeeDeletedAt
    {
        return $this->deletedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => (string) $this->createdAt,
            'updatedAt' => (string) $this->updatedAt,
        ];
    }
}
