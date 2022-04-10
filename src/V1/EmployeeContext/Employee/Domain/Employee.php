<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Domain;

use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeCreatedAt;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeDeletedAt;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeName;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeUpdatedAt;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use DateTimeImmutable;

final class Employee
{
    public function __construct(
        private EmployeeId         $id,
        private EmployeeName       $name,
        private EmployeeEmail      $email,
        private EmployeeCreatedAt  $createdAt,
        private EmployeeUpdatedAt  $updatedAt,
        private ?EmployeeDeletedAt $deletedAt = null
    )
    {
    }

    public function id(): EmployeeId
    {
        return $this->id;
    }

    public function name(): EmployeeName
    {
        return $this->name;
    }

    public function email(): EmployeeEmail
    {
        return $this->email;
    }

    public function createdAt(): EmployeeCreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): EmployeeUpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?EmployeeDeletedAt
    {
        return $this->deletedAt;
    }


    public static function create(
        EmployeeId    $id,
        EmployeeName  $name,
        EmployeeEmail $email
    ): Employee
    {
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
        EmployeeName  $name,
        EmployeeEmail $email,
    ): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->updatedAt = new EmployeeUpdatedAt(
            new DateTimeImmutable()
        );
    }

    public function delete(): void
    {
        $this->deletedAt = new EmployeeDeletedAt(
            new DateTimeImmutable()
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
            new EmployeeId($id),
            new EmployeeName($name),
            new EmployeeEmail($email),
            new EmployeeCreatedAt(new DateTimeImmutable($createdAt)),
            new EmployeeUpdatedAt(new DateTimeImmutable($updatedAt))
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
}
