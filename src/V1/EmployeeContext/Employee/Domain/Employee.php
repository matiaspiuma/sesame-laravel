<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Domain;

use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeCreatedAt;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeDeletedAt;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeName;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeUpdatedAt;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\SharedContext\Infrastructure\Utils\Arrayable;
use DateTimeImmutable;

final class Employee implements Arrayable
{
    public function __construct(
        public                     readonly EmployeeId $id,
        private EmployeeName       $name,
        private EmployeeEmail      $email,
        public                     readonly EmployeeCreatedAt $createdAt,
        private EmployeeUpdatedAt  $updatedAt,
        private ?EmployeeDeletedAt $deletedAt = null
    )
    {
    }

    public static function create(
        EmployeeId    $id,
        EmployeeName  $name,
        EmployeeEmail $email
    ): Employee
    {
        $now = new DateTimeImmutable();

        return new self(
            id: $id,
            name: $name,
            email: $email,
            createdAt: new EmployeeCreatedAt($now),
            updatedAt: new EmployeeUpdatedAt($now),
        );
    }

    public function update(
        EmployeeName  $name,
        EmployeeEmail $email,
    ): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->updatedAt = new EmployeeUpdatedAt(
            value: new DateTimeImmutable()
        );
    }

    public function delete(): void
    {
        $this->deletedAt = new EmployeeDeletedAt(
            value: new DateTimeImmutable()
        );
    }

    public static function fromPrimitives(
        string $id,
        string $name,
        string $email,
        string $createdAt,
        string $updatedAt
    ): Employee
    {
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
            'id' => $this->id->value(),
            'name' => $this->name()->value(),
            'email' => $this->email()->value(),
            'createdAt' => (string)$this->createdAt,
            'updatedAt' => (string)$this->updatedAt,
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
            'id' => $this->id->value(),
            'name' => $this->name()->value(),
            'email' => $this->email()->value(),
            'createdAt' => $this->createdAt->value(),
            'updatedAt' => $this->updatedAt()->value(),
        ];
    }
}
