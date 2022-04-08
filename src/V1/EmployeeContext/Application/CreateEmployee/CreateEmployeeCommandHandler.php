<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\CreateEmployee;

use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Domain\ValueObjects\EmployeeName;
use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;

final class CreateEmployeeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeCreator $employeeCreator
    ) {
    }

    public function __invoke(CreateEmployeeCommand $command): void
    {
        $this->employeeCreator->__invoke(
            new EmployeeId($command->id()),
            new EmployeeName($command->name()),
            new EmployeeEmail($command->email()),
        );
    }
}
