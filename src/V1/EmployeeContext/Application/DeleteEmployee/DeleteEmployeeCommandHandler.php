<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Application\DeleteEmployee;

use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;
use Api\V1\SharedContext\Domain\Employee\EmployeeId;

final class DeleteEmployeeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeDeletor $employeeDelector
    ) {
    }

    public function __invoke(DeleteEmployeeCommand $command): void
    {
        $this->employeeDelector->__invoke(
            employeeId: new EmployeeId($command->id()),
        );
    }
}
