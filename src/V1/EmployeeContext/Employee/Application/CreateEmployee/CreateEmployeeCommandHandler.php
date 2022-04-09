<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\CreateEmployee;

use Api\V1\EmployeeContext\Employee\Domain\Employee;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeName;
use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class CreateEmployeeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeCreator $creator
    ) {
    }

    public function __invoke(CreateEmployeeCommand $command): Employee
    {
        return $this->creator->__invoke(
            new EmployeeId($command->id),
            new EmployeeName($command->name),
            new EmployeeEmail($command->email),
        );
    }
}
