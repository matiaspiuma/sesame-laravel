<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\UpdateEmployee;

use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeEmail;
use Api\V1\EmployeeContext\Employee\Domain\ValueObjects\EmployeeName;
use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;

final class UpdateEmployeeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeUpdator $employeeUpdator
    ) {
    }

    public function __invoke(UpdateEmployeeCommand $command): void
    {
        $this->employeeUpdator->__invoke(
            new EmployeeId($command->id()),
            new EmployeeName($command->name()),
            new EmployeeEmail($command->email()),
        );
    }
}
